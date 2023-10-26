@extends('layout')

@section('content')
    <!--Main layout-->
    <main class="my-5">
        <div class="container rounded-3 bg-white opacity-90 mb-5">
            <div class="team-boxed">
                <div class="intro">
                    <h2 class="text-center">HairLink <i  class = "fa-solid fa-scissors fa-fade" style="color: #2C3E50;"></i></h2>
                    <p class="text-center">Tutaj znajdziesz swoje najbliższe wydarzenia <b>{{auth()->user()->first_name}} </b></p>
                </div>
                <div class="row people">
                </div>
            </div>
        </div>
        <div class="container rounded-3 bg-white opacity-90 mb-5">
            <div class="team-boxed">
                <div class="intro">
                    <h2 class="text-center">Wizyty <i class="fa-regular fa-calendar fa-flip" style="color: #2C3E50;"></i></h2>
                </div>
                    <div class="row people">
                        <div class="{{ auth()->user()->hasRole('client') ? 'col-md-12 col-lg-12' : 'col-md-6 col-lg-6' }} item">
                            <div class="box">
                                @if($event)
                                    <img class="rounded-circle" src="{{asset("png/".$event->worker_icon)}}">
                                    <h3 class="name">Nadchodząca wizyta</h3>
                                    <p class="title">{{$event->name_w}} {{$event->surname_w}}</p>
                                    <p class="description">{{auth()->user()->first_name}} Twoja najbliższa wizyta odbędzie sie dnia <b>{{ $event->start->format('Y-m-d') }}</b> o godzinie
                                        <b>{{ $event->start->format('H:i:s') }} </b> u pracownika <b>{{$event->name_w}} {{$event->surname_w}}</b>
                                    </p>
                                    <div class="social">Data Rezerwacji <br> {{$event->created_at}}</div>
                                @else
                                    <h3 class="name">Nadchodząca wizyta</h3>
                                    <p class="title">Brak nadchodzących wizyt</p>
                                    <p class="description">Umów się na wizytę odwiedzając nasz <a href = "{{route('calendar.index')}}">kalendarz!</a> </p>
                                    <div class="social">Twój system HairLink</div>
                                @endif
                            </div>
                        </div>
                        @if(auth()->user()->hasRole('employee') || auth()->user()->hasRole('admin'))
                            <div class="col-md-6 col-lg-6 item">
                                <div class="box">
                                    @if($eventWorker)'
                                    <img class="rounded-circle" src="{{ asset("png/".$eventWorker->icon_photo) }}" style="max-width: 120px; max-height: 160px;">
                                    <h3 class="name">Umówiony klient</h3>
                                        <p class="title">{{$eventWorker->name_c}} {{$eventWorker->surname_c}}</p>
                                        <p class="description">{{auth()->user()->first_name}} Twój najbliższy klient <b>{{$eventWorker->name_c}} {{$eventWorker->surname_c}}</b> jest umówiony na
                                            wizytę dnia <b>{{ $eventWorker->start->format('Y-m-d') }}</b> na godzinie
                                            <b>{{ $eventWorker->start->format('H:i:s') }} </b>
                                        </p>
                                        <div class="social">Data Rezerwacji <br> {{$eventWorker->created_at}}</div>
                                    @else

                                        <h3 class="name">Umówiony klient</h3>
                                        <p class="title">Brak umówionych klientów</p>
                                        <p class="description">Zaproś kogoś do umówienia się na wizytę odwiedzając nasz <a href = "{{route('calendar.index')}}">kalendarz!</a> </p>
                                        <div class="social">Twój system HairLink</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </main>
@endsection

