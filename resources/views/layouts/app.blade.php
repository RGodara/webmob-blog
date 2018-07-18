<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WebMog-Blog</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/single.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
      rel="stylesheet">
  </head>
  <body>
    <div class="loder-wp" id="loading" style="display: none;">
      <div class="img"><img src="images/loader.gif"/></div>
    </div>
    <marquee class="marquee-text-background"><span class="marquee-text">This is an assignment purpose only. It will be offline after reviewed by the company. if you have any query about it please feel free to contact me. Ramesh Kumar : 9001635942</span></marquee>
    <div id="homePage">
      <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-content">
          <div>
            <div class="login p-5 bg-light mx-auto mw-100">
              <button type="button" class="close" data-dismiss="modal">&times;</button>    
              <div class="success-message" v-show="this.userRegMessages.successMessage != ''"><strong>Success!</strong> @{{userRegMessages.successMessage}}</div>
              <small class="error-massage" v-show="this.userLoginMessages.serverError != ''"><strong>Sorry!</strong> @{{userLoginMessages.serverError}}</small>
              <form>
                <div class="form-group">
                  <label for="exampleInputEmail1 mb-2">Email address<span class="error-massage">*</span></label>
                  <input type="email" class="form-control" v-model="userLoginData.email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Please enter your email">
                  <small class="error-massage" v-show="this.userLoginMessages.emailError != ''">@{{userLoginMessages.emailError}}</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1 mb-2">Password<span class="error-massage">*</span></label>
                  <input type="password" class="form-control" v-model="userLoginData.password" id="exampleInputPassword1" placeholder="Please enter your password">
                  <small class="error-massage" v-show="this.userLoginMessages.passwordError != ''">@{{userLoginMessages.passwordError}}</small>
                </div>
                <div class="form-check mb-2">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <a href="#" v-on:click="validateLoginForm()" class="btn btn-primary submit mb-4">Sign In</a>
                <p><a href="#"  data-toggle="modal" data-target="#registrationModal" data-dismiss="modal"> Don't have an account?</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModal" aria-hidden="true">
        <div class="modal-dialog modal-content">
          <div>
            <div class="login p-5 bg-light mx-auto mw-100">
              <button type="button" class="close" data-dismiss="modal">&times;</button>  
              <small class="error-massage" v-show="this.userRegMessages.serverErrorMessage != ''"><strong>Sorry!</strong> @{{userRegMessages.serverErrorMessage}}</small>
              <form>
                <div class="form-group">
                  <label for="exampleInputFirstName mb-2">First Name<span class="error-massage">*</span></label>
                  <input type="text" class="form-control" v-model="userRegistrationData.firstName" id="firstName" maxlength="80" aria-describedby="firstNameHelp" placeholder="Please enter your first name">
                  <small class="error-massage" v-show="this.userRegMessages.firstNameError != ''">@{{userRegMessages.firstNameError}}</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputLastName mb-2">Last Name<span class="error-massage">*</span></label>
                  <input type="text" class="form-control" v-model="userRegistrationData.lastName" id="lastName" maxlength="80" aria-describedby="lastNameHelp" placeholder="Please enter your last name">
                  <small class="error-massage" v-show="this.userRegMessages.lastNameError != ''">@{{userRegMessages.lastNameError}}</small>
                </div>
                <div class="form-group">
                  <label class="radio-inline"><input v-model="userRegistrationData.gender" type="radio" value="male" name="gender" checked="checked"> Male</label>
                  <label class="radio-inline"><input v-model="userRegistrationData.gender" type="radio" value="female" name="gender"> Female</label>
                  <label class="radio-inline"><input v-model="userRegistrationData.gender" type="radio" value="other" name="gender"> Other</label><span class="error-massage"> *</span>
                  <div><small class="error-massage" v-show="this.userRegMessages.genderError != ''">@{{userRegMessages.genderError}}</small></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail mb-2">E - mail<span class="error-massage">*</span></label>
                  <input type="email" class="form-control" v-model="userRegistrationData.email" id="email" aria-describedby="emailHelp" maxlength="100" placeholder="Please enter your email">
                  <small class="error-massage" v-show="this.userRegMessages.emailError != ''">@{{userRegMessages.emailError}}</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword mb-2">Password<span class="error-massage">*</span></label>
                  <input type="password" class="form-control" v-model="userRegistrationData.password" id="password" aria-describedby="passwordHelp" maxlength="80" placeholder="Please enter password">
                  <small class="error-massage" v-show="this.userRegMessages.passwordError != ''">@{{userRegMessages.passwordError}}</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputConfirmPassword mb-2">Confirm Password<span class="error-massage">*</span></label>
                  <input type="password" class="form-control" v-model="userRegistrationData.confirmPassword" id="confirmPassword" aria-describedby="confirmPasswordHelp" maxlength="80" placeholder="Please enter again password">
                  <small class="error-massage" v-show="this.userRegMessages.confirmPasswordError != ''">@{{userRegMessages.confirmPasswordError}}</small>
                  <small class="error-massage" v-show="this.userRegMessages.passwordDoesNotMatch != ''">@{{userRegMessages.passwordDoesNotMatch}}</small>
                </div>
                <a href="#" v-on:click="validateRegistrationForm()" class="btn btn-primary submit mb-4">Sign up</a>
                <p><a href="#"  data-toggle="modal" data-target="#loginModal" data-dismiss="modal"> I have an account</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="signOutModal" tabindex="-1" role="dialog" aria-labelledby="signOutModel" aria-hidden="true">
        <div class="modal-dialog modal-content">
          <div>
            <div class="login p-5 bg-light mx-auto mw-100">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <div class="success-message" v-show="this.userRegMessages.successMessage != ''"><strong>Success!</strong> @{{userRegMessages.successMessage}}</div>
              <form v-on:submit.prevent>
                <div class="form-group">
                  Are you sure do you want to sign out ?
                </div>
                <hr>
                <button data-toggle="modal" data-dismiss="modal" class="btn btn-success submit mb-4">Cancel</button>
                <button v-on:click="signOut()" data-toggle="modal" data-dismiss="modal" class="btn btn-danger submit mb-4">Sign out</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <header>
        <div class="top-bar_sub_w3layouts container-fluid">
          <div class="row">
            <div class="col-md-4 logo text-left">
              <a class="navbar-brand"><img src="images/webmob-technologies-new-logo.svg" class="logo-size">
              <i></i> WebMob Technology</a>
            </div>
            <div class="col-md-4 top-forms text-center mt-lg-3 mt-md-1 mt-0">
              <span id="userProfile">
              <span> Welcome! </span><span id="welcome"></span>
              <span class="mx-lg-4 mx-md-2  mx-1" v-if="this.userType=='guest'">
              <a href="#"  data-toggle="modal" data-target="#loginModal">
              <i class="fas fa-lock"></i> Sign In</a>
              </span>
              <span v-if="this.userType=='guest'">
              <a href="#"  data-toggle="modal" data-target="#registrationModal">
              <i class="far fa-user"></i> Register</a>
              </span>
              <span v-if="this.userType=='user'">
              <a href="#"  data-toggle="modal" data-target="#signOutModal">
              <i class="far fa-user"></i> Sign Out</a>
              </span>
            </div>
            <div class="col-md-4 log-icons text-right" v-if="this.userType=='guest'">
                <ul class="social_list1 mt-3">
                  <a class="btn btn-success btn-xs" href="https://github.com/RGodara/webmob-blog" target="_blank">Get Code on GitHub</a>
                </ul>
              </div>
            <div class="col-md-4 log-icons text-right" v-else>
              <ul class="social_list1 mt-3">
                <span class="btn btn-primary btn-xs" href="#" v-on:click="displayModel" data-toggle="modal" data-target="#addBlogModal">Add Blog<span>
              </ul>
            </div>
          </div>
        </div>
        <div class="header_top" id="home" v-if="this.userType=='guest'">
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler navbar-toggler-right mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="#">Home
                  <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="/">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
                </li>
              </ul>
              <span class="form-inline my-2 my-lg-0 header-search">
              <input class="form-control mr-sm-2" type="search" v-on:keyUp="searchBlogByKeyWords"  v-model="searchText" placeholder="Search here..." name="Search" required="">
              <button class="btn btn1 my-2 my-sm-0">
              <i class="fas fa-search"></i>
              </button>
              </span>
            </div>
          </nav>
        </div>
      </header>
      <!--//header-->
      <!--/banner-->
      <div class="banner-inner" v-if="this.userType=='guest'">
      </div>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/">Blog </a>
        </li>
        <li class="breadcrumb-item active"></li>
      </ol>
      <!--//banner-->
      <!--/main-->
      <main class="py-4">
        @yield('content')
      </main>
      <!--footer-->
      <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 footer-grid-agileits-w3ls text-left">
              <h3>About US</h3>
              <p>We build bold Mobile and Web Apps since 2010. Just like action speaks louder than words, our work is the best way to get to know about us. The name itself suggests we're proficient in Web and Mobile App development tailed with providing best IT solution for various sectors.</p>
              <div class="read">
                <a href="tel:+1-408-520-9597" class="btn btn-primary read-m">Call Us +1-408-520-9597</a>
              </div>
            </div>
            <!-- subscribe -->
            <div class="col-lg-4 subscribe-main footer-grid-agileits-w3ls text-left">
              <h2>Signup to our newsletter</h2>
              <div class="subscribe-main text-left">
                <div class="subscribe-form">
                  <span class="subscribe_form">
                  <input class="form-control" type="email" placeholder="Enter your email..." required="">
                  <button type="submit" class="btn btn-primary submit">Submit</button>
                  </span>
                  <div class="clearfix"> </div>
                </div>
                <p>We respect your privacy.No spam ever!</p>
              </div>
              <!-- //subscribe -->
            </div>
          </div>
          <!-- footer -->
          <div class="footer-cpy text-center">
            <div class="footer-social">
              <div class="copyrighttop">
                <ul>
                  <li class="mx-3">
                    <a class="facebook" href="#">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                    </a>
                  </li>
                  <li>
                    <a class="facebook" href="#">
                    <i class="fab fa-twitter"></i>
                    <span>Twitter</span>
                    </a>
                  </li>
                  <li class="mx-3">
                    <a class="facebook" href="#">
                    <i class="fab fa-google-plus-g"></i>
                    <span>Google+</span>
                    </a>
                  </li>
                  <li>
                    <a class="facebook" href="#">
                    <i class="fab fa-pinterest-p"></i>
                    <span>Pinterest</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div>
              <p>© 2018 WebMob. All Rights Reserved | Design by
                <a href="http://techrgodara.com/">Ramesh Kumar</a>
              </p>
            </div>
          </div>
          <!-- //footer -->
        </div>
      </footer>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}" ></script>
    <script src="{{ asset('js/jquery.js') }}" ></script>
    <script src="{{ asset('js/move-top.js') }}" ></script>
    <script src="{{ asset('js/easing.js') }}" ></script>
    <script src="{{ asset('js/bootstrap.js') }}" ></script>
    <script src="{{ asset('js/homePage.js') }}" ></script>
    <script src="{{ asset('js/vue.min.js') }}" ></script>
    @yield('script')
  </body>
</html>