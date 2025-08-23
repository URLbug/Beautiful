<?php

namespace App\Modules\Admin\Controllers;

use App\Interfaces\Repository\RepositoryInterface;
use App\Modules\Master\Lib\TableValidatorService;
use App\Modules\S3Storage\Lib\S3Storage;
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
            return $this->create($request, $data['validator'], $data['repository']);
        }

        if($request->isMethod('PATCH')) {
            return $this->update($request, $data['validator'], $data['repository']);
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

    public function update(
        Request $request,
        array $validation,
        RepositoryInterface $repository
    ): RedirectResponse {
        $data = $request->validate($validation);

        if($request->has('picture')) {
            $data['picture'] = $this->saveFile($data['picture']);
        }

        if($request->has('file')) {
            $data['file'] = $this->saveFile($data['file']);
        }

        if($request->has('id')) {
            $data['id'] = $request->get('id');
        }

        $isUpdate = false;
        try {
            $isUpdate = $repository::update($data);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        if($isUpdate === false || $isUpdate === 0) {
            return back()->withErrors('Can`t be update element');
        }

        $url = explode('?', url()->current());
        return redirect($url[0])
            ->with('success', 'Created update is complete!');
    }

    public function create(
        Request $request,
        array $validation,
        RepositoryInterface $repository,
    ): RedirectResponse {
        $data = $request->validate($validation);

        if($request->has('picture')) {
            $data['picture'] = $this->saveFile($data['picture']);
        }

        if($request->has('file')) {
            $data['file'] = $this->saveFile($data['file']);
        }

        $isSave = false;
        try {
            $isSave = $repository::save($data);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        if(!$isSave) {
            return back()->withErrors('Can`t be created element');
        }

        $url = explode('?', url()->current());
        return redirect($url[0])
            ->with('success', 'Created element is complete!');
    }

    public function getData(Request $request, string $table, RepositoryInterface $repository): array
    {
        $model = null;
        if($request->has('id') && $request->get('id') > 0) {
            $model = $repository::getById($request->get('id'));
        }

        $data = [
            'method' => 'POST',
            'items' => [],
            'validator' => (new TableValidatorService)->generateValidationRulesTable($table),
            'repository' => $repository,
        ];

        $columns = Schema::getColumnListing($table);
        foreach($columns as $column) {
            $type = Schema::getColumnType($table, $column);

            if($column == 'id' || $column === 'created_at' || $column === 'updated_at') {
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
            foreach($model->toArray() as $fillable => $item) {
                if(!isset($data['items'][$fillable])) {
                    continue;
                }

                $data['items'][$fillable] = array_merge(
                    $data['items'][$fillable],
                    ['value' => $item,]
                );
            }
        }

        return $data;
    }

    private function saveFile($file)
    {
        if($file) {
            if(!S3Storage::putFile('/', $file)) {
                return back()->withErrors("Update profile data failed");
            }

            $file = S3Storage::getFile($file->hashName());
        }

        return $file;
    }
}
