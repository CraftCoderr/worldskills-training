@extends('layout')

@push('styles')
    <link rel="stylesheet" href="/css/thread.css">
@endpush

@push('templates')
    <script type="text/x-template" id="message-template">

    </script>
@endpush

@push('components')
    <script type="text/javascript">
        new Vue({
            el: '#app',
            data: {
                thread: thread, //{
                    // photo: '/assets/avatar.jpeg',
                    // name: 'Фамилия Имя',
                    // text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima repellendus ' +
                    //     'exercitationem, facere tenetur perspiciatis labore doloribus aspernatur consequatur ' +
                    //     'quos et ipsam alias obcaecati nemo accusantium. Quisquam assumenda facere dolorem animi.',
                    // date: '07.11.2020 20:31',
                // },
                messages: [
                    // {
                    //     id: 1,
                    //     photo: '/assets/avatar.jpeg',
                    //     name: 'Фамилия Имя',
                    //     text: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima repellendus ' +
                    //         'exercitationem, facere tenetur perspiciatis labore doloribus aspernatur consequatur ' +
                    //         'quos et ipsam alias obcaecati nemo accusantium. Quisquam assumenda facere dolorem animi.',
                    //     date: '07.11.2020 20:31',
                    //     changed: 'true'
                    // }
                ],
                responseForm: false,
                message: {
                    text: '',
                    id: 0
                }
            },
            mounted: function() {
                fetch('/thread/' + this.thread.id + '/messages', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => {
                    console.log(response)
                    return response.json()
                })
                .then(data => {
                    this.messages = data.map(m => {
                        m.date = new Date(Date.parse(m.date))
                        m.changable = (m.owned && (Date.now() - m.date) < 3 * 60 * 1000)
                        console.log(Date.now() - m.date)
                        return m
                    });
                    console.log('Success:', data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            },
            methods: {
                openResponse: function(messageIndex) {
                    if (messageIndex) {
                        // this.message += '<div class="quote"><><div>'
                    }
                    this.responseForm = true;
                },
                editMessage: function(index) {
                    let m = this.messages[index]
                    if ((m.owned && (Date.now() - m.date) > 3 * 60 * 1000)) {
                        m.changable = false
                        Vue.set(this.messages, index, m)
                    }
                    this.responseForm = true
                    this.message.id = m.id
                    this.message.text = m.text
                    $('#response-form')[0].scrollIntoView()
                },
                submitMessage: function() {
                    let url = '/thread/' + this.thread.id +'/message'
                    if (this.message.id > 0) {
                        url += '/' + this.message.id;
                    }
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(this.message),
                    })
                    .then(response => {
                        this.message.id = 0
                        this.message.text = ''
                        console.log(response)
                        return response.json()
                    })
                    .then(data => {
                        let m = data
                        m.date = new Date(Date.parse(m.date))
                        m.changable = true
                        let index = this.messages.findIndex((e) => e.id === m.id)
                        if (index === -1) {
                            this.messages.push(m)
                        } else {
                            Vue.set(this.messages, index, m)
                        }
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                }
            }
        })
    </script>
@endpush

@section('content')
<div class="content container mt-5">
  <div>
    <div id="app">
        <div class="card mb-3">
            <div class="card-header">
                <h4>@{{ thread.title }}</h4>
                <button class="btn btn-link">Поделиться</button>
                <button class="float-right btn btn-outline-info ml-2" data-toggle="modal"
                        data-target="#modal-add-permission">Добавить пользователей</button>
                <button class="float-right btn btn-outline-info" data-toggle="modal"
                        data-target="#modal-edit-permission">Права пользователей</button>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-md-4 text-center">
                    <img class="img-thumbnail" :src="thread.photo" alt="">
                    <h6 class="text-center mt-3">@{{ thread.name }}</h6>
                </div>
                <div class="col-sm-12 col-md-8">
                    <pre class="col-12 text-justify">@{{ thread.text }}</pre>
                    <div class="col-12">
{{--                        <span class="text-muted">#1</span>--}}
{{--                        <button class="btn btn-sm btn-link">Поделиться</button>--}}
{{--                        <span class="mr-2">@{{ thread.date.toLocaleDateString() }}</span>--}}
{{--                        <span class="small text-muted">Изменено</span>--}}
{{--                        <button class="float-right btn btn-sm btn-outline-primary">Ответить</button>--}}
                    </div>
                </div>
            </div>
        </div>

        <div v-for="(message, index) in messages" class="card mb-3" :id="'message-' + message.id">
            <div class="card-body row">
                <div class="col-sm-12 col-md-4 text-center">
                    <img class="img-thumbnail" :src="message.photo" alt="">
                    <h6 class="text-center mt-3">@{{ message.name }}</h6>
                </div>
                <div class="col-sm-12 col-md-8">
                    <pre class="col-12 text-justify">@{{ message.text }}</pre>
                    <div class="col-12">
                        <span class="text-muted">#@{{ message.id }}</span>
                        <button class="btn btn-sm btn-link">Поделиться</button>
                        <span class="mr-2">@{{ message.date.toLocaleString('ru-RU') }}</span>
                        <span v-if="message.changed" class="small text-muted">Изменено</span>
                        <button v-if="message.changable" class="btn btn-sm btn-outline-secondary" v-on:click="editMessage(index)">Изменить</button>
                        <button class="float-right btn btn-sm btn-outline-primary" :click="openResponse(index)">Ответить</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="responseForm" class="card mt-5 mb-100" id="response-form">
            <h6 class="card-header" v-if="message.id > 0">Изменение сообщения #@{{ message.id }}</h6>
            <h6 class="card-header" v-else>Новое сообщение</h6>
            <div class="card-body">
                <form>
                    <input type="text" style="display: none" name="id" v-model="message.id">
                    <textarea class="form-control mb-3" placeholder="Текст сообщения" name="text" v-model="message.text"></textarea>
                </form>
                <button class="btn btn-primary float-right" v-on:click="submitMessage">Ответить</button>
            </div>
        </div>
        <button v-else class="btn btn-primary mb-5" type="button" v-on:click="openResponse">Ответить</button>
    </div>
  </div>
</div>
@endsection

@push('modals')
  <div class="modal fade" id="modal-add-permission" tabindex="-1" aria-labelledby="modal-add-permission-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-add-permission">Добавление прав</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="form_create_thread_title">Поиск</label>
              <input type="text" class="form-control" id="form_create_thread_title">
            </div>
            <div class="form-group">
              <select class="custom-select" id="form_add_permission_user">
                <option>Иван Иванов</option>
                <option>Петр петров</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
          <button type="button" class="btn btn-primary">Добавить</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-edit-permission" tabindex="-1" aria-labelledby="modal-edit-permission-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-edit-permission-label">Создание раздела</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item">
              Петр Петров
              <button class="float-right btn btn-sm btn-danger"><span aria-hidden="true">&times;</span></button>
            </li>
            <li class="list-group-item">
              Иван Иванов
              <button class="float-right btn btn-sm btn-danger"><span aria-hidden="true">&times;</span></button>
            </li>
            <li class="list-group-item">
              Сергей Сергеев
              <button class="float-right btn btn-sm btn-danger"><span aria-hidden="true">&times;</span></button>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
@endpush

@push('scripts')
    <script src="/dist/vue.js"></script>
    <script>
        var thread = @json($thread);
    </script>
@endpush
