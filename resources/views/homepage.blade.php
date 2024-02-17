<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <svg class="home-top-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#696cff" fill-opacity="1" d="M0,160L48,144C96,128,192,96,288,122.7C384,149,480,235,576,266.7C672,299,768,277,864,250.7C960,224,1056,192,1152,186.7C1248,181,1344,203,1392,213.3L1440,224L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>

    {{-- Nav --}}
    <div class="container pt-4">
      <div class="d-flex justify-content-between align-items-center">
        {{-- <a href="">
          <h2 class="text-lg">{{ config('app.name') }}</h2>
        </a> --}}

        <a href="{{ route('homepage') }}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
            <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                <path
                  d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                  id="path-1"></path>
                <path
                  d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                  id="path-3"></path>
                <path
                  d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                  id="path-4"></path>
                <path
                  d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                  id="path-5"></path>
              </defs>
              <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                  <g id="Icon" transform="translate(27.000000, 15.000000)">
                    <g id="Mask" transform="translate(0.000000, 8.000000)">
                      <mask id="mask-2" fill="white">
                        <use xlink:href="#path-1"></use>
                      </mask>
                      <use fill="#696cff" xlink:href="#path-1"></use>
                      <g id="Path-3" mask="url(#mask-2)">
                        <use fill="#696cff" xlink:href="#path-3"></use>
                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                      </g>
                      <g id="Path-4" mask="url(#mask-2)">
                        <use fill="#696cff" xlink:href="#path-4"></use>
                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                      </g>
                    </g>
                    <g id="Triangle"
                      transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                      <use fill="#696cff" xlink:href="#path-5"></use>
                      <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                    </g>
                  </g>
                </g>
              </g>
            </svg>
          </span>
          <span class="app-brand-text demo text-body fw-bolder">{{ config('app.name') }}</span>
        </a>

        <div>
          @auth
              <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <span class="tf-icons bx bx-user"></span>&nbsp; Dashboard
              </a>
          @endauth

          @guest
              <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                <span class="tf-icons bx bx-user d-none d-sm-inline-block"></span>&nbsp; Login
              </a>
              <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                <span class="tf-icons bx bx-user-plus d-none d-sm-inline-block"></span>&nbsp; Register
              </a>
          @endguest
        </div>
      </div>
    </div>
    {{-- End Nav --}}

    <div class="container" style="margin-top: 100px;">
      <div class="row">
        <div class="col-md-6 col-lg-5">
          <h3>
            <strong class="fs-2">Revolutionize</strong> Your <strong class="fst-italic text-decoration-underline">Workflow</strong> with Our Comprehensive <strong class="text-primary fs-2"><span class="fs-1">Task</span> Management</span> System</strong>
          </h3>
          <p>
            Elevate your productivity to new heights with our cutting-edge Task Management System, designed to empower your team and streamline your projects. Experience the ultimate organizational freedom as you effortlessly add workspaces, projects, and teams to your digital toolkit. Our intuitive interface allows you to create and customize workspaces tailored to your unique needs, ensuring seamless collaboration across diverse projects.
          </p>
          <p class="d-none d-xl-block">
            Break down tasks, set milestones, and enhance team coordination as you delve into the flexibility of managing multiple projects within a single platform. With the ability to effortlessly add and manage teams, you'll foster a collaborative environment that accelerates progress. Embrace a new era of efficiency and innovation as you revolutionize your workflow with our Task Management System.
          </p>
        </div>
        <div class="col-md-6 col-lg-7 mt-5 mb-3">
          <div class="home-cover-img">
            <img src="{{ asset('sneat/assets/img/home.png') }}" alt="hero-image" class="first">
            <img src="{{ asset('sneat/assets/img/home.png') }}" alt="hero-image" class="second">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
              <path fill="#696CFF" d="M54.5,-47.4C62.1,-33.9,53.9,-11.8,48.3,10.3C42.7,32.4,39.7,54.4,27.1,63C14.5,71.7,-7.7,66.9,-30,57.9C-52.3,48.9,-74.6,35.5,-79.1,17.5C-83.6,-0.4,-70.3,-22.9,-54.2,-38.3C-38,-53.7,-19,-61.9,2.2,-63.7C23.5,-65.4,46.9,-60.8,54.5,-47.4Z" transform="translate(100 100)" />
            </svg>
          </div>
        </div>
      </div>
      <p class="d-block d-xl-none">
        Break down tasks, set milestones, and enhance team coordination as you delve into the flexibility of managing multiple projects within a single platform. With the ability to effortlessly add and manage teams, you'll foster a collaborative environment that accelerates progress. Embrace a new era of efficiency and innovation as you revolutionize your workflow with our Task Management System.
      </p>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>
  </body>
</html>
