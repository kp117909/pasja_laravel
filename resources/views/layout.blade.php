<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <!-- Stylesheet -->
    <link href = "{{url('css/style.css')}}" rel = "stylesheet"/>
    <link href = "{{url('css/app.css')}}" rel = "stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- custom alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/3133d360bd.js" crossorigin="anonyous"></script>

      <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <!-- FullCalendary JS Librarry -->

    <link href="{{url('fullcalendar/packages/core/main.css')}}" rel='stylesheet' />
    <link href="{{url('fullcalendar/packages/daygrid/main.css')}}" rel='stylesheet' />
    <link href="{{url('fullcalendar/packages/timegrid/main.css')}}" rel='stylesheet' />
    <link href="{{url('fullcalendar/packages/list/main.css')}}" rel='stylesheet' />
    <script src="{{url('fullcalendar/packages/core/main.js')}}" ></script>
    <script src="{{url('fullcalendar/packages/interaction/main.js')}}"></script>
    <script src="{{url('fullcalendar/packages/daygrid/main.js')}}"></script>
    <script src="{{url('fullcalendar/packages/timegrid/main.js')}}"></script>
    <script src="{{url('fullcalendar/packages/list/main.js')}}"></script>
    <script src="{{url('fullcalendar/packages/core/locales-all.min.js')}}"></script>
</head>
<body>
  <header>
    <nav id="sidebarMenu"  class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div  class="list-group list-group-flush mx-3 mt-4">
            <div class = "relative flex items-top justify-center">
                <a
                    class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
                    href="{{ route('client.profile') }}"
                    id="navbarDropdownMenuLink"
                    role="button"
                    data-mdb-toggle="dropdown"
                    aria-expanded="false"
                >
                    <img
                        src="{{asset('png/'.auth()->user()->icon_photo)}}"
                        class="icon rounded-circle border border-3"
                        height="68"
                        width = "68"
                        alt="Avatar"
                        loading="lazy"
                    >
                </a>
            </div>
          <a
            href="{{ route('home.index') }}" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">

            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Strona główna</span>
          </a>

          <a href="{{ route('calendar.index') }}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-calendar fa-fw me-3">
            </i>
            <span>Kalendarz</span>
          </a>

        <a href="{{ route('home.info') }}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-chart-line fa-fw me-3">
            </i>
            <span>Analityka</span>
        </a>

          <a href="{{ route('logout') }}" class="list-group-item list-group-item-action py-2 ripple">
          <i class="fa-solid fa-arrow-right-from-bracket fa-fw me-3"></i>
            </i>
            <span>Wyloguj</span>
          </a>


        </div>
      </div>
    </nav>
    <!-- Sidebar -->

  </header>


  <div style = " z-index: 3;" class="relative d-flex items-center justify-content-center min-h-screen sm:items-center py-8 sm:pt-0">
    @yield('content')
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
  <script src = "{{url('js/javascript.js')}}"></script>


</body>
</html>
