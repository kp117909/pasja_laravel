@php
 $exist = false;
 $count = 0;
@endphp
<ul aria-labelledby="notifications" class="dropdown-menu">
    @foreach ($notifications as $notification)
        @if($notification->client_id === auth()->user()->id && $notification->removed == 0)
            @php $exist = true; $count++; @endphp
            <li><a rel="nofollow" href="{{route("worker.rate", [$notification->worker->id, $notification->id])}}" class="dropdown-item">
                    <div class="notification">
                        <div class="notification-content"><i class="fa fa-envelope bg-green"></i> Oceń swoją wizytę u {{$notification->worker->first_name}} </div>
                        <div class="notification-time"><small> Data zakończenia wizyty {{$notification->event->end}}</small></div>
                    </div>
                </a>
            </li>
        @endif
    @endforeach
        @if($exist)
{{--            <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>Pokaż wszystkie powiadomienia</strong></a></li>--}}
        @else
            <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>Brak powiadomień</strong></a></li>
        @endif
</ul>

<a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
    @if($exist)
        <i class="fa-solid fa-envelope fa-beat-fade fa-lg"></i>
        <span class="badge rounded-pill badge-notification bg-danger">{{$count}}</span>
    @else
        <i class="fas fa-envelope fa-lg"></i>
        <span class="badge bg-danger badge-dot"></span>
    @endif
</a>

