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
                        <div class ="row">
                            <div calss = "col-md-12">
                                <a href = "{{route('worker.profile')}}" class="btn btn btn-rounded">Panel dodawania/edycji usług</a>
                                <a class="btn btn btn-rounded">Panel dodawania/edycji pracowników/użytkowników</a>
                            </div>
                        </div>
                    @else
                        <h4 class="text-center">Dostępne usługi pracownicze</h4>
                    @endif
                </div>
                    <table id ="services_table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>
                            <th>@sortablelink('') Id</th>
                            <th>Dane</th>
                            <th>Rola</th>
                            <th>Status</th>
                            <th>Operacje</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <span class="badge badge-success rounded d-inline">
                                    {{$user->id}}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img
                                        src="{{asset('png/'.$user->icon_photo)}}"
                                        class="rounded-circle"
                                        alt=""
                                        style="width: 45px; height: 45px"
                                    />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{$user->first_name}} {{$user->last_name}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-primary rounded d-inline">
                                   @if($user->hasRole('admin'))
                                        Administrator
                                    @elseif($user->hasRole('employee'))
                                        Pracownik
                                    @else
                                        Klient
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($user->active)
                                    Aktywne
                                @else
                                    Nieaktywne
                                @endif
                            </td>
                                <td>
                                    <div class="row" style = "padding-left: 0px">
                                        <div class="col-md-4 mr-2">
                                            <button type="button" data-mdb-toggle="modal" data-mdb-target="#modalEdit_{{$user->id}}" id = "{{$user->id}}" class="btn btn-primary btn-rounded">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>


@foreach($users as $user)
    <div class="modal fade" id="modalEdit_{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edycja użytkownika</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div>
                            <div>
                                <div class="form-outline mb-3">
                                    <input type="text" id="first_name" name = "first_name" value = "{{ $user->first_name }}" class="form-control form-control" oninvalid="this.setCustomValidity('Wprowadź imię')"  oninput="setCustomValidity('')" required/>
                                    <label class="form-label" for="first_name">Imię</label>
                                </div>
                                <div class="form-outline mb-3">
                                    <input type="text" id="last_name" name = "last_name" value = "{{ $user->last_name }}" class="form-control form-control" oninvalid="this.setCustomValidity('Wprowadź nazwisko')"  oninput="setCustomValidity('')" required/>
                                    <label class="form-label" for="last_name">Nazwisko</label>
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="text" id="phone" maxlength="11" name="phone" onkeydown="phoneNumberFormat()" oninvalid="this.setCustomValidity('Nieprawidłowy format')" class="form-control" oninput="setCustomValidity('')" value = "{{ $user->phone }}" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>
                                    <label class="form-label" for="phone">Nr Telefonu [000-000-000]</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" value = "1" @if($user->active) checked @endif type="radio" name="active_status" id="radio_active"/>
                                    <label class="form-check-label" for="radio_active"> Konto Aktywne </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" value = "0" type="radio" @if(!$user->active) checked @endif name="active_status" id="radio_active_nonactive"/>
                                    <label class="form-check-label" for="radio_nonactive"> Konto Nieaktywne </label>
                                </div>


                                <select @if(auth()->user()->id == $user->id) disabled @endif class="form-select" aria-label="select_permission" name = "permission_select" id="permission_select">
                                    <option value="choose" disabled>Wybierz Role</option>
                                    <option value="admin" @if($user->hasRole('admin')) selected @endif>Administrator</option>
                                    <option value="employee" @if($user->hasRole('employee')) selected @endif>Pracownik</option>
                                    <option value="client" @if($user->hasRole('client')) selected @endif>Klient</option>
                                </select>

                                <input type = "text" hidden name = "user_id" value = "{{$user->id}}">

                                <div class="d-flex flex-column align-items-center text-center m-2">
                                    <button type="submit" class="btn btn-success btn-rounded" >
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

    @if (session('decline_notify'))
        Swal.fire({
            icon: 'error',
            title: 'Zmiana typu konta niemożliwa',
            text: 'Pracownik posiada umówione wizyty w kalendarzu!',
            showConfirmButton: true
        });
    @endif

</script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
@endsection
