<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SchemaService
{
    public function getFormattedSchema()
    {
        $database = DB::getDatabaseName();

        // Get all tables
        $tables = DB::select("SHOW TABLES");

        $schemaText = "Tables:\n\n";

        foreach ($tables as $tableObj) {

            $tableName = array_values((array)$tableObj)[0];

            // Skip Laravel internal tables if you want
            if (in_array($tableName, ['migrations', 'cache', 'jobs', 'failed_jobs', 'users'])) {
                continue;
            }

            $columns = DB::select("DESCRIBE {$tableName}");

            $schemaText .= $tableName . "(\n";

            foreach ($columns as $column) {
                $schemaText .= "    {$column->Field} {$column->Type},\n";
            }

            $schemaText = rtrim($schemaText, ",\n") . "\n)\n\n";
        }

        return $schemaText;
    }
}