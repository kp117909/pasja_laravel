@extends('layout')

@section('content')
<div class="container rounded-3 bg-white opacity-90 mt-12 mb-14">
    <form action="{{ route('client.update') }}" enctype="multipart/form-data" method="POST">
        @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="d-flex flex-column align-items-center text-center p-3 py-2">
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
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Edycja Profilu</h4>
                </div>
                <div class="form-outline mb-3">
                    <input type="text" id="first_name" name = "first_name" value = "{{ auth()->user()->first_name }}" class="form-control form-control" />
                    <label class="form-label" for="first_name">Imię</label>
                </div>

                <div class="col-md-1 form-outline mb-3">
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
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Historia wizyt</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                <div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
                <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
            </div>
        </div>
    </div>
    </form>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
@endsection
