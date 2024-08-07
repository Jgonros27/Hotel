<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="htmlElement">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="{{ asset('images/logos/logoFenecCirculo.jpg') }}" />
    <title>{{ __('menu.hotel') }}</title>
    @stack('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    <style>
        html {
            scroll-behavior: smooth;

        }

        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
            overflow-x: hidden;
        }

        .divisor {
            border: #cbc9c9 1px solid;
        }


        #principio {
            display: flex;
            align-items: center;
            position: sticky;
            left: 0;
            top: 0;
            width: 100%;
            height: 73px;
            background-color: #474242;
            z-index: 1000;
            color: wheat;
        }

        #principio img,
        #principio h1 {
            margin: 0;
        }

        #principio img {
            width: 70px !important;
            height: 70px !important;
        }

        .navbar {
            position: absolute !important;
            top: 10px;
            right: 10px;
            z-index: 1051;
            background-color: wheat;
            width: fit-content;
            border-radius: 10px;
        }

        .navbar-toggler {
            border: none !important;
        }

        .offcanvas-start {
            background-color: white;
            color: black;
            transform: translateX(-100%);
            visibility: hidden;
            transition: transform 0.3s ease-in-out;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            font-size: 17px
        }

        .offcanvas-start.show {
            transform: translateX(0);
            visibility: visible;
        }

        .offcanvas-start .nav-link,
        .btn-link {
            color: black !important;
            text-decoration: none;
        }

        .offcanvas-start .nav-link:hover,
        .btn-link:hover {
            background-color: rgba(136, 135, 135, 0.1) !important;
            text-decoration: none !important;
        }

        /* Ajustes para el logo */
        .menu-logo {
            width: 110px;
            height: 110px !important;
        }

        /* Mover el botón del idioma al final del menú a la izquierda */
        #languageButton {
            position: absolute;
            bottom: 0;
            left: 1rem;
            width: 90%
        }

        #languageButton a{
            display: inline;
        }

        #languageButton a:hover{
            display: inline;
            background-color: white !important;
        }

        #languageButton img {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
    <style>
        #successMessage {
            margin-top: 80px;
            margin-right: 50px;
            z-index: 1050;
        }

        #falloMessage {
            margin-top: 80px;
            margin-right: 50px;
            z-index: 1050;
        }
    </style>
    <style>
        a {
            color: #fff;
            text-decoration: none;
        }




        .footer {
            background-color: #004658;
            color: #fff;
        }

        .footer-wave-svg {
            background-color: transparent;
            display: block;
            height: 30px;
            position: relative;
            top: -1px;
            width: 100%;
        }

        .footer-wave-path {
            fill: #fffff2;
        }

        .footer-content {
            margin-left: auto;
            margin-right: auto;
            max-width: 1230px;
            padding: 40px 15px 450px;
            position: relative;
        }

        .footer-content-column {
            box-sizing: border-box;
            float: left;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%;
            color: #fff;
        }

        .footer-content-column ul li a {
            color: #fff;
            text-decoration: none;
        }

        .footer-logo-link {
            display: inline-block;
        }

        .footer-menu {
            margin-top: 30px;
        }

        .footer-menu-name {
            color: #fffff2;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: .1em;
            line-height: 18px;
            margin-bottom: 0;
            margin-top: 0;
            text-transform: uppercase;
        }

        .footer-menu-list {
            list-style: none;
            margin-bottom: 0;
            margin-top: 10px;
            padding-left: 0;
        }

        .footer-menu-list li {
            margin-top: 5px;
        }

        .footer-call-to-action-description {
            color: #fffff2;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .footer-call-to-action-button:hover {
            background-color: #fffff2;
            color: #00bef0;
        }

        .button:last-of-type {
            margin-right: 0;
        }

        .footer-call-to-action-button {
            background-color: #027b9a;
            border-radius: 21px;
            color: #fffff2;
            display: inline-block;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .1em;
            line-height: 18px;
            padding: 12px 30px;
            margin: 0 10px 10px 0;
            text-decoration: none;
            text-transform: uppercase;
            transition: background-color .2s;
            cursor: pointer;
            position: relative;
        }

        .footer-call-to-action {
            margin-top: 30px;
        }

        .footer-call-to-action-title {
            color: #fffff2;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: .1em;
            line-height: 18px;
            margin-bottom: 0;
            margin-top: 0;
            text-transform: uppercase;
        }

        .footer-call-to-action-link-wrapper {
            margin-bottom: 0;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }

        .footer-call-to-action-link-wrapper a {
            color: #fff;
            text-decoration: none;
        }





        .footer-social-links {
            bottom: 0;
            height: 54px;
            position: absolute;
            right: 0;
            width: 236px;
        }

        .footer-social-amoeba-svg {
            height: 54px;
            left: 0;
            display: block;
            position: absolute;
            top: 0;
            width: 236px;
        }

        .footer-social-amoeba-path {
            fill: #027b9a;
        }

        .footer-social-link.linkedin {
            height: 26px;
            left: 3px;
            top: 11px;
            width: 26px;
        }

        .footer-social-link {
            display: block;
            padding: 10px;
            position: absolute;
        }

        .hidden-link-text {
            position: absolute;
            clip: rect(1px 1px 1px 1px);
            clip: rect(1px, 1px, 1px, 1px);
            -webkit-clip-path: inset(0px 0px 99.9% 99.9%);
            clip-path: inset(0px 0px 99.9% 99.9%);
            overflow: hidden;
            height: 1px;
            width: 1px;
            padding: 0;
            border: 0;
            top: 50%;
        }

        .footer-social-icon-svg {
            display: block;
        }

        .footer-social-icon-path {
            fill: #fffff2;
            transition: fill .2s;
        }

        .footer-social-link.twitter {
            height: 28px;
            left: 62px;
            top: 3px;
            width: 28px;
        }

        .footer-social-link.youtube {
            height: 24px;
            left: 123px;
            top: 12px;
            width: 24px;
        }

        .footer-social-link.github {
            height: 34px;
            left: 172px;
            top: 7px;
            width: 34px;
        }

        .footer-copyright {
            background-color: #027b9a;
            color: #fff;
            padding: 15px 30px;
            text-align: center;
        }

        .footer-copyright-wrapper {
            margin-left: auto;
            margin-right: auto;
            max-width: 1200px;
        }

        .footer-copyright-text {
            color: #fff;
            font-size: 13px;
            font-weight: 400;
            line-height: 18px;
            margin-bottom: 0;
            margin-top: 0;
        }

        .footer-copyright-link {
            color: #fff;
            text-decoration: none;
        }

        footer a:not(.footer-call-to-action-button):hover {
            color: wheat !important;
        }

        .footer-call-to-action-button {
            transition: all 0.2s ease-in;
        }

        .footer-call-to-action-button:hover {
            transform: scale(1.2);
        }











        /* Media Query For different screens */
        @media (min-width:320px) and (max-width:479px) {

            /* smartphones, portrait iPhone, portrait 480x320 phones (Android) */
            .footer-content {
                margin-left: auto;
                margin-right: auto;
                max-width: 1230px;
                padding: 40px 15px 1050px;
                position: relative;
            }
        }

        @media (min-width:480px) and (max-width:599px) {

            /* smartphones, Android phones, landscape iPhone */
            .footer-content {
                margin-left: auto;
                margin-right: auto;
                max-width: 1230px;
                padding: 40px 15px 1050px;
                position: relative;
            }
        }

        @media (min-width:600px) and (max-width: 800px) {

            /* portrait tablets, portrait iPad, e-readers (Nook/Kindle), landscape 800x480 phones (Android) */
            .footer-content {
                margin-left: auto;
                margin-right: auto;
                max-width: 1230px;
                padding: 40px 15px 1050px;
                position: relative;
            }
        }

        @media (min-width:801px) {
            /* tablet, landscape iPad, lo-res laptops ands desktops */

        }

        @media (min-width:1025px) {
            /* big landscape tablets, laptops, and desktops */

        }

        @media (min-width:1281px) {
            /* hi-res laptops and desktops */

        }




        @media (min-width: 760px) {
            .footer-content {
                margin-left: auto;
                margin-right: auto;
                max-width: 1230px;
                padding: 40px 15px 450px;
                position: relative;
            }

            .footer-wave-svg {
                height: 50px;
            }

            .footer-content-column {
                width: 24.99%;
            }
        }

        @media (min-width: 568px) {
            /* .footer-content-column {
            width: 49.99%;
        } */
        }
    </style>
