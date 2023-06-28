@extends('layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="container rounded-3 bg-white opacity-90 mb-5">
    <div class="row d-flex justify-content-end">
        <div class="col-md-4">
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('employee'))
                <div class="mt-5 text-center">
                    <a href="{{ route('client.profile') }}" class="btn btn-primary btn-rounded">Przejdź do profilu użytkownika</a>
                </div>
            @endif
            <form action="{{ route('profile-worker.update') }}" enctype="multipart/form-data" method="POST">
                @csrf
            <div class="d-flex flex-column align-items-center text-center p-6 py-2">
                <img class="rounded-circle border border-3 mt-5" id ="my_photo" width="128px" height="128px" src="{{asset('png/'.auth()->user()->worker->icon_photo)}}">
                    <span class="text-primary fw-bold"> {{ auth()->user()->worker->first_name }}</span><span class="text-black-50">{{ auth()->user()->worker->phone }}</span>
            </div>
            <div class="d-flex justify-content-center">
                <div class="btn btn-primary btn-rounded">
                    <label class="form-label text-white m-1" for="icon_photo">Wybierz zdjęcie</label>
                    <input type="file" name = "icon_photo" id="icon_photo" class="form-control d-none" />
                    <input type="number"  style = "display:none;" id = "id_client" name = "id_client" value = "{{ auth()->user()->worker->id }}"/>
                </div>
            </div>
            <div class="p-3 py-5">
                <div class="d-flex flex-column align-items-center text-center">
                    <h4 class="text-center">Edytuj dane</h4>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" id="first_name" name = "first_name" value = "{{ auth()->user()->worker->first_name }}" class="form-control form-control" oninvalid="this.setCustomValidity('Wprowadź imię')"  oninput="setCustomValidity('')" required/>
                    <label class="form-label" for="first_name">Imię</label>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" id="last_name" name = "last_name" value = "{{ auth()->user()->worker->last_name }}" class="form-control form-control" oninvalid="this.setCustomValidity('Wprowadź nazwisko')"  oninput="setCustomValidity('')" required/>
                    <label class="form-label" for="last_name">Nazwisko</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="text" id="phone" maxlength="11" name="phone" onkeydown="phoneNumberFormat()" oninvalid="this.setCustomValidity('Nieprawidłowy format')" class="form-control" oninput="setCustomValidity('')" value = "{{ auth()->user()->worker->phone }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
                    <label class="form-label" for="phone">Nr Telefonu [000-000-000]</label>
                </div>

                <div class="form-outline mb-3">
                    <input type="color" id="color" name="color"  oninvalid="this.setCustomValidity('Nieprawidłowy format')"  class="form-control" oninput="setCustomValidity('')" value = "{{ auth()->user()->worker->color }}" required>
                    <label class="form-label" for="color">Wybór Koloru Wizyt</label>
                </div>


                <div class="mt-2 text-center"><button class="btn btn-success btn-rounded" type="submit">Zapisz zmiany</button></div>
            </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="p-3 py-5">
                <div class="d-flex flex-column align-items-center text-center">
                    @if(auth()->user()->hasRole('admin'))
                        <h4 class="text-center">Panel dodawania/edycji usług</h4>
                    @else
                        <h4 class="text-center">Dostępne usługi pracownicze</h4>
                    @endif
                </div>
                    <table id ="services_table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>
                            <th>@sortablelink('') Id</th>
                            <th>Usługa</th>
                            <th>Szczegóły</th>
                            @if(auth()->user()->hasRole('admin'))
                                <th>Operacje</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>
                                <span class="badge badge-success rounded d-inline">
                                    {{$service->id}}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{asset('png/services_icons/'.$service->img)}}"
                                        class="rounded-circle"
                                        alt=""
                                        style="width: 45px; height: 45px"
                                    />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{$service->service_name}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary rounded d-inline">
                                    {{$service->price}} zł / {{$service->time}} min
                                </span>
                            </td>
                            @if(auth()->user()->hasRole('admin'))
                                <td>
                                    <div class="row" style = "padding-left: 0px">
                                        <div class="col-md-4 mr-2">
                                            <button type="button" data-mdb-toggle="modal" data-mdb-target="#modalEdit_{{$service->id}}" id = "{{$service->id}}" class="btn btn-primary btn-rounded">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                        <div class="col-md-4 ml-4">
                                                <button type="button" name = "delete_button" id = "{{$service->id}}" class="btn btn-danger btn-rounded delete">
                                                    <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex flex-column align-items-center text-center">
                        @if(auth()->user()->hasRole('admin'))
                            <button type="button" class="btn btn-success btn-rounded" data-mdb-toggle="modal" data-mdb-target="#modal_addNew">
                                Dodaj Usługę
                            </button>
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_addNew" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Dodaj nową usługę</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('services.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="d-flex flex-column align-items-center text-center">
                        <h4 class="text-center">Wybierz zdjęcie</h4>
                    </div>
                    <div class="d-flex justify-content-center">
                        <select class="selectpicker" name = "select_icon_service" data-live-search="true">
                            <option data-tokens="IC1" value = "dye.jpg" data-content="<img src='{{asset('png/services_icons/dye.jpg')}}' style='width: 50%;'><span class='badge badge-primary'>IC 1</span>"></option>
                            <option data-tokens="IC2" value = "scissors.png" data-content="<img src='{{asset('png/services_icons/scissors.png')}}' style='width: 50%;'><span class='badge badge-primary'>IC 2</span>"></option>
                            <option data-tokens="IC3" value = "swithp.jpg" data-content="<img src='{{asset('png/services_icons/swithp.jpg')}}' style='width: 50%;'><span class='badge badge-primary'>IC 3</span>"></option>
                        </select>
                    </div>
                        <div class="d-flex flex-column align-items-center text-center">
                            <h4 class="text-center">Wprowadź dane</h4>
                        </div>
                        <div class = "row">
                            <div class="col-md-12 mb-2 pb-2">
                                <div class="form-outline mb-3">
                                    <input type="text" id="service_name" name = "service_name"  class="form-control" />
                                    <label class="form-label" for="service_name">Nazwa Usługi</label>
                                </div>
                            </div>

                             <div class="col-md-4 mb-2 pb-2">
                                 <div class="form-outline mb-3">
                                     <input type="number" id="price" name = "price" class="form-control" />
                                     <label class="form-label" for="price">Cena</label>
                                 </div>
                             </div>

                            <div class="col-md-2 mb-2 pb-2" >
                                <input disabled type="text" placeholder="zł" id="price_zł" name = "price_zl"  class="form-control" />
                            </div>

                            <div class="col-md-4 mb-2 pb-2">
                                <div class="form-outline mb-3">
                                    <input type="number" id="time" name = "time" class="form-control" />
                                    <label class="form-label" for="time">Czas</label>
                                </div>
                            </div>

                            <div class="col-md-2 mb-2 pb-2">
                                <input disabled type="text" placeholder="min" id="time_min" name = "time_min"  class="form-control" />
                            </div>

                            <div class="d-flex flex-column align-items-center text-center">
                                <button type="submit" class="btn btn-success btn-rounded" data-mdb-toggle="modal" data-mdb-target="#modal_addNew">
                                    Potwierdź
                                </button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>

