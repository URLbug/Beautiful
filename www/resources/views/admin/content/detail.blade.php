@extends('app.admin')

@section('content')
    <div class="p-4">
        <form method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
            @csrf
            @method($method)
            <div class="row">
                <div class="col-lg-8">
                    @foreach($items as $item)
                        @switch($item['type'])
                            @case('textarea')
                                <div class="mb-3">
                                    <label class="form-label">{{ $item['column'] }}</label>
                                    <textarea rows="8"
                                              name="description"
                                              class="form-control">{{ $item['value'] ?? '' }}</textarea>
                                </div>
                                @break
                            @case('text')
                                @if(!in_array($item['column'], ['picture', 'file',]))
                                    <div class="mb-3">
                                        <label class="form-label">{{ $item['column'] }}</label>
                                        <input type="text"
                                               name="title"
                                               value="{{ $item['value'] ?? '' }}"
                                               class="form-control">
                                    </div>
                                @else
                                    <div class="bg-light p-4 rounded mb-3">
                                        <h3 class="h6 fw-semibold text-dark mb-3">{{ $item['column'] }}</h3>

                                        <!-- Превью изображения -->
                                        <div id="imagePreview" class="mb-3 text-center">
                                            <img id="previewImage"
                                                 src=""
                                                 alt="Preview Image"
                                                 class="img-fluid rounded border" style="max-height: 200px; display: none;">

                                            <button type="button" id="removeImage"
                                                    class="btn btn-sm btn-outline-danger mt-2" style="display: none;">
                                                <i class="fas fa-trash me-1"></i> Delete file
                                            </button>
                                        </div>

                                        <!-- Контейнер для загрузки -->
                                        <div class="border border-2 border-dashed rounded p-4 text-center position-relative"
                                             id="uploadContainer" style="cursor: pointer;">
                                            <input type="file"
                                                   id="uploadFile"
                                                   name="uploadFile"
                                                   accept="image/*"
                                                   class="position-absolute top-0 start-0 w-100 h-100 opacity-0">
                                            <input type="hidden"
                                                   id="filepath"
                                                   name="filepath"
                                                   value="">

                                            <div>
                                                <i class="fas fa-upload text-primary fs-4 mb-2"></i>
                                                <p class="text-primary fw-medium mb-1">Upload file</p>
                                                <p class="text-muted small">Перетащите или кликните для выбора</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @break
                            @case('datetime')
                                <div class="mb-3">
                                    <label class="form-label">{{ $item['column'] }}</label>
                                    <input type="datetime-local" name="datetime_field" class="form-control" value="{{ $item['value'] ?? '' }}">
                                </div>
                                @break
                            @case('object')
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ $item['column'] }}</label>

                                    <div id="keyValueContainer" class="mb-3">
                                    </div>

                                    <button type="button" id="addKeyValueBtn" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i> add map
                                    </button>

                                    <input type="hidden" id="objectField" name="object_field" value='{{ $item["value"] ?? "{}" }}'>
                                </div>
                                @break
                        @endswitch
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="d-flex gap-2">
                    <a href="" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
