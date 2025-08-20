<?php

namespace App\Modules\Master\Lib;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class TableValidatorService
{
    protected $types = [
        'string' => 'text',
        'text' => 'textarea',
        'integer' => 'number',
        'bigint' => 'number',
        'float' => 'number',
        'double' => 'number',
        'decimal' => 'number',
        'boolean' => 'checkbox',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'datetime',
        'json' => 'object',
    ];

    public function generateValidationRulesTable(string $table, $ignoreId = null): array
    {
        $rules = [];
        $columns = Schema::getColumnListing($table);

        foreach ($columns as $column) {
            if ($column === 'id' || $column === 'created_at' || $column === 'updated_at') {
                continue;
            }

            $rules[$column] = $this->generateValidationRules($table, $column);

            foreach ($rules[$column] as $key => $rule) {
                if (is_string($rule) && strpos($rule, 'unique:') === 0 && $ignoreId) {
                    $rules[$column][$key] = Rule::unique($table, $column)->ignore($ignoreId);
                }
            }
        }

        return $rules;
    }

    protected function generateValidationRules(string $table, string $column): array
    {
        $rules = [];
        $type = Schema::getColumnType($table, $column);

        switch ($type) {
            case 'integer':
            case 'bigint':
                $rules[] = 'integer';
                break;
            case 'float':
            case 'double':
            case 'decimal':
                $rules[] = 'numeric';
                break;
            case 'boolean':
                $rules[] = 'boolean';
                break;
            case 'date':
                $rules[] = 'date';
                break;
            case 'datetime':
            case 'timestamp':
                $rules[] = 'date_format:Y-m-d H:i:s';
                break;
            case 'json':
                $rules[] = 'json';
                break;
            default:
                if(in_array($column, ['picture', 'file'])) {
                    $rules[] = 'image';
                    $rules[] = 'max:30004';
                } else {
                    $rules[] = 'string';
                }
        }

        $nullable = $this->isColumnNullable($table, $column);
        if (!$nullable) {
            array_unshift($rules, 'required');
        } else {
            $rules[] = 'nullable';
        }

        if (in_array($type, ['string', 'text'])) {
            $maxLength = $this->getColumnMaxLength($table, $column);
            if ($maxLength) {
                $rules[] = "max:{$maxLength}";
            }
        }

        if ($column !== 'id' && $this->isColumnUnique($table, $column)) {
            $rules[] = 'unique:' . $table . ',' . $column;
        }

        return $rules;
    }

    protected function isColumnNullable(string $table, string $column): bool
    {
        if(!Schema::hasColumn($table, $column)) {
            return false;
        }

        $columnsSchema = Schema::getColumns($table);
        foreach($columnsSchema as $columnSchema) {
            if($columnSchema['name'] === $column) {
                return $columnSchema['nullable'];
            }
        }

        return false;
    }

    protected function getColumnMaxLength(string $table, string $column): ?int
    {
        if(!Schema::hasColumn($table, $column)) {
            return null;
        }

        $columnsSchema = Schema::getColumns($table);
        foreach($columnsSchema as $columnSchema) {
            if($columnSchema['name'] === $column) {
                if($columnSchema['type_name'] == 'varchar') {
                    $number = str_replace('varying(', $columnSchema['type']);
                    $number = str_replace(')', '', $number);

                    return (int)$number;
                }

                return 255;
            }
        }

        return null;
    }

    protected function isColumnUnique(string $table, string $column): bool
    {
        if(!Schema::hasColumn($table, $column)) {
            return false;
        }

        $columnsSchema = Schema::getColumns($table);
        foreach($columnsSchema as $columnSchema) {
            if($columnSchema['name'] === $column) {
                return str_contains('unique', $columnSchema['type']) || (isset($columnSchema['unique']) && $columnSchema['unique']);
            }
        }

        return false;
    }
}