</head>

<body>
    @if (session()->has('success'))
        <div id="successMessage"
            class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 mt-5 me-5" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('fallo'))
        <div id="falloMessage"
            class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 mt-5 me-5" role="alert">
            <strong>{{ session()->get('fallo') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div id="principio">
        <a href="{{route('home')}}"><img class="logo" src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" alt="Logo" style="height: 40px;"></a>
        <h1>{{ __('menu.hotel') }}</h1>
        <!-- Icono de menú en esquina superior derecha -->
        <nav class="navbar ">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-controls="mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>



    <!-- Menú desplegable -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <!-- Logo dentro del menú -->
            <img class="menu-logo" src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" alt="Logo"
                style="height: 40px;">
            <h5 class="offcanvas-title">{{ __('menu.hotel') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <div class="divisor"></div>
                <!-- Menú izquierdo -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inicio') }}"><i class="bi bi-house-door me-2"></i>
                        {{ __('menu.home') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="cabanasDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-house-fill me-2"></i> {{ __('menu.cabins') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="cabanasDropdown">
                        <li><a class="dropdown-item" href="{{ route('tipoCabanas.index') }}">{{ __('menu.allCabins') }}</a></li>
                        @foreach ($cabanas as $cabana)
                            <li><a class="dropdown-item"
                                    href="{{ route('tipoCabanas.show',$cabana->id)}}">{{ ucwords($cabana->nombre) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="salonesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-door-closed-fill me-2"></i> {{ __('menu.rooms') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="salonesDropdown">
                        <li><a class="dropdown-item" href="{{ route('salons.index') }}">{{ __('menu.allRooms') }}</a></li>
                        @foreach ($salones as $salon)
                            <li><a class="dropdown-item"
                                    href="{{ route('salons.index') }}#{{ $salon->nombre }}">{{ ucwords($salon->nombre) }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('reservas.index') }}"><i class="bi bi-question-circle-fill me-2"></i>
                            {{ __('menu.reservations') }}</a>
                    @else
                        <a id="loginLink" class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-fill me-2"></i>
                            {{ __('menu.login') }}</a>
                    @endauth
                </li>
                <li class="nav-item">
                    @auth
                        <form id="logoutForm" action="{{route('logout')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a id="logoutLink" class="nav-link" href="#"
                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="bi bi-person-fill me-2"></i>
                            {{ __('menu.logout') }}
                        </a>
                    @else
                        <a id="loginLink" class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus-fill me-2"></i>
                            {{ __('menu.register') }}</a>
                    @endauth
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ayuda') }}"><i class="bi bi-question-circle-fill me-2"></i>
                        {{ __('menu.help') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sobreNosotros') }}"><i class="bi bi-info-circle-fill me-2"></i>
                        {{ __('menu.about') }}</a>
                </li>

                <li class="nav-item" id="languageButton">
                    <div class="divisor"></div>
                    <p>{{__('menu.cambiarIdioma')}}:<a  class="w-25 btn btn-link nav-link"
                        href="{{route('change.locale',str_replace('_', '-', app()->getLocale()))}}"> <img
                            src="{{ asset('images/logos/bandera_inglesa.webp') }}" alt="English_Flag"
                            style="width: 24px;"></a>
                    </p>
                    
                </li>
            </ul>
        </div>
    </div>

    @yield('content')

    <div class="pg-footer">
        <footer class="footer" style="background-color: #474242 !important;">
            <svg class="footer-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 100"
                preserveAspectRatio="none">
                <path class="footer-wave-path" style="fill: #F8FAFC"
                    d="M851.8,100c125,0,288.3-45,348.2-64V0H0v44c3.7-1,7.3-1.9,11-2.9C80.7,22,151.7,10.8,223.5,6.3C276.7,2.9,330,4,383,9.8 c52.2,5.7,103.3,16.2,153.4,32.8C623.9,71.3,726.8,100,851.8,100z">
                </path>
            </svg>
            <div class="footer-content">
                <div class="footer-content-column">
                    <div class="footer-logo">
                        <a class="footer-logo-link" href="#">
                            <img class="menu-logo" src="{{ asset('images/logos/logoFenecCirculo.jpg') }}"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="footer-menu">
                        <h2 class="footer-menu-name"> Menu</h2>
                        <ul id="menu-get-started" class="footer-menu-list">
                            <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                <a href="{{route('home')}}">{{ __('menu.home') }}</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                <a href="{{route('tipoCabanas.index')}}">{{ __('menu.cabins') }}</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                <a href="{{route('salons.index')}}">{{ __('menu.rooms') }}</a>
                            </li>
                            @auth
                                <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                    <a href="{{route('reservas.index')}}">{{ __('menu.reservations') }}</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                    <form id="logoutForm" action="{{route('logout')}}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a id="logoutLink" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        {{ __('menu.logout') }}
                                    </a>
                                </li>
                            @else
                                <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                    <a href="{{route('login')}}">{{ __('menu.login') }}</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                    <a href="{{route('register')}}">{{ __('menu.register') }}</a>
                                </li>
                            @endauth
                            <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                <a href="{{route('ayuda')}}">{{ __('menu.help') }}</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-product">
                                <a href="{{route('sobreNosotros')}}">{{ __('menu.about') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-content-column">
                    <div class="footer-menu">
                        <h2 class="footer-menu-name"> {{ __('menu.cabins') }}</h2>
                        <ul id="menu-company" class="footer-menu-list">
                            @foreach ($cabanas as $cabana)
                                <li class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="{{route('tipoCabanas.show',$cabana->id) }}">{{ $cabana->nombre }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="footer-content-column">
                    <div class="footer-menu">
                        <h2 class="footer-menu-name">{{ __('menu.rooms') }}</h2>
                        <ul id="menu-quick-links" class="footer-menu-list">
                            @foreach ($salones as $salon)
                                <li class="menu-item menu-item-type-custom menu-item-object-custom">
                                    <a rel="noopener noreferrer"
                                        href="{{route('salons.index')}}#{{ $salon->nombre }}">{{ $salon->nombre }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="footer-content-column">
                    <div class="footer-call-to-action">
                        <h2 class="footer-call-to-action-title">{{ __('menu.contactanos') }}</h2>
                        <p class="footer-call-to-action-link-wrapper">{{ __('menu.telefono') }}: <a
                                class="footer-call-to-action-link" href="tel:{{ getEnv('PHONE_NUMBER') }}"
                                target="_self">{{ getEnv('PHONE_NUMBER') }}</a></p>
                        <p class="footer-call-to-action-link-wrapper">{{ __('menu.email') }}: <a
                                class="footer-call-to-action-link" href="mailto:{{ getEnv('MAIL_FROM_ADDRESS') }}"
                                target="_self">{{ getEnv('MAIL_FROM_ADDRESS') }}</a></p>
                        <p class="footer-call-to-action-link-wrapper">{{ __('menu.direccion') }}:
                            {{ getEnv('ADDRESS') }}</p>
                    </div>
                </div>
                <div class="footer-social-links">
                    <svg class="footer-social-amoeba-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 236 54">
                        <path style="fill: wheat;" class="footer-social-amoeba-path"
                            d="M223.06,43.32c-.77-7.2,1.87-28.47-20-32.53C187.78,8,180.41,18,178.32,20.7s-5.63,10.1-4.07,16.7-.13,15.23-4.06,15.91-8.75-2.9-6.89-7S167.41,36,167.15,33a18.93,18.93,0,0,0-2.64-8.53c-3.44-5.5-8-11.19-19.12-11.19a21.64,21.64,0,0,0-18.31,9.18c-2.08,2.7-5.66,9.6-4.07,16.69s.64,14.32-6.11,13.9S108.35,46.5,112,36.54s-1.89-21.24-4-23.94S96.34,0,85.23,0,57.46,8.84,56.49,24.56s6.92,20.79,7,24.59c.07,2.75-6.43,4.16-12.92,2.38s-4-10.75-3.46-12.38c1.85-6.6-2-14-4.08-16.69a21.62,21.62,0,0,0-18.3-9.18C13.62,13.28,9.06,19,5.62,24.47A18.81,18.81,0,0,0,3,33a21.85,21.85,0,0,0,1.58,9.08,16.58,16.58,0,0,1,1.06,5A6.75,6.75,0,0,1,0,54H236C235.47,54,223.83,50.52,223.06,43.32Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="footer-copyright" style="background-color: wheat !important; color:#474242 !important">
                <div class="footer-copyright-wrapper">
                    <p class="footer-copyright-text">
                        <a style="color:#474242" class="footer-copyright-link" href="#"
                            target="_self">{{ __('menu.copyright') }} </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Obtener el idioma actual desde el atributo lang del elemento html
            let currentLanguage = $('html').attr('lang');

            // Configurar la imagen del botón de idioma basado en el idioma actual
            let languageButton = $('#languageButton img');
            if (currentLanguage === 'en') {
                languageButton.attr('src', '{{ asset('images/logos/bandera_espanola.png') }}');
                languageButton.attr('alt', 'Spanish_Flag');
            } else {
                languageButton.attr('src', '{{ asset('images/logos/bandera_inglesa.webp') }}');
                languageButton.attr('alt', 'English_Flag');
            }

        });
    </script>
    @stack('js')
</body>

</html>
