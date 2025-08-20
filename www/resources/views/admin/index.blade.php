@extends('app/admin')

@section('content')
    <div class="content-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-0">Дашборд</h1>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i> Добавить запись</button>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-muted mb-0">Пользователи</h6>
                            <h4 class="fw-bold mt-1">1,254</h4>
                            <p class="mb-0 text-success"><small><i class="bi bi-arrow-up"></i> 12% за месяц</small></p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary p-3 rounded">
                                <i class="bi bi-people fs-2 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-muted mb-0">Статьи</h6>
                            <h4 class="fw-bold mt-1">542</h4>
                            <p class="mb-0 text-success"><small><i class="bi bi-arrow-up"></i> 8% за месяц</small></p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success p-3 rounded">
                                <i class="bi bi-file-text fs-2 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-muted mb-0">Комментарии</h6>
                            <h4 class="fw-bold mt-1">2,841</h4>
                            <p class="mb-0 text-danger"><small><i class="bi bi-arrow-down"></i> 3% за месяц</small></p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info p-3 rounded">
                                <i class="bi bi-chat-left-text fs-2 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title text-muted mb-0">Посетители</h6>
                            <h4 class="fw-bold mt-1">12,587</h4>
                            <p class="mb-0 text-success"><small><i class="bi bi-arrow-up"></i> 24% за месяц</small></p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning p-3 rounded">
                                <i class="bi bi-eye fs-2 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Таблица с данными -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Последние статьи</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Автор</th>
                        <th>Категория</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th class="text-end">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>125</td>
                        <td>Новые возможности Laravel 11</td>
                        <td>Иван Петров</td>
                        <td>Разработка</td>
                        <td>12.05.2023</td>
                        <td><span class="badge bg-success">Опубликовано</span></td>
                        <td class="table-actions text-end">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>124</td>
                        <td>Оптимизация запросов к базе данных</td>
                        <td>Мария Сидорова</td>
                        <td>Базы данных</td>
                        <td>10.05.2023</td>
                        <td><span class="badge bg-success">Опубликовано</span></td>
                        <td class="table-actions text-end">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>123</td>
                        <td>Введение в Bootstrap 5</td>
                        <td>Алексей Иванов</td>
                        <td>Веб-дизайн</td>
                        <td>08.05.2023</td>
                        <td><span class="badge bg-warning text-dark">Черновик</span></td>
                        <td class="table-actions text-end">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>122</td>
                        <td>Создание API на Laravel</td>
                        <td>Иван Петров</td>
                        <td>Разработка</td>
                        <td>05.05.2023</td>
                        <td><span class="badge bg-success">Опубликовано</span></td>
                        <td class="table-actions text-end">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>121</td>
                        <td>Основы работы с Vue.js</td>
                        <td>Сергей Кузнецов</td>
                        <td>JavaScript</td>
                        <td>02.05.2023</td>
                        <td><span class="badge bg-info">На проверке</span></td>
                        <td class="table-actions text-end">
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Предыдущая</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Следующая</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Дополнительные блоки -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Активность</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1"><strong>Иван Петров</strong> добавил новую статью</p>
                                    <small class="text-muted">2 часа назад</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1"><strong>Мария Сидорова</strong> обновила свой профиль</p>
                                    <small class="text-muted">5 часов назад</small>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1"><strong>Алексей Иванов</strong> опубликовал комментарий</p>
                                    <small class="text-muted">Вчера в 15:45</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Статистика посещений</h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <p class="text-muted">Здесь будет график статистики посещений</p>
                        <div class="bg-light rounded p-5">
                            <i class="bi bi-bar-chart fs-1 text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
