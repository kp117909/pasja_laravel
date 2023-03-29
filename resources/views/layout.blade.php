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
    <!-- Bootstrap -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet'>
      <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>

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
          <a
            href="{{ route('home.index') }}" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">

            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Strona główna</span>
          </a>

          <a href="{{ route('calendar.index') }}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-calendar fa-fw me-3"> 
            </i>
            <span>Kalendarz</span>
          </a>
          

        </div>
      </div>
    </nav>
    <!-- Sidebar -->
  
    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-mdb-toggle="collapse"
          data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="fas fa-bars"></i>
        </button>
  
        <a class="navbar-brand" href="#">
          <img
            src="{{url('png/icon.webp')}}"
            height="50"
            alt="MDB Logo"
            loading="lazy"
          />
        </a>

        <ul class="navbar-nav ms-auto d-flex flex-row">
          <li class="nav-item dropdown">
            <a
              class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
              href="#"
              id="navbarDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="flag-poland flag m-0"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="#"
                  ><i class="flag-poland flag"></i>Polski
                  <i class="fa fa-check text-success ms-2"></i
                ></a>
              </li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <a class="dropdown-item" href="#"><i class="flag-united-kingdom flag"></i>Angielski</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
              href="#"
              id="navbarDropdownMenuLink"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                src="{{url('png/avatar.png')}}"
                class="rounded-circle"
                height="22"
                alt="Avatar"
                loading="lazy"
              />
            </a>
            <ul
              class="dropdown-menu dropdown-menu-end"
              aria-labelledby="navbarDropdownMenuLink"
            >
              <li>
                <a class="dropdown-item" href="#">Mój Profil</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Ustawienia</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Wyloguj</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div style = " z-index: 3;" class="relative flex items-top justify-center min-h-screen sm:items-center py-8 sm:pt-0">
    @yield('content')
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->
   <script src = "{{url('js/javascript.js')}}"></script>

</body>
</html>