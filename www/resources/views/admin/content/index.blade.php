@extends('app.admin')

@section('content')

    <!-- Content -->
    <div class="mb-3">
        <a href="{{ route($route, ['create' => 'Y',]) }}" class="btn btn-primary text-decoration-none">
            <span>Создать элемент</span>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        @foreach($fillables as $fillable)
                            <th class="p-3 text-start text-uppercase">
                                <small class="fw-medium">{{ $fillable }}</small>
                            </th>
                        @endforeach
                        <th class="p-3 text-end text-uppercase">
                            <small class="fw-medium">Действия</small>
                        </th>
                    </tr>
                    </thead>
                    @if(isset($contents) && $contents->count() > 0)
                        <tbody>
                        @foreach($contents as $content)
                            <tr data-element="">
                                @foreach($content->toArray() as $fillable => $column)
                                    <td class="p-3 align-top">
                                        <div class="text-break" style="max-width: 300px;">
                                            @switch($fillable)
                                                @case('description')
                                                    <span class="d-inline-block text-truncate" style="max-width: 300px;" title="{{ $column }}">
                                                        {{ Str::limit($column, 100) }}
                                                    </span>
                                                    @break

                                                @case('active')
                                                    <span class="badge {{ $column ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $column ? 'Да' : 'Нет' }}
                                                    </span>
                                                    @break

                                                @case('user')
                                                    <small>{{ $column['username'] ?? '' }}</small>
                                                    @break

                                                @default
                                                    @if(is_array($column) || is_object($column))
                                                        <details>
                                                            <summary class="cursor-pointer text-primary text-decoration-underline">Данные по обратной связи</summary>
                                                            <pre class="mt-2 p-2 bg-light border rounded small text-muted" style="white-space: pre-wrap; word-break: break-all;">
                                                                {{ json_encode($column, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                                            </pre>
                                                        </details>
                                                        @break
                                                    @endif

                                                    @if(in_array($fillable, $fillables))
                                                            {{ $column ?? '' }}
                                                    @endif
                                            @endswitch
                                        </div>
                                    </td>
                                @endforeach
                                <td class="p-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="" class="btn btn-sm btn-primary">
                                            <span class="d-none d-sm-inline">Редактировать</span>
                                            <i class="fas fa-edit d-sm-none"></i>
                                        </a>
                                        <a data-href="" class="delete-btn btn btn-sm btn-danger">
                                            <span class="d-none d-sm-inline">Удалить</span>
                                            <i class="fas fa-trash d-sm-none"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>

    @if(isset($content) && $contents->count() > 0)
        <div class="text-center mt-5">
            <nav>
                @if($currentPage !== 1)
                    <a href="{{ route($route) }}?page={{ $currentPage - 1 }}" class="btn btn-primary">&laquo;</a>
                @endif

                @for($i=1; $i < $lastPage+1; $i++)
                    @if($currentPage === $i)
                        <a href="{{ route($route) }}?page={{ $i }}" class="btn btn-primary">{{ $i }}</a>
                        @continue
                    @endif

                    <a href="{{ route($route) }}?page={{ $i }}" class="btn btn-primary">{{ $i }}</a>
                @endfor

                @if($currentPage !== $lastPage)
                    <a href="{{ route($route) }}?page={{ $currentPage + 1}}" class="btn btn-primary">&raquo;</a>
                @endif
            </nav>
        </div>
    @endif
@endsection
