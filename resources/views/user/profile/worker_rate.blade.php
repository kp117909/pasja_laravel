@extends('layout')
@vite(['resources/css/worker-rating.css'])

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <form action="{{ route('rate.store') }}" enctype="multipart/form-data" method="POST">
        <input type = "hidden" name = "worker_id" value = "{{$worker->id}}">
        <input type = "hidden" name = "client_id" value = "{{auth()->user()->id}}">
        <input type = "hidden" name = "notification_id" value = "{{$n_id}}">
        @csrf
    <div class="card text-center mb-5">

        <div class="circle-image">
            <img src="{{asset('png/'.$worker->icon_photo)}}" width="50">
        </div>

        <span class="dot"></span>

        <span class="name mb-1 fw-500">{{$worker->first_name}} {{$worker->last_name}}</span>
        <small class="text-black-50">{{$worker->phone}}</small>
            <div class="location mt-4">

                <span class="d-block"><i class="fa-regular fa-message"></i><small class="text-truncate ml-2">Napisz swoją opinie na temat wizyty</small> </span>
                <div class = "container">
                    <div class="input-group mb-3">
                        <input required type="text" name="comment" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                    </div>
                </div>

            </div>


            <div class="rate py-3 text-white mt-3">

                <h6 class="mb-0">Oceń swoją wizytę</h6>

                <div class="rating"> <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                </div>
                <div class="buttons px-4 mt-0">
                    <button type = "submit" class="btn btn-dark btn-block rating-submit">Wystaw opinie</button>
                </div>
            </div>
    </div>
    </form>
</div>
@endsection
