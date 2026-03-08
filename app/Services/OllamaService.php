<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    protected $baseUrl = 'http://127.0.0.1:11434/api/generate';

    public function ask($userQuestion)
    {
        // Define your schema so the AI doesn't guess column names
        $systemPrompt = "You are a SQL expert for a MariaDB database. 
        Table 'payments' columns: id, member_id, amount, payment_date (YYYY-MM-DD).
        Table 'student_attendance' columns: s_a_id, std_id, std_c_id, c_t_id, sub_t_id, attendance_status, created_at.
        Rules:
        1. Only return valid MariaDB SQL.
        2. Always use 'BETWEEN' for date ranges, never 'BETWE0N'.
        3. Return a JSON object with 'sql' and 'explanation' keys.
        4. Do not include markdown code blocks in the JSON string.";

        $fullPrompt = "System: $systemPrompt \nUser: $userQuestion";

        $response = Http::timeout(120)->post($this->baseUrl, [
            'model' => 'phi3:mini',
            'prompt' => $fullPrompt,
            'stream' => false,
            'format' => 'json', // Forces the model to output valid JSON
        ]);

        if ($response->successful()) {
            $rawResponse = $response->json()['response'];
            
            // Post-processing: Emergency fix for common LLM typos
            $rawResponse = str_ireplace('BETWE0N', 'BETWEEN', $rawResponse);
            
            return $rawResponse;
        }

        return null;
    }
}