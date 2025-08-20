<?php

namespace App\Modules\Admin\Controllers;

use App\Interfaces\Repository\RepositoryInterface;
use App\Modules\Master\Lib\TableValidatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

abstract class Controller
{
    private array $types = [
        'int' => 'number',
        'varchar' => 'text',
        'jsonb' => 'object',
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



    public function index(Request $request, array $data = []): View|RedirectResponse|null
    {
        if($request->isMethod('GET')) {
            if(
                ($request->has('create') && $request->get('create') === 'Y') ||
                ($request->has('update') && $request->get('update') === 'Y')
            ) {
                return $this->show($data);
            }
        }

        if($request->isMethod('POST')) {
            return $this->create($request, $data['validator']);
        }

        return null;
    }

    public function show(array $data): View
    {
        if(!isset($data['items']) || count($data['items']) === 0) {
            throw new \LogicException('Not found item');
        }

        return view('admin.content.detail', data: $data);
    }

    public function create(Request $request, array $validation): RedirectResponse
    {
        dd($request->all(), $validation);
    }

    public function getData(Request $request, string $table, RepositoryInterface $repository): array
    {
        $model = null;
        if($request->has('id') && $request->get('id') > 0) {
            $model = $repository::getAll($request->get('id'));
        }

        $data = [
            'method' => 'POST',
            'items' => [],
            'validator' => (new TableValidatorService)->generateValidationRulesTable($table),
        ];

        $columns = Schema::getColumnListing($table);
        foreach($columns as $column) {
            $type = Schema::getColumnType($table, $column);

            if ($column === 'created_at' || $column === 'updated_at') {
                continue;
            }

            if(str_contains($type, 'int')) {
                $type = 'number';
            } else {
                $type = $this->types[$type];
            }

            $data['items'][$column]['column'] = $column;
            $data['items'][$column]['type'] = $type;
        }

        if($model) {
            $data['method'] = 'PATCH';
            foreach($model->first()->toArray() as $fillable => $item) {
                $data['items'][$fillable] = array_merge(
                    $data['items'][$fillable],
                    ['value' => $item,]
                );
            }
        }

        return $data;
    }
}
