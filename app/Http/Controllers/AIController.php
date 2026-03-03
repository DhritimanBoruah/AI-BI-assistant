<?php
namespace App\Http\Controllers;

use App\Services\OllamaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AIController extends Controller
{
    protected $ollama;

    public function __construct(OllamaService $ollama)
    {
        $this->ollama = $ollama;
    }

    public function ask(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'question' => 'required|string',
        ]);

        $question = $request->input('question');

        // ✅ Real Database Schema (MATCHES YOUR DB)
        $schema = "
                Tables:

                members(
                    id INT,
                    name VARCHAR,
                    status VARCHAR,
                    created_at DATETIME,
                    updated_at DATETIME
                )

                payments(
                    id INT,
                    member_id INT,
                    amount DECIMAL,
                    payment_date DATE,
                    created_at DATETIME,
                    updated_at DATETIME
                )

                tickets(
                    id INT,
                    title VARCHAR,
                    status VARCHAR,
                    created_at DATETIME,
                    updated_at DATETIME
                )
                ";

        $prompt = "
                You are an expert MySQL query generator.

                Rules:
                - Use MySQL syntax only.
                - Use CURDATE() for today's date.
                - payment_date is DATE type.
                - created_at is DATETIME.
                - If the question asks to modify, delete, update, insert, or change data,
                respond exactly with: NOT_ALLOWED
                - Otherwise generate SELECT query.
                - Never use columns that are not listed.
                - No explanation.
                - No markdown.
                - No backticks.
                - Return plain SQL only.

                Database schema:
                $schema

                Question: $question
                ";

        // ✅ Ask AI
        $sql = $this->ollama->ask($prompt);

        if (empty($sql)) {
            return response()->json([
                'error' => 'AI did not return SQL.',
            ], 400);
        }

        // ✅ Clean AI output
        $sql = trim($sql);
        $sql = str_replace(['```sql', '```'], '', $sql);
        $sql = trim($sql);

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
                    'error' => 'I am not allowed to perform this operation.',
                    'sql'   => $sql,
                ], 400);
            }
        }

        // ✅ Execute Query Safely
        try {
            $result = DB::select($sql);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Database error',
                'message' => $e->getMessage(),
                'sql'     => $sql,
            ], 500);
        }

        // ✅ Normalize Aggregate Output
        if (count($result) === 1 && count((array) $result[0]) === 1) {
            $value = array_values((array) $result[0])[0];

            return response()->json([
                'sql'   => $sql,
                'type'  => 'aggregate',
                'value' => $value,
            ]);
        }

        return response()->json([
            'sql'  => $sql,
            'type' => 'table',
            'data' => $result,
        ]);
    }
}
