<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
    <link rel="icon" type="image/png" href="/images/myLogo.png">
    <title>
        NavManage
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="css/nucleo-icons.css" rel="stylesheet" />
    <link href="css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/ffdf620d94.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/myFont.css">
    @vite(['resources/sass/timetable.scss'])

    <style>
        #infos,
        #map,
        #planning {
            scroll-behavior: smooth;
            transition-duration: 1s;
        }

        .my-heading {
            margin: 10px;
            padding: 10px;
            padding-inline: 90px;
        }

        textarea {
            height: 150px;
            /* sets the height to 3 lines of text */
            resize: none;
            /* prevents resizing of the textarea */
        }

        #char-count {
            display: inline-block;
            padding: 0.2em 0.4em;
            font-size: 14px;
            font-weight: 600;
            line-height: 1;
            color: #ffffff;
            background-color: #9454bc;
            border-radius: 0.25rem;
            font-family: Arial, Helvetica, sans-serif;
            box-shadow: 0px 2px 2px black
        }

        .notification-count {
            position: absolute;
            top: -3px;
            right: -6%;
            background-color: red;
            color: white;
            padding: 3px 6px;
            border-radius: 50%;
            font-size: 10px;
        }
    </style>

</head>

<body class="g-sidenav-show bg-gray-100">
    @include('partials._aside')
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
            id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <a href="{{ route('profile') }}">
                        <h6 class="font-weight-bolder mb-0">Profile</h6>
                    </a>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="">Home</a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                                class="nav-link text-body font-weight-bold px-0">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>
                                <span class="d-sm-inline d-none pe-3">Se-deconnecter</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center mx-4">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown d-flex align-items-center">
                            @php
                                $offres = DB::table('offres')
                                    ->where('id_entreprise', $id_entreprise)
                                    ->get();
                                $nbrOffres = DB::table('offres')
                                    ->where('id_entreprise', $id_entreprise)
                                    ->count();
                            @endphp
                            <a href="javascript:;" class="nav-link text-body" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer" style="font-size: 18px !important"></i>
                                <span class="notification-count">{{ $nbrOffres }}</span>
                            </a>

                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton"
                                style="max-height: 400px;width: 400px; overflow-y: auto;">
                                <div class="d-flex text-center">Date fin des offres</div>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($offres as $offre)
                                    @php
                                        $abnm = DB::table('abonnements')
                                            ->where('id_offre', $offres[$i++]->id)
                                            ->first();
                                        $vehiculesAbonnement = DB::table('vehicules')
                                            ->where('id_abonnement', $abnm->id)
                                            ->get();
                                    @endphp
                                    <li class="mb-2">
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ route('infosAbonnement', $abnm->id) }}">
                                            <div class="d-flex py-1">
                                                <div class="my-auto">
                                                    <i class="fa-solid fa-bus me-3" style="font-size: 24px;"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        <span class="font-weight-bold">Offres
                                                            {{ $offre->titre }}</span>
                                                        @php
                                                            $abn = DB::table('abonnements')
                                                                ->where('id_offre', $offre->id)
                                                                ->first();
                                                            $nbrClients = DB::table('paiements')
                                                                ->join('clients', 'clients.id', '=', 'paiements.id_client')
                                                                ->where('id_abonnement', $abn->id)
                                                                ->count();

                                                            $capacite = 0;
                                                            foreach ($vehiculesAbonnement as $vehicule) {
                                                                $capacite = $capacite + $vehicule->capacite;
                                                            }

                                                            $estPlien = $capacite - $nbrClients;
                                                            $dateFinOffre = \Carbon\Carbon::parse($offre->dateFinOffre);
                                                        @endphp
                                                        @php
                                                            $backgroundColor = $dateFinOffre > now() ? 'green' : 'red';
                                                        @endphp
                                                        <div class="offre-container"
                                                            style="background-color: {{ $backgroundColor }}">
                                                            <p style="color: #ffffff">

                                                                @if ($dateFinOffre > now())
                                                                    Il reste {{ $dateFinOffre->diffInDays(now()) }}
                                                                    jours
                                                                @elseif ($estPlien == 0)
                                                                    offre est pleine
                                                                @else
                                                                    L'offre est expirée
                                                                @endif
                                                            </p>
                                                            <!-- Display other details of the offer -->
                                                        </div>
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <i class="fa fa-clock me-1"></i>
                                                        creer a {{ $offre->created_at }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="d-flex justify-content-center">
            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl shadow-none position-fixed blur shadow-blur mt-3 left-auto top-1 z-index-sticky"
                navbar-scroll="true">
                <div class="text-center">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                            <li class="nav-item pe-3" style="padding-left: 10px">
                                <a class="nav-link mb-0 px-0 py-1 active" href="#infos">
                                    <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                                fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(603.000000, 0.000000)">
                                                        <path class="color-background"
                                                            d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                        </path>
                                                        <path class="color-background"
                                                            d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                            opacity="0.7"></path>
                                                        <path class="color-background"
                                                            d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                            opacity="0.7"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ms-1">Infos</span>
                                </a>
                            </li>
                            <li class="nav-item pe-3" style="padding-left: 10px">
                                <a class="nav-link mb-0 px-0 py-1 "href="#map" role="tab"
                                    aria-selected="false">
                                    <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 40"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>Map</title>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF"
                                                fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(304.000000, 151.000000)">
                                                        <polygon class="color-background" opacity="0.596981957"
                                                            points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                                        </polygon>
                                                        <path class="color-background"
                                                            d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                                                            opacity="0.596981957"></path>
                                                        <path class="color-background"
                                                            d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ms-1">Map</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" href="#revenu">
                                    <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                                fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(603.000000, 0.000000)">
                                                        <path class="color-background"
                                                            d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                        </path>
                                                        <path class="color-background"
                                                            d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                            opacity="0.7"></path>
                                                        <path class="color-background"
                                                            d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                            opacity="0.7"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ms-1">Revenu</span>
                                </a>
                            </li>
                            <li class="nav-item pe-3" style="padding-left: 10px">
                                <a class="nav-link mb-0 px-0 py-1 " href="#planning">
                                    <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 44"
                                        version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>Planning</title>
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                                fill-rule="nonzero">
                                                <g transform="translate(1716.000000, 291.000000)">
                                                    <g transform="translate(154.000000, 300.000000)">
                                                        <path class="color-background"
                                                            d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                            opacity="0.603585379"></path>
                                                        <path class="color-background"
                                                            d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="ms-1">Planning</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- End Navbar -->
        <div class="container-fluid" id="profId">
            @php
                $imagePath1 = asset('img/curved-images/curved5-small.jpg');
            @endphp
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('{{ $imagePath1 }}'); background-position-y: 50%;">
                {{-- <span class="mask bg-gradient-primary opacity-6"></span> --}}
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ 'images/' . $entreprise->image }}" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $entreprise->nom }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ $entreprise->secteur }}
                            </p>
                        </div>
                    </div>
                    <hr class="horizontal gray-light my-2">
                    <div class="w-100 col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-4">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="#infos">
                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(603.000000, 0.000000)">
                                                            <path class="color-background"
                                                                d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                            </path>
                                                            <path class="color-background"
                                                                d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                                opacity="0.7"></path>
                                                            <path class="color-background"
                                                                d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                                opacity="0.7"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ms-1">About</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 "href="#map" role="tab"
                                        aria-selected="false">
                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 40"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>Map</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(304.000000, 151.000000)">
                                                            <polygon class="color-background" opacity="0.596981957"
                                                                points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                                            </polygon>
                                                            <path class="color-background"
                                                                d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                                                                opacity="0.596981957"></path>
                                                            <path class="color-background"
                                                                d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ms-1">Map</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="#revenu">
                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2319.000000, -291.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(603.000000, 0.000000)">
                                                            <path class="color-background"
                                                                d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z">
                                                            </path>
                                                            <path class="color-background"
                                                                d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z"
                                                                opacity="0.7"></path>
                                                            <path class="color-background"
                                                                d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z"
                                                                opacity="0.7"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ms-1">Revenu</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 " href="#planning">
                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 44"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>Planning</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(154.000000, 300.000000)">
                                                            <path class="color-background"
                                                                d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                                opacity="0.603585379"></path>
                                                            <path class="color-background"
                                                                d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="ms-1">Planning</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-container container-fluid py-4">
            <div class="row infos" id="infos">
                <div class="col-12 col-xl-4 w-100">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Profile Information</h6>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a class="afficherAdd btn fixed-plugin-button-nav cursor-pointer" href="#">
                                        <i class="fas fa-user-edit text-secondary " data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Edit Profile"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <p class="text-sm">
                                {{ $entreprise->description }}
                            </p>
                            <hr class="horizontal gray-light my-4">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom
                                        Complet:</strong> &nbsp; {{ $entreprise->nom }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Téléphone:</strong> &nbsp; {{ $entreprise->telephone }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Email:</strong> &nbsp; {{ $entreprise->email }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Adresse:</strong> &nbsp; {{ $entreprise->adresse }}</li>
                                <li class="list-group-item border-0 ps-0 pb-0">
                                <li class="list-group-item border-0 ps-0 text-sm"><strong
                                        class="text-dark">Site-web:</strong> &nbsp; <a
                                        href="{{ $entreprise->siteWeb }}">{{ $entreprise->siteWeb }}</a></li>
                                <li class="list-group-item border-0 ps-0 pb-0">
                                    <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                    <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-facebook fa-lg"></i>
                                    </a>
                                    <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-twitter fa-lg"></i>
                                    </a>
                                    <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row map" id="map">
                <div class="col-12 col-xl-4 w-100">
                    <div class="card h-100">
                        <br>
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="px-4">Adresse location</h6>
                        </div>
                        <div class="card mb-4 rounded shadow d-flex align-items-center p-5">
                            <iframe class="rounded shadow"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3297.6459476917344!2d-6.586897525034254!3d34.25757690686162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7597ffa4bd567%3A0xee9b08afc9523978!2sKenitra%20centre%20ville!5e0!3m2!1sfr!2sma!4v1684063945291!5m2!1sfr!2sma"
                                width="1000" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            @php

                // Get the current count of clients
                $currentClientCount = DB::table('client_entreprises')
                    ->where('id_entreprise', $entreprise->id)
                    ->count();
                //le nombre de mes client_entreprise

                $currentDayClientCount = DB::table('client_entreprises')
                    ->where('id_entreprise', $entreprise->id)
                    ->whereDate('created_at', Carbon\Carbon::now()->format('Y-m-d'))
                    ->count();

                // Calculate the difference in client count
                $percentageChange = 0;
                if ($currentClientCount != 0) {
                    $percentageChange = ($currentDayClientCount / $currentClientCount) * 100;
                }

                //____________________________
                $allMyclientsAbonnes = DB::table('client_abonnes')
                    ->where('id_entreprise', $entreprise->id)
                    ->get();
                //le nombre de mes client_entreprise
                $nbrMyClientsAbn = $allMyclientsAbonnes->count();
                $currentClientAbnCount = DB::table('client_abonnes')
                    ->where('id_entreprise', $entreprise->id)
                    ->count();

                $currentDayClientCount = DB::table('client_abonnes')
                    ->where('id_entreprise', $entreprise->id)
                    ->whereDate('created_at', Carbon\Carbon::now()->format('Y-m-d'))
                    ->count();

                $percentageChangeAbn = 0;
                if ($currentClientAbnCount != 0) {
                    $percentageChangeAbn = ($currentDayClientCount / $currentClientAbnCount) * 100;
                }

                //_____________________
                $mesAbns = DB::table('abonnements')
                    ->where('id_entreprise', $entreprise->id)
                    ->get();
                $idsAbonnements = $mesAbns->pluck('id'); // Get an array of 'id' values from $mesAbns collection
                $mesPaiementsEntrep = DB::table('paiements')
                    ->whereIn('id_abonnement', $idsAbonnements)
                    ->get();
                $totalSales = $mesPaiementsEntrep->sum('montant');

                $mesCurrentDayPaiementsEntrep = DB::table('paiements')
                    ->whereIn('id_abonnement', $idsAbonnements)
                    ->whereDate('created_at', Carbon\Carbon::now()->format('Y-m-d'))
                    ->get();
                $currentSales = $mesCurrentDayPaiementsEntrep->sum('montant');
                $percentageDifference = 0;
                if ($totalSales != 0) {
                    $percentageDifference = ($currentSales / $totalSales) * 100;
                }
                //_____________________
                $yesterday = Carbon\Carbon::yesterday()->format('Y-m-d');
                $mesPaiementsEntrepYesterday = DB::table('paiements')
                    ->whereIn('id_abonnement', $idsAbonnements)
                    ->whereDate('created_at', $yesterday)
                    ->get();
                $totalSalesYesterday = $mesPaiementsEntrepYesterday->sum('montant');

                $percentageDifferenceYesterday = 0;
                if ($totalSales != 0) {
                    $percentageDifferenceYesterday = ($totalSalesYesterday / $totalSales) * 100;
                }
                $percentageDifferenceToday = 0;
                if ($totalSales != 0) {
                    $percentageDifferenceToday = ($currentSales / $totalSales) * 100;
                }

                $differenceSales = $percentageDifferenceToday - $percentageDifferenceYesterday;

            @endphp
            <div class="row revenu" id="revenu">
                <div class="col-12 col-xl-4 w-100">
                    <div class="card h-100">
                        <div class="card mb-4">
                            <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Statistiques quotidiennes</h5>
                            </div>
                            <div class="card-header pb-0">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                                                Revenu du jour</p>
                                                            <h5 class="font-weight-bolder mb-0">
                                                                ${{ number_format($currentSales, 0, '.', ',') }}
                                                                @if ($differenceSales > 0)
                                                                    <span
                                                                        class="text-success text-sm font-weight-bolder">+{{ number_format($differenceSales, 2) }}%</span>
                                                                @else
                                                                    <span
                                                                        class="text-danger text-sm font-weight-bolder">{{ number_format($differenceSales, 2) }}%</span>
                                                                @endif
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div
                                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                            <i class="ni ni-money-coins text-lg opacity-10"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                                                Abonnements</p>
                                                            <h5 class="font-weight-bolder mb-0">
                                                                +{{ $nbrMyClientsAbn }}
                                                                @if ($percentageChangeAbn > 0)
                                                                    <span
                                                                        class="text-success text-sm font-weight-bolder">+{{ $percentageChangeAbn }}%</span>
                                                                @elseif ($percentageChangeAbn == 0)
                                                                    <span
                                                                        class="text-danger text-sm font-weight-bolder">{{ $percentageChangeAbn }}%</span>
                                                                @else
                                                                    <span
                                                                        class="text-danger text-sm font-weight-bolder">-{{ $percentageChangeAbn }}%</span>
                                                                @endif
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div
                                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                            <i class="ni ni-world text-lg opacity-10"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                                                Nouveaux clients</p>
                                                            <h5 class="font-weight-bolder mb-0">
                                                                +{{ $currentClientCount }}

                                                                @if ($percentageChange > 0)
                                                                    <span
                                                                        class="text-success text-sm font-weight-bolder">+{{ $percentageChange }}%</span>
                                                                @elseif ($percentageChange == 0)
                                                                    <span
                                                                        class="text-danger text-sm font-weight-bolder">{{ $percentageChange }}%</span>
                                                                @else
                                                                    <span
                                                                        class="text-danger text-sm font-weight-bolder">-{{ $percentageChange }}%</span>
                                                                @endif

                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div
                                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                            <i class="ni ni-paper-diploma text-lg opacity-10"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card">
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="numbers">
                                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                                                Ventes</p>
                                                            @if ($totalSales >= 1000000)
                                                                <?php $formattedSales = number_format($totalSales / 1000000, 1) . 'M'; ?>
                                                            @elseif ($totalSales >= 1000)
                                                                <?php $formattedSales = number_format($totalSales, 0, '.', ','); ?>
                                                            @else
                                                                <?php $formattedSales = $totalSales; ?>
                                                            @endif

                                                            <h5 class="font-weight-bolder mb-0">
                                                                ${{ $formattedSales }}
                                                            </h5>
                                                            <h6 class="text-muted mt-0">
                                                                ${{ number_format($totalSales, 0, '.', ',') }}
                                                            </h6>
                                                            @if ($percentageDifference > 0)
                                                                <span
                                                                    class="text-success text-sm font-weight-bolder">+{{ number_format($percentageDifference, 2) }}%</span>
                                                            @else
                                                                <span
                                                                    class="text-danger text-sm font-weight-bolder">{{ number_format($percentageDifference, 2) }}%</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div
                                                            class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                            <i class="fa-solid fa-bus text-lg opacity-10"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row planning" id="planning">
                <div class="col-12 col-xl-4 w-100">
                    <div class="card h-100">
                        <div class="card mb-4">
                            <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Planning des voyages</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    @if (!$abonnementss)
                                        <div class="text-center">
                                            <h2 style="color: #999; font-style: italic;">Aucun offre enregistrer pour
                                                le moment</h2>
                                        </div>
                                    @else
                                        <div class="card mb-4">
                                            @php
                                                // Récupérer le nom du mois actuel
                                                $currentMonth = date('F'); // Obtient le nom complet du mois (ex: May)

                                                // Calculer le nombre de semaines écoulées avec une précision décimale
                                                $startDate = new DateTime(date('Y-m-01')); // Date du premier jour du mois actuel
                                                $today = new DateTime(date('Y-m-d')); // Date actuelle
                                                $daysPassed = $today->diff($startDate)->format('%a'); // Nombre de jours écoulés
                                                $weekNumber = ceil($daysPassed / 7); // Arrondir le nombre de semaines à l'entier supérieur

                                                // Afficher le résultat dans la vue Blade

                                            @endphp
                                            <div class="card-header text-center pb-0 d-flex justify-content-center">
                                                <h2 class="mb-0 border-bottom"> {{ $currentMonth }} :
                                                    {{ $weekNumber }}ème
                                                    semaine
                                                </h2>
                                                <hr class="horizontal gray-light my-4">
                                            </div>

                                            <div class="card-body px-0 pt-0 pb-2 py-2">
                                                <div class="timetable">
                                                    <div class="week-names">
                                                        <div>Lundi</div>
                                                        <div>Mardi</div>
                                                        <div>Mercredi</div>
                                                        <div>Jeudi</div>
                                                        <div>Vendredi</div>
                                                        <div class="weekend">Samedi</div>
                                                        <div class="weekend">Dimanche</div>
                                                    </div>
                                                    <div class="time-interval">
                                                        <div>6:00 - 9:00</div>
                                                        <div>9:00 - 12:00</div>
                                                        <div>12:00 - 15:00</div>
                                                        <div>15:00 - 18:00</div>
                                                        <div>18:00 - 21:00</div>
                                                        <div>21:00 - 00:00</div>
                                                    </div>

                                                    @php
                                                        $heur = 0;
                                                    @endphp


                                                    <div class="content">
                                                        @foreach ($abonnementss as $index => $abonnements)
                                                        @php
                                                            $heur++;
                                                        @endphp
                                                            @if ($abonnements->isNotEmpty())
                                                                @for ($day = 1; $day <= 7; $day++)
                                                                    @php
                                                                        $nbrAbn = DB::table('date_abonnements')
                                                                            ->whereIn('id_abonnement', $abonnements->pluck('id')->toArray())
                                                                            ->where('id_jour', $day)
                                                                            ->count();
                                                                        $idsAbns = DB::table('date_abonnements')
                                                                            ->whereIn('id_abonnement', $abonnements->pluck('id')->toArray())
                                                                            ->where('id_jour', $day)
                                                                            ->select('id_abonnement')
                                                                            ->get();

                                                                        $abonIds = $idsAbns->pluck('id_abonnement')->toArray();

                                                                        $abns = DB::table('abonnements')
                                                                            ->whereIn('id', $abonIds)
                                                                            ->get();
                                                                    @endphp
                                                                    {{-- @ --}}
                                                                    @php
                                                                        $colors = ['accent-orange-gradient', 'accent-green-gradient', 'accent-cyan-gradient', 'accent-pink-gradient', 'accent-purple-gradient'];

                                                                        $randomColor = $colors[array_rand($colors)];
                                                                    @endphp
                                                                    @if ($nbrAbn > 0)
                                                                        <form action="{{ route('voyages') }}"
                                                                            method="post" class="myForm"
                                                                            data-index="{{ $index }}"
                                                                            data-day="{{ $day }}">
                                                                            @csrf
                                                                            <a
                                                                                onclick="submitForm(event, {{ $index }}, {{ $day }})">
                                                                                <input type="hidden" name="heur"
                                                                                    value="{{ $heur }}">
                                                                                <input type="hidden" name="day"
                                                                                    value="{{ $day }}">
                                                                                <div class="myTime {{ $randomColor }}"
                                                                                    style="display: flex; flex-direction: column; align-items: center;">
                                                                                    <div class="row"
                                                                                        style="text-align: center;">
                                                                                        {{ $nbrAbn }} voyages
                                                                                        @foreach ($idsAbns as $idsAbn)
                                                                                            <input type="hidden"
                                                                                                name="abonnements[]"
                                                                                                value="{{ $idsAbn->id_abonnement }}">
                                                                                        @endforeach
                                                                                    </div>

                                                                                    <div class="avatar-group mt-2"
                                                                                        style="display: flex; justify-content: center;">
                                                                                        @php
                                                                                            $counter = 0;
                                                                                        @endphp

                                                                                        @foreach ($abns as $abn)
                                                                                            @php
                                                                                                $entrep = DB::table('entreprises')
                                                                                                    ->where('id', $abn->id_entreprise)
                                                                                                    ->first();
                                                                                            @endphp

                                                                                            @if ($counter < 5)
                                                                                                <a href="javascript:;"
                                                                                                    class="avatar avatar-xs rounded-circle"
                                                                                                    data-bs-toggle="tooltip"
                                                                                                    data-bs-placement="bottom"
                                                                                                    title="{{ $entrep->nom }}">
                                                                                                    <img alt="Image placeholder"
                                                                                                        src="{{ asset('/images/' . $entrep->image) }}">
                                                                                                </a>
                                                                                            @endif

                                                                                            @php
                                                                                                $counter++;
                                                                                            @endphp
                                                                                        @endforeach

                                                                                        @if ($counter > 5)
                                                                                            <a href="javascript:;"
                                                                                                class="avatar avatar-xs rounded-circle"
                                                                                                data-bs-toggle="tooltip"
                                                                                                data-bs-placement="bottom"
                                                                                                title="...">
                                                                                                <span
                                                                                                    class="more-counter">+{{ $counter - 5 }}</span>
                                                                                            </a>
                                                                                        @endif



                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </form>
                                                                    @else
                                                                        <div class="weekend"></div>
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @foreach (range(1, 7) as $index)
                                                                    <div class="weekend"></div>
                                                                @endforeach
                                                            @endif
                                                        @endforeach

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold"
                                    target="_blank">Creative Tim</a>
                                for a better web.
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                        target="_blank">Creative Tim</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                        target="_blank">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                        target="_blank">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                        target="_blank">License</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="fixed-plugin ">
        <div class="augmenterWidth card shadow-lg overflow-auto">
            <div class="card-header pb-0 pt-3 ">
                <div class="mt-3">
                    <h6 class="mb-0" style="display: inline-block; margin-right: 10px;">Navbar Fixed</h6>
                    <button class="closer btn btn-link text-dark p-0 " style="display: inline-block; float: right;">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>

                <hr class="horizontal dark my-sm-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div>
                        <h4 class="mt-3 mb-0 text-shadow font-weight-bold border-bottom text-center my-heading"
                            style="border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">Modifier Profile
                            d'information</h4>
                        <hr class="horizontal dark my-sm-4">
                    </div>
                </div>

                <form action="{{ route('entreprise.update', $entreprise->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body pt-4 p-3"
                        style="border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                        <div class="form-group">
                            <h5 class="mt-3 mb-0"><i class="fa-solid fa-id-card-clip pe-2"
                                    style="font-size: 24px"></i>Modifier votre informations : </h5>
                            <hr class="horizontal dark my-sm-4">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nom</label>
                            <input class="form-control @error('nom') is-invalid @enderror" type="text"
                                name="nom" value="{{ $entreprise->nom }}" id="example-text-input">
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Adresse</label>
                            <input class="form-control @error('adresse') is-invalid @enderror" type="text"
                                name="adresse" value="{{ $entreprise->adresse }}" id="example-text-input">
                            @error('adresse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="form-control-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                name="email" value="{{ $entreprise->email }}" id="example-text-input">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Telephone</label>
                            <input class="form-control @error('telephone') is-invalid @enderror" type="text"
                                name="telephone" value="{{ $entreprise->telephone }}" id="example-text-input">
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Site web</label>
                            <input class="form-control @error('siteWeb') is-invalid @enderror" type="url"
                                name="siteWeb" value="{{ $entreprise->siteWeb }}" id="example-text-input">
                            @error('siteWeb')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Secteur de domaine</label>
                            <input class="form-control @error('secteur') is-invalid @enderror" type="text"
                                name="secteur" value="{{ $entreprise->secteur }}" id="example-text-input">
                            @error('secteur')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Secteur de domaine</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                placeholder="Description" aria-label="Description" aria-describedby="description-addon" maxlength="500">{{ $entreprise->description }}</textarea>
                            <span id="char-count">500</span>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" accept="image/*" aria-label="Image Upload"
                                aria-describedby="image-addon">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <hr class="horizontal dark my-sm-4">
                    <button class="btn bg-gradient-dark w-100" type="submit">Modifier et Enregistrer</button>
                    <button class="btn btn-outline-dark w-100" type="button" onclick="resetForm()">Annuler
                        l'opération</button>
                    <!-- le button anuller l'operation juste retourne tout les champs a ses value old -->
                </form>
                <form class="text-center" action="{{ route('profile.passwordChange', $entreprise->id) }}"
                    method="post">
                    @csrf
                    @method('PATCH')
                    <hr class="horizontal dark my-sm-4">
                    <div class="card-body pt-4 p-3"
                        style="border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
                        <div class="form-group d-flex">
                            <h5 class="mt-3 mb-0"><i class="fa-solid fa-shield-halved pe-2"
                                    style="font-size: 24px"></i>Securite</h5>
                            <hr class="horizontal dark my-sm-4">
                        </div>
                        {{-- as Bar search --}}
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label"
                                style="font-size: 15px; font-family: Georgia, 'Times New Roman', Times, serif">Changer
                                votre mot de
                                passe</label><br>
                            {{-- <button type="button" id="generate-select">Generate Select Form</button> --}}
                            <div class="mb-3">
                                <input type="password" class="form-control @error('passwordAct') is-invalid @enderror"
                                    name="passwordAct" placeholder="Password actuel" aria-label="PasswordAct"
                                    aria-describedby="password-addon">
                                @error('passwordAct')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Nouveau Password" aria-label="Password"
                                    aria-describedby="password-addon">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirmer Nouveau Password" aria-label="Confirm Password"
                                    aria-describedby="password-addon">
                            </div>
                        </div>
                        <hr class="horizontal dark my-sm-4">
                        <button class="btn bg-gradient-dark w-100" type="submit"
                            style="width: 300px !important">Modifier et Enregistrer</button>

                        {{-- une autre chose sur l'id de lentreprise ne pas l'oublie --}}
                    </div>
                    <hr class="horizontal dark my-sm-4">

                </form>
            </div>


        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="js/core/popper.min.js"></script>
    <script src="js/core/bootstrap.min.js"></script>
    <script src="js/plugins/perfect-scrollbar.min.js"></script>
    <script src="js/plugins/smooth-scrollbar.min.js"></script>

    <script>
        @if (session('success'))
            alert("{{ session('success') }}");
        @endif

        @if ($errors->any())
            var errorMessage = "Errors:\n";
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}\n";
            @endforeach
            alert(errorMessage);
        @endif
    </script>

    <script>
        function resetForm() {
            window.location.reload(); // reload the page to reset all form fields
        }
    </script>
    <script>
        const afficherAddLink = document.querySelector('a.afficherAdd');
        const closeAddLink = document.querySelector('.closer');

        afficherAddLink.addEventListener('click', function(event) {
            event.preventDefault();

            const cardDiv = document.querySelector('div.augmenterWidth');
            cardDiv.style.width = '700px';
        });

        document.addEventListener('click', function(event) {
            if (event.target.tagName.toLowerCase() != 'a') {
                const cardDiv = document.querySelector('div.augmenterWidth');
                if (!event.target.closest('div.augmenterWidth')) {
                    cardDiv.style.width = '200px';
                }
            }
        });
    </script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        const textarea = document.querySelector('textarea');
        const charCount = document.querySelector('#char-count');

        textarea.addEventListener('input', function() {
            const remainingChars = 500 - textarea.value.length;
            charCount.innerText = remainingChars;

            if (remainingChars < 0) {
                charCount.classList.add('text-danger');
                textarea.classList.add('is-invalid');
                navigator.vibrate(100); // vibrate for 100ms
            } else {
                charCount.classList.remove('text-danger');
                textarea.classList.remove('is-invalid');
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.notification-count').hide();
            });
        });
    </script>

    <script>
        function submitForm(event, index, day) {
            event.preventDefault(); // Prevent the default link behavior

            // Get the form element and submit it
            const form = document.querySelector(`form.myForm[data-index="${index}"][data-day="${day}"]`);
            form.submit();
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="js/soft-ui-dashboard.min.js?v=1.0.7"></script>
</body>

</html>
