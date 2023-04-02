@extends('layout')

@section('content')

<div class="container rounded-3 bg-white opacity-90 mb-14">
    <form action="{{ route('client.update') }}" enctype="multipart/form-data" method="POST">
        @csrf
    <div class="row d-flex justify-content-end">
        <div class="col-md-3">
            <div class="d-flex flex-column align-items-center text-center p-6 py-2">
                <img class="rounded-circle border border-3 mt-5" width="128px" height="128px" src="{{asset('png/'.auth()->user()->icon_photo)}}">
                <span class="text-primary fw-bold"> {{ auth()->user()->first_name }}</span><span class="text-black-50">{{ auth()->user()->phone }}</span>
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-center">Wybierz zdjęcie</h4>
                </div>
            </div>
                <div class="input-group custom-file-button">
                    <input type="file" class="form-control" name = "icon_photo" id="icon_photo">
                    <input type="number"  style = "display:none;" id = "id_client" name = "id_client" value = "{{ auth()->user()->id }}"/>
                </div>
        </div>
        <div class="col-md-4 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Edycja Profilu</h4>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" id="first_name" name = "first_name" value = "{{ auth()->user()->first_name }}" class="form-control form-control" />
                    <label class="form-label" for="first_name">Imię</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="text" id="last_name" name = "last_name" value = "{{ auth()->user()->last_name }}" class="form-control form-control" />
                    <label class="form-label" for="last_name">Nazwisko</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="tel" id="phone" name="phone" class="form-control form-control" value = "{{ auth()->user()->phone }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
                    <label class="form-label" for="phone">Nr Telefonu [000-000-000]</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="text" id="adress" name = "adress" value = "{{ auth()->user()->adress }}" class="form-control form-control" />
                    <label class="form-label" for="adress">Adress</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="text" id="postcode" name = "postcode" value = "{{ auth()->user()->postcode }}" class="form-control form-control" />
                    <label class="form-label" for="postcode">Kod pocztowy</label>
                </div>

                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Zapisz zmiany</button></div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Historia wizyt</h4>
                </div>
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                    <tr>
                        <th>Pracownik</th>
                        <th>Usługa</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{asset('png/admin_icons/'.$event->worker_icon)}}"
                                        class="rounded-circle"
                                        alt=""
                                        style="width: 45px; height: 45px"
                                    />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{$event->name_w}} {{$event->surname_w}}</p>
                                        {{--                                    <p class="text-muted mb-0">alex.ray@gmail.com</p>--}}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#modal_{{$event->id}}">
                                    Pokaż
                                </button>
                                {{--                            <p class="text-muted mb-0">Finance</p>--}}
                            </td>
                            <td>
                            <span class="badge badge-primary rounded d-inline">
                                {{$event->overal_price}} zł
                            </span>
                            </td>
                            <td>{{$event->start}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </form>
</div>

@foreach($events as $event)
    <div class="modal fade" id="modal_{{$event->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Usługi przypisane do Wizyty</h5>
                </div>
                    <div class="modal-body"><ul class="list-group">
                        @foreach($services_events as $se)
                            @if($se->id_event == $event->i d)
                        <li class="list-group-item">{{$se->service_name}} | {{$se->price}}zł</li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
@endsection
