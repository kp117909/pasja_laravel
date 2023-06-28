@extends('layout')
@php
    $daysOfWeek = [
        "1" => "Poniedziałek",
        "2" => "Wtorek",
        "3" => "Środa",
        "4" => "Czwartek",
        "5" => "Piątek",
        "6" => "Sobota",
        "7" => "Niedziela",
    ];
@endphp
@vite(['resources/css/worker-card.css'])
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
@section('content')
    <div class="container bootdey">
        <section class="col-md-12">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-menu">
                                <i class="fa fa-bars"></i>
                            </div>
                            <div class="card-header-headshot" id="worker-avatar">
                                <img class="rounded-circle border border-3 card-header-headshot" id ="my_photo" src="{{asset('png/'.auth()->user()->worker->icon_photo)}}">
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-content-member">
                                <h4 class="m-t-0">{{$worker->first_name}} {{$worker->last_name}}</h4>
                                <p class="m-0"><i class="pe-7s-map-marker"></i>Harmonogram</p>
                            </div>
                            <div class="card-content-languages">
                                <div class="row">
                                    @foreach($worker->accessibility as $accessibility => $item)
                                        <div class="col-md-5">
                                            <h4>{{ $daysOfWeek[$accessibility] }}:</h4>
                                        </div>
                                        <div class="col-md-5">
                                            {{ $item['start_time'] }} : {{ $item['end_time'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="card-footer-stats">
                                <div>
                                    <p>Klienci:</p><i class="fa fa-users"></i><span> 241</span>
                                </div>
                                <div>
                                    <p>Wykonane usługi:</p><i class="fa fa-coffee"></i><span> 350</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="review-block">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="review-block-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" class="img-rounded" alt="">
                                </div>
                                <div class="review-block-name"><a href="#">nktailor</a></div>
                                <div class="review-block-date">January 29, 2016<br>1 day ago</div>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="review-block-title">this was nice in buy</div>
                                <div class="review-block-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type. </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="review-block-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" class="img-rounded" alt="">
                                </div>
                                <div class="review-block-name"><a href="#">nktailor</a></div>
                                <div class="review-block-date">January 29, 2016<br>1 day ago</div>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="review-block-title">this was nice in buy</div>
                                <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="review-block-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" class="img-rounded" alt="">
                                </div>
                                <div class="review-block-name"><a href="#">nktailor</a></div>
                                <div class="review-block-date">January 29, 2016<br>1 day ago</div>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div class="review-block-title">this was nice in buy</div>
                                <div class="review-block-description">this was nice in buy. this was nice in buy. this was nice in buy. this was nice in buy this was nice in buy this was nice in buy this was nice in buy this was nice in buy</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            var imageUrl = {{asset('png/'.$worker->icon_photo)}}; // Miejsce na generowanie adresu URL obrazu

            document.getElementById("worker-avatar").style.backgroundImage = "url('" + imageUrl + "')";
        });
    </script>
@endsection