@foreach($services as $service)
    <div class="modal fade" id="modalEdit_{{$service->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edycja usługi</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('services.update') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div>
                            <div class = "row">
                                <div class="col-md-12">
                                    <div class="form-outline mb-3">
                                        <input type="text" id="service_name" name = "service_name" value = "{{$service->service_name}}"  class="form-control form-control" />
                                        <label class="form-label" for="service_name">Nazwa Usługi</label>
                                        <input type="number"  style = "display:none;" id = "id_service" name = "id_service" value = "{{ $service->id}}"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline mb-3">
                                        <input type="number" id="price" name = "price" value = "{{$service->price}}" class="form-control form-control" />
                                        <label class="form-label" for="price">Cena</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input disabled type="text" placeholder="zł" id="price_zł" name = "price_zl"  class="form-control form-control" />
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline mb-3">
                                        <input type="number" id="time" name = "time" value = "{{$service->time}}" class="form-control form-control" />
                                        <label class="form-label" for="price">Czas</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input disabled type="text" placeholder="min" id="time_min" name = "time_min"  class="form-control form-control" />
                                </div>


                                <div class="d-flex flex-column align-items-center text-center">
                                    <button type="submit" class="btn btn-success btn-rounded">
                                        Potwierdź
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>

    $(".delete").click(function(){
        Swal.fire({
            title: "Czy na pewno chcesz usunąć tą usługę?",
            icon: 'info',
            showCancelButton: true,
            cancelButtonText: 'Cofnij',
            confirmButtonText: 'Usuń',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('services.destroy') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {id: $(this).attr('id')},
                    success: function (response) {
                        Swal.fire({
                            title: "Usługa usunięta pomyślnie!",
                            text: "Naciśnij przycisk aby przeładować stronę",
                            icon: "success",
                            showConfirmButton: true
                        }).then((result) => {
                            location.reload();
                        });
                        calendar.refetchEvents();
                    },
                    error: function (error) {
                        Swal.fire('Nie udało sie usunąć usługi!', '', 'error');
                    },
                })
            }});
    });
</script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
@endsection
