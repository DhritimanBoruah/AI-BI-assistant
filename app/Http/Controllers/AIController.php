<?php
namespace App\Http\Controllers;

use App\Services\OllamaService;
use App\Services\SchemaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    protected $ollama;
    protected $schemaService;

    public function __construct(OllamaService $ollama, SchemaService $schemaService)
    {
        $this->ollama        = $ollama;
        $this->schemaService = $schemaService;
    }

    /**
     * Fetch the most recent query history for the sidebar
     */
    // public function getHistory()
    // {
    //     try {
    //         $history = DB::table('ai_query_logs')
    //             ->select('question', 'created_at')
    //             ->orderBy('created_at', 'desc')
    //             ->limit(10)
    //             ->get();

    //         return response()->json($history);
    //     } catch (\Exception $e) {
    //         return response()->json([]);
    //     }
    // }

    public function ask(Request $request)
    {
        // ⏱️ 1. Start Execution Timer
        $startTime = microtime(true);

        // ✅ Validate input
        $request->validate([
            'question' => 'required|string',
        ]);

        $question = $request->input('question');

        // ✅ Redis Cache Key
        $cacheKey = 'ai_question_' . md5($question);

        if (Cache::has($cacheKey)) {
            $cachedData                   = Cache::get($cacheKey);
            $cachedData['execution_time'] = 'cached';

            // Log the fact that we served a cached result
            $this->logQuery($question, $cachedData['sql'] ?? 'CACHED', $startTime, 'cache_hit');

            return response()->json([
                'source' => 'cache',
                'data'   => $cachedData,
            ]);
        }

        // ✅ Get Database Schema
        $schema = $this->schemaService->getFormattedSchema();

        // ✅ AI Prompt
        $prompt = "
You are an AI Business Intelligence engine.
Return ONLY valid JSON in this exact structure:
{
\"sql\": \"<mysql_select_query>\",
\"explanation\": \"<professional_business_explanation>\"
}
STRICT RULES:
- Only generate SELECT queries.
- Never generate INSERT, UPDATE, DELETE, DROP, ALTER, TRUNCATE, CREATE.
- If modification is requested, return: {\"sql\":\"NOT_ALLOWED\",\"explanation\":\"Operation not permitted.\"}
- Use only tables and columns from schema.
- No markdown, no backticks, no commentary.
Database schema:
$schema
User question:
$question
";

        // ✅ Ask AI
        $response = $this->ollama->ask($prompt);
        Log::info('Ollama Raw Response: ' . $response);

        if (empty($response)) {
            return response()->json(['error' => 'AI engine is offline.'], 500);
        }

        // ✅ Clean and Decode JSON
        $cleanResponse = trim(preg_replace('/^```json\s*|```$/i', '', $response));
        $data          = json_decode($cleanResponse, true);

        if (json_last_error() !== JSON_ERROR_NONE || ! isset($data['sql'])) {
            return response()->json(['error' => 'Invalid AI JSON format.', 'raw' => $response], 500);
        }

        $sql         = trim($data['sql']);
        $explanation = $data['explanation'] ?? null;

        // ✅ Security Check
        if ($sql === 'NOT_ALLOWED' || ! str_starts_with(strtolower($sql), 'select')) {
            $this->logQuery($question, $sql, $startTime, 'denied');
            return response()->json(['error' => 'Operation not permitted or non-SELECT query generated.'], 400);
        }

        $forbidden = ['insert', 'update', 'delete', 'drop', 'alter', 'truncate', 'create', 'replace'];
        foreach ($forbidden as $word) {
            if (str_contains(strtolower($sql), $word)) {
                $this->logQuery($question, $sql, $startTime, 'forbidden');
                return response()->json(['error' => 'Forbidden SQL operation detected.'], 400);
            }
        }

        // ✅ Execute Query
        try {
            $result = DB::select($sql);
        } catch (\Exception $e) {
            $this->logQuery($question, $sql, $startTime, 'db_error');
            return response()->json([
                'error'   => 'Database error.',
                'message' => $e->getMessage(),
                'sql'     => $sql,
            ], 500);
        }

        // ✅ Normalize Response
        $responseData = [
            'sql'         => $sql,
            'explanation' => $explanation,
        ];

        if (count($result) === 1 && count((array) $result[0]) === 1) {
            $responseData['type']  = 'aggregate';
            $responseData['value'] = array_values((array) $result[0])[0];
        } else {
            $responseData['type'] = 'table';
            $responseData['data'] = $result;
        }

        // ✅ Chart.js Logic
        if (! empty($result)) {
            $firstRow       = (array) $result[0];
            $columns        = array_keys($firstRow);
            $numericColumns = [];
            foreach ($firstRow as $col => $val) {
                if (is_numeric($val) && ! in_array(strtolower($col), ['year', 'id', 's_a_id', 'std_id'])) {
                    $numericColumns[] = $col;
                }
            }
            $responseData['chartable']         = count($numericColumns) > 0;
            $responseData['available_metrics'] = $numericColumns;
            $responseData['labels']            = collect($result)->pluck($columns[0]);
            $responseData['rawData']           = $result;
        }

        // ⏱️ 2. Finalize Execution Time
        $executionTime                  = round((microtime(true) - $startTime) * 1000, 2);
        $responseData['execution_time'] = $executionTime . 'ms';

        // 📝 3. Log to Database History
        $this->logQuery($question, $sql, $startTime, $responseData['type']);

        // ✅ Cache and Return
        Cache::put($cacheKey, $responseData, now()->addHour());
        return response()->json($responseData);
    }

    /**
     * Helper to log query history and tracking
     */
    private function logQuery($question, $sql, $startTime, $type)
{
    try {
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);
        $userId = auth()->check() ? auth()->id() : null;

        // ✅ Use updateOrInsert to prevent duplicate questions for the same user
        DB::table('ai_query_logs')->updateOrInsert(
            [
                'user_id'  => $userId,
                'question' => trim($question), // Match based on user and question
            ],
            [
                'sql_query'         => $sql,
                'execution_time_ms' => $executionTime,
                'result_type'       => $type,
                'updated_at'        => now(),
                // 'created_at' is handled automatically by updateOrInsert if it's a new record
            ]
        );
    } catch (\Exception $e) {
        Log::error("Failed to log AI query: " . $e->getMessage());
    }
}

    public function getHistory()
    {
        try {
            // Updated to fetch more records and handle duplicates for autocomplete
            $history = DB::table('ai_query_logs')
                ->select('question', 'created_at', 'execution_time_ms')
                ->distinct('question')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            return response()->json($history);
        } catch (\Exception $e) {
            Log::error("History fetch error: " . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Provide live smart suggestions based on keywords
     */
    public function getSuggestions(Request $request)
    {
        $q           = strtolower($request->query('q', ''));
        $suggestions = [];

        if (empty($q)) {
            return response()->json([]);
        }

        // 1. Smart Logic for Student Attendance Table
        if (str_contains($q, 'att') || str_contains($q, 'std') || str_contains($q, 'pres')) {
            $suggestions[] = "Show student attendance status for today";
            $suggestions[] = "Which students were absent yesterday?";
            $suggestions[] = "Show attendance percentage by class";
        }

        // 2. Smart Logic for Financials/Revenue
        if (str_contains($q, 'rev') || str_contains($q, 'earn') || str_contains($q, 'pay')) {
            $suggestions[] = "What is the total revenue for this month?";
            $suggestions[] = "Show revenue trends for the last 6 months";
        }

        // 3. Smart Logic for General Fleet (Ambulance/Bookings)
        if (str_contains($q, 'amb') || str_contains($q, 'book') || str_contains($q, 'fleet')) {
            $suggestions[] = "List all active ambulance bookings";
            $suggestions[] = "Show me the most busy ambulance type";
        }

        // Return unique results
        return response()->json(array_values(array_unique($suggestions)));
    }
}
