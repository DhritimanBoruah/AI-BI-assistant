<?php
namespace App\Http\Controllers;

use App\Services\OllamaService;
use App\Services\SchemaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AIController extends Controller
{
    protected $ollama;
    protected $schemaService;

    public function __construct(OllamaService $ollama, SchemaService $schemaService)
    {
        $this->ollama        = $ollama;
        $this->schemaService = $schemaService;
    }

    public function ask(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'question' => 'required|string',
        ]);

        $question = $request->input('question');

        // ✅ Redis caching key-----------------------------------------------------

        $cacheKey = 'ai_question_' . md5($question);

        if (Cache::has($cacheKey)) {
            return response()->json([
                'source' => 'cache',
                'data'   => Cache::get($cacheKey),
            ]);
        }

        // ✅ Redis caching key end -------------------------------------------------

        $schema = $this->schemaService->getFormattedSchema();

        // ✅ Single AI Call Prompt (SQL + Explanation)
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
                - If modification is requested, return:
                {\"sql\":\"NOT_ALLOWED\",\"explanation\":\"Operation not permitted.\"}
                - Use only tables and columns from schema.
                - No markdown.
                - No backticks.
                - No extra commentary.
                - Valid JSON only.

                Database schema:
                $schema

                User question:
                $question
                ";

        // ✅ Ask AI (Single Call)
        $response = $this->ollama->ask($prompt);

        if (empty($response)) {
            return response()->json([
                'error' => 'AI did not return a response. Please try Again.',
            ], 500);
        }

        // ✅ Decode JSON
        $data = json_decode(trim($response), true);

        if (! $data || ! isset($data['sql'])) {
            return response()->json([
                'error' => 'Invalid AI response format.',
                'raw'   => $response,
            ], 500);
        }

        $sql         = trim($data['sql']);
        $explanation = $data['explanation'] ?? null;
        $data        = json_decode(trim($response), true);

        // ✅ Handle NOT_ALLOWED
        if ($sql === 'NOT_ALLOWED') {
            return response()->json([
                'error' => 'Operation not permitted.',
            ], 400);
        }

        // ✅ Allow ONLY SELECT queries
        if (! str_starts_with(strtolower($sql), 'select')) {
            return response()->json([
                'error' => 'Only SELECT queries are allowed.',
                'sql'   => $sql,
            ], 400);
        }

        // ✅ Block Dangerous Keywords
        $forbidden = [
            'insert',
            'update',
            'delete',
            'drop',
            'alter',
            'truncate',
            'create',
            'replace',
            'grant',
            'revoke',
        ];

        foreach ($forbidden as $word) {
            if (str_contains(strtolower($sql), $word)) {
                return response()->json([
                    'error' => 'Forbidden SQL operation detected.',
                    'sql'   => $sql,
                ], 400);
            }
        }

        // ✅ Execute Query
        try {
            $result = DB::select($sql);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Database error.',
                'message' => $e->getMessage(),
                'sql'     => $sql,
            ], 500);
        }

        // ✅ Normalize response
        $responseData = [
            'sql'         => $sql,
            'explanation' => $explanation,
        ];
        


        

        if (count($result) === 1 && count((array) $result[0]) === 1) {
            // Single aggregate
            $responseData['type']  = 'aggregate';
            $responseData['value'] = array_values((array) $result[0])[0];
        } else {
            // Table result
            $responseData['type'] = 'table';
            $responseData['data'] = $result;
        }

        // ✅ Cache for 1 hour
        Cache::put($cacheKey, $responseData, now()->addHour());

        return response()->json($responseData);
    }
}
