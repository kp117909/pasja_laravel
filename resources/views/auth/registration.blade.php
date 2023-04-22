<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- custom alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
    <script src="https://kit.fontawesome.com/3133d360bd.js" crossorigin="anonymous"></script>
</head>
<body>
<section class="vh-100" style="background-image: url('png/tlo_pasja.jpeg') ;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-3 col-lg-4 d-none d-md-block">
              <img src="{{url('png/icon.webp')}}"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; padding-top:60%;" />
            </div>
            <div class="col-md-9 col-lg-8 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="{{ route('register.post') }}" method="POST">
                @csrf
                  <div class="d-flex align-items-center mb-3 pb-1">
                  <i class="fa-brands fa-staylinked fa-flip fa-xl" style="color: #898c90;"></i>
                    <span style="padding-left:0.5rem" class="h1 fw-bold mb-0">HairLink</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Zajerestruj swoje konto</h5>

                  <div class="row">
                    <div class="col-md-4 mb-2 pb-2">
                        @if ($errors->has('first_name'))
                          <span class="text-danger">Podaj imię</span>
                        @endif
                      <div class="form-outline">
                        <input type="text" id="first_name" name = "first_name"  class="form-control form-control-lg" />
                        <label class="form-label" for="first_name">Imię</label>
                      </div>

                    </div>
                    <div class="col-md-4 mb-2 pb-2">
                        @if ($errors->has('last_name'))
                          <span class="text-danger">Podaj nazwisko</span>
                        @endif
                      <div class="form-outline">
                        <input type="text" id="last_name" name = "last_name" class="form-control form-control-lg" />
                        <label class="form-label" for="last_name">Nazwisko</label>
                      </div>

                    </div>

                    <div class="col-md-4 mb-2 pb-2">
                        @if ($errors->has('phone'))
                            <span class="text-danger">Podaj Nr telefonu</span>
                        @endif
                        <div class="form-outline">
                          <input type="phone" id="phone" name = "phone" class="form-control form-control-lg" />
                        <label class="form-label" for="phone">Nr telefonu</label>
                      </div>
                    </div>

                  </div>
                  @if ($errors->has('login'))
                        <span class="text-danger">Podaj login</span>
                    @endif
                  <div class="form-outline mb-2">
                    <input type="login" id="login" name = "login" class="form-control form-control-lg" />
                    <label class="form-label" for="login">Login</label>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">
                      @if ($errors->has('password'))
                        <span class="text-danger">Podaj hasło</span>
                      @endif
                      <div class="form-outline">
                        <input type="password" id="password" name = "password" class="form-control form-control-lg" />
                        <label class="form-label" for="password">Hasło</label>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4 pb-2">
                      @if ($errors->has('re_password'))
                        <span class="text-danger">Powtórz hasło</span>
                      @endif
                      <div class="form-outline">
                        <input type="password" id="re_password" name = "re_password" class="form-control form-control-lg" />
                        <label class="form-label" for="re_password">Powtórz hasło</label>

                      </div>

                    </div>
                  </div>


                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Stwórz</button>
                  </div>

                  <div class="form-check d-flex justify-content-start mb-2 pb-3">
                    <input class="form-check-input me-3" type="checkbox" value="" id="terms" />
                    <label class="form-check-label" for="terms">
                      Akcpetuje <a href="#!" style="color: #393f81;"><u>Regulamin i zasady</u></a> strony HairLink.
                    </label>
                  </div>

                  <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                  <p class="mb-2 pb-lg-2" style="color: #393f81;"> Posiadasz konto? <a href="{{route('login')}}"
                      style="color: #393f81;">Zaloguj się tutaj!</a></p>
                  <a href="#!" class="small text-muted">Warunki koszytania.</a>
                  <a href="#!" class="small text-muted">Polityka prywatności</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src = "{{url('js/javascript.js')}}"></script>
</body>
</html>
