@extends('app.admin')

@php
    $fillables = isset($contents) && $contents->count() > 0 ? array_keys($contents[0]->toArray()) : $fillables;
@endphp

@section('content')

    <!-- Actions -->
    <div class="mb-3">
        <a href="{{ route($route, ['create' => 'Y']) }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create new element
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                    <tr>
                        @foreach($fillables as $fillable)
                            <th class="px-3 py-2 text-start text-uppercase small fw-medium">
                                {{ $fillable }}
                            </th>
                        @endforeach
                        <th class="px-3 py-2 text-end text-uppercase small fw-medium">Actions</th>
                    </tr>
                    </thead>

                    @if(isset($contents) && $contents->count() > 0)
                        <tbody>
                        @foreach($contents as $content)
                            <tr>
                                @foreach($content->toArray() as $fillable => $column)
                                    <td>
                                        <div class="cell-text">
                                            @if(is_array($column) || is_object($column))
                                                <details>
                                                    <summary class="text-primary text-decoration-underline cursor-pointer">
                                                        Данные по обратной связи
                                                    </summary>
                                                    <pre class="json-block mt-2 p-2 bg-light border rounded small text-muted">
                                                        {{ json_encode($column, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                                    </pre>
                                                </details>
                                            @else
                                                @if(in_array($fillable, $fillables))
                                                    {{ $column ?? '' }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endforeach

                                <td class="px-3 py-2 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route($route, ['update' => 'Y', 'id' => $content->id]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                        </a>
                                        <a data-href="" class="delete-btn btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            <span class="d-none d-sm-inline">Remove</span>
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

    <!-- Pagination -->
    @if(isset($contents) && $contents->count() > 0)
        <div class="mt-4 d-flex justify-content-center">
            <nav>
                <ul class="pagination mb-0">
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route) }}?page={{ $currentPage - 1 }}">&laquo;</a>
                        </li>
                    @endif

                    @for($i = 1; $i <= $lastPage; $i++)
                        <li class="page-item {{ $currentPage === $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ route($route) }}?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if($currentPage < $lastPage)
                        <li class="page-item">
                            <a class="page-link" href="{{ route($route) }}?page={{ $currentPage + 1 }}">&raquo;</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif

@endsection
