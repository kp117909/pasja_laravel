@extends('layout')

@section('content')
    <main style="margin-top: 58px">
        <div class="container pt-4">
            <section class = "mb-4">
                <div class="dropdown show center">

                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       Wybierz pracownika by wyświetlić jego prywatną analityke
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item disabled" href="#">HairLink</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('home.analytics')}}">Analityka Firmy</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item disabled" href="#">Pracownicy</a>
                        <div class="dropdown-divider"></div>
                        @foreach($workers as $worker)
                            <a class="dropdown-item" href="{{route('worker.analytics', ['id' => $worker->id])}}">{{$worker->first_name}} {{$worker->last_name}}</a>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- Section: Main chart -->
            <section class="mb-4">
                <div class="card">
                    <div class="card-header py-3">
                        @if(isset($currentWorker))
                            <h5 class="mb-0 text-center"><strong>Analityka Pracownika {{$currentWorker->first_name}} {{$currentWorker->last_name}}</strong></h5>
                        @else
                            <h5 class="mb-0 text-center"><strong>Analityka Firmy</strong></h5>
                        @endif
                    </div>
                    <div class="card-body">
                        <canvas class="my-2 w-100" id="myChart" height="200"></canvas>
                    </div>
                </div>
            </section>
            <!-- Section: Main chart -->

            <!--Section: Minimal statistics cards-->
            <section>
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div>
                                        <h3 class="text-success">{{$currentMonthClients}}</h3>
                                        <p class="mb-0">Liczba Klientów w miesiącu</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="far fa-user text-success fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="align-self-center">
                                        <i class="fas fa-chart-line text-success fa-3x"></i>
                                    </div>
                                    <div class="text-end">
                                        <h3>{{$currentServices}}</h3>
                                        <p class="mb-0"> Usługi w miesiącu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between px-md-1">
                                    <div class="align-self-center">
                                        <i class="fas fa-wallet text-success fa-3x"></i>
                                    </div>
                                    <div class="text-end">
                                        <h3>{{$currentMonthEarnings}} zł</h3>
                                        <p class="mb-0">Zarobki w tym miesiącu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Section: Minimal statistics cards-->

            <!--Section: Statistics with subtitles-->
            <section>
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="far fa-user text-success fa-3x me-4"></i>
                                        </div>
                                        <div>
                                            <h4>Klienci</h4>
                                            <p class="mb-0">Ogólna liczba klientów</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0">{{$totalClients}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h1 mb-0 me-4">{{$totalServices}}</h2>
                                        </div>
                                        <div>
                                            <h4>Wykonane usługi</h4>
                                            <p class="mb-0">Całkowita liczba wykonanych usług</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="far fa-heart text-danger fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <h2 class="h1 mb-0 me-4">{{$totalEarnings}} zł</h2>
                                        </div>
                                        <div>
                                            <h4>Zarobki</h4>
                                            <p class="mb-0">Całkowite zarobki</p>
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-wallet text-success fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Section: Statistics with subtitles-->
        </div>
    </main>
@endsection
