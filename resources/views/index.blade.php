@extends('layout')

@push('styles')
    <link rel="stylesheet" href="css/index.css">
@endpush

@section('content')
    <div class="content container mt-5">
        <div>
            <div class="card">
                <h5 class="card-header">Форум</h5>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($projects as $project)
                            <li class="list-group-item">
                                <h5>
                                    {{ $project->name }}
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-create-section" data-project="{{ $project->id }}">Добавить раздел</button>
                                </h5>
                                <ul class="list-group list-group-flush">
                                    @foreach($project->sections()->get() as $section)
                                    <li class="list-group-item">
                                        <h6>
                                            {{ $section->name }}
                                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                    data-target="#modal-create-task" data-section="{{$section->id}}">Добавить подраздел</button>
                                        </h6>
                                        <ul class="list-group list-group-flush">
                                            @foreach($section->tasks()->get() as $task)
                                            <li class="list-group-item">
                                                <h6>
                                                    {{ $task->name }}
                                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                            data-target="#modal-create-thread" data-task="{{$task->id}}">Создать тему</button>
                                                </h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach($task->threads()->get() as $thread)
                                                    <li class="list-group-item"><a href="thread.html" class="btn btn-link">{{ $thread->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="modal-create-thread" tabindex="-1" aria-labelledby="modal-create-thread-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-create-thread-label">Создание темы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createThread') }}" method="POST" name="create_thread">
                        @csrf
                        <input type="text" style="display: none" id="form_create_thread_task" name="task" required>
                        <div class="form-group">
                            <label for="form_create_thread_title">Название</label>
                            <input type="text" class="form-control" id="form_create_thread_title" name="title">
                        </div>
                        <textarea class="form-control mb-3" placeholder="Текст темы" name="text"></textarea>
                        <div class="form-group">
                            <label for="form_create_thread_type">Тип темы</label>
                            <select class="custom-select" id="form_create_thread_type" name="type">
                                <option value="open" selected>Открытая</option>
                                <option value="info">Информационная</option>
                                <option value="private">Закрытая</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="create_thread_submit">Создать тему</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create-section" tabindex="-1" aria-labelledby="modal-create-section-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-create-section-label">Создание раздела</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createSection') }}" method="POST" name="create_section">
                        @csrf
                        <input type="text" style="display: none" id="form_create_section_project" name="project" required>
                        <div class="form-group">
                            <label for="form_create_section_title">Название</label>
                            <input type="text" class="form-control" id="form_create_section_title" name="name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="create_section_submit">Добавить раздел</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create-task" tabindex="-1" aria-labelledby="modal-create-task-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-create-task">Создание подраздела</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('createTask') }}" method="POST" name="create_task">
                        @csrf
                        <input type="text" style="display: none" id="form_create_task_section" name="section" required>
                        <div class="form-group">
                            <label for="form_create_task_title">Название</label>
                            <input type="text" class="form-control" id="form_create_task_title" name="name">
                        </div>
                        <div class="form-group">
                            <label for="form_create_task_spec">Специализация или направление разработки</label>
                            <select class="custom-select" id="form_create_task_spec" name="spec">
                                <option @if(old('spec') > 0) value="{{ old('spec') }}" @else disabled @endif  selected>Выберите специализацию</option>
                                @foreach(\App\Models\Spec::all() as $spec)
                                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="form_create_task_start">Дата начала</label>
                            <input type="text" class="form-control" id="form_create_task_start" name="start">
                        </div>
                        <div class="form-group">
                            <label for="form_create_task_end">Дата окончания</label>
                            <input type="text" class="form-control" id="form_create_task_end" name="end">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" id="create_task_submit">Добавить подраздел</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $('#modal-create-section').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var project = button.data('project') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('#form_create_section_project').attr('value', project)
        })

        $('#modal-create-task').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var section = button.data('section') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('#form_create_task_section').attr('value', section)
        })

        $('#modal-create-thread').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var section = button.data('task') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('#form_create_thread_task').attr('value', section)
        })

        $('#create_section_submit').on('click', function (event) {
            document.forms['create_section'].submit()
        })

        $('#create_task_submit').on('click', function (event) {
            document.forms['create_task'].submit()
        })

        $('#create_thread_submit').on('click', function (event) {
            document.forms['create_thread'].submit()
        })
    </script>
@endpush
