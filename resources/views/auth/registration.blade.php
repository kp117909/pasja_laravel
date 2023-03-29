<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- custom alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/3133d360bd.js" crossorigin="anonymous"></script>
</head>
<body>
<section class="vh-100" style="background-image: url('png/tlo_pasja.jpeg') ;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{url('png/icon.webp')}}"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; padding-top:30%;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form action="{{ route('login.post') }}" method="POST">
                @csrf
                  <div class="d-flex align-items-center mb-3 pb-1">
                  <i class="fa-brands fa-staylinked fa-flip fa-xl" style="color: #898c90;"></i>
                    <span class="h1 fw-bold mb-0">HairLink</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Zajerestruj swoje konto</h5>

                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">

                      <div class="form-outline">
                        <input type="text" id="first_name" name = "first_name"  class="form-control form-control-lg" />
                        <label class="form-label" for="first_name">Imię</label>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4 pb-2">

                      <div class="form-outline">
                        <input type="text" id="last_name" name = "last_name" class="form-control form-control-lg" />
                        <label class="form-label" for="last_name">Nazwisko</label>
                      </div>

                    </div>
                  </div>

                  <div class="form-outline mb-4">
                  <input type="phone" id="phone" name = "phone" class="form-control form-control-lg" />
                    <label class="form-label" for="phone">Telefon</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="login" id="login" name = "login" class="form-control form-control-lg" />
                    <label class="form-label" for="login">Login</label>
                    @if ($errors->has('login'))
                        <span class="text-danger">{{ $errors->first('login') }}</span>
                    @endif
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-4 pb-2">

                      <div class="form-outline">
                        <input type="password" id="password" name = "password" class="form-control form-control-lg" />
                        <label class="form-label" for="password">Hasło</label>
                      </div>

                    </div>
                    <div class="col-md-6 mb-4 pb-2">

                      <div class="form-outline">
                        <input type="password" id="re_password" name = "re_password" class="form-control form-control-lg" />
                        <label class="form-label" for="re_password">Powtórz hasło</label>
                      </div>

                    </div>
                  </div>


                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Stwórz</button>
                  </div>

                  <div class="form-check d-flex justify-content-start mb-4 pb-3">
                    <input class="form-check-input me-3" type="checkbox" value="" id="terms" />
                    <label class="form-check-label" for="terms">
                      Akcpetuje <a href="#!" style="color: #393f81;"><u>Regulamin i zasady</u></a> strony HairLink.
                    </label>
                  </div>

                  <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                  <p class="mb-2 pb-lg-2" style="color: #393f81;"> Posiadasz konto? <a href="{{route('login')}}"
                      style="color: #393f81;">Zaloguj się tutaj!</a></p>
                  <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>