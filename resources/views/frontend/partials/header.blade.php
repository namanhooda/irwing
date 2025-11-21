<div style="width: 100%; height: 8px; background: linear-gradient(to right, #FF9933 0%, #FF9933 33%, #FFFFFF 33%, #FFFFFF 66%, #138808 66%, #138808 100%); box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: block;"></div>

<header class="header government-header">
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'hi,en',
                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
            }, 'google_translate_element');
        }
    </script>

    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
        /* Government Header Styles - Exact Match to Reference */
        .government-header {
            font-family: 'Arial', 'Helvetica', sans-serif;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Top Utility Bar */
        .header-top {
            background: #f8f9fa;
            padding: 6px 0;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }

        .header-top .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-top .utility-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-top .utility-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-top a,
        .header-top button {
            color: #333;
            text-decoration: none;
            padding: 3px 8px;
            border-radius: 3px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 12px;
        }

        .header-top a:hover,
        .header-top button:hover {
            background: #007bff;
            color: white;
        }

        /* Main Government Header */
        .header-main {
            background: white;
            padding: 12px 0;
            border-bottom: 2px solid #ff8c00;
        }

        .header-main .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .govt-left {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .govt-emblem {
            width: 65px;
            height: 65px;
            margin-right: 15px;
        }

        .govt-title {
            flex: 1;
        }

        .govt-title h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            color: #333;
            line-height: 1.2;
        }

        .govt-title h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 2px 0;
            color: #333;
            line-height: 1.2;
        }

        .govt-title h3 {
            font-size: 12px;
            font-weight: normal;
            margin: 2px 0 0 0;
            color: #666;
            line-height: 1.2;
        }

        .header-logos {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logos img {
            height: 55px;
            max-width: 100px;
            object-fit: contain;
        }

        /* Navigation Bar - Orange Theme Matching Reference */
        .header-nav {
            background: rgb(37 99 235 / var(--tw-bg-opacity, 1));
            position: relative;
        }

        .nav-menu {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: white !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-item:first-child .nav-link {
            border-left: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-link i {
            margin-right: 4px;
            font-size: 12px;
        }

        .nav-link:hover,
        .nav-item.active .nav-link {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .nav-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: #4a90e2;
            min-width: 250px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .nav-item:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown a {
            display: block;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .nav-dropdown a:last-child {
            border-bottom: none;
        }

        .nav-dropdown a:hover {
            background: #4a90e2;
            color: white;
            padding-left: 24px;
        }

        /* Sub-menu styles */
        .nav-sub-item {
            position: relative;
        }

        .nav-sub-link {
            display: block;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .nav-sub-link:hover {
            background: #4a90e2;
            color: white;
            padding-left: 24px;
        }

        .nav-sub-dropdown {
            position: absolute;
            top: 0;
            left: 100%;
            background: #4a90e2;
            min-width: 250px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        /* ===== FIX APPLIED HERE ===== */
        .nav-sub-item:hover>.nav-sub-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        /* ============================ */

        .nav-sub-dropdown a {
            display: block;
            padding: 10px 16px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .nav-sub-dropdown a:last-child {
            border-bottom: none;
        }

        .nav-sub-dropdown a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding-left: 24px;
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            padding: 8px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .nav-link {
                padding: 12px 12px;
                font-size: 12px;
            }
        }

        @media (max-width: 991px) {
            .govt-title h1 {
                font-size: 12px;
            }

            .govt-title h2 {
                font-size: 16px;
            }

            .govt-title h3 {
                font-size: 11px;
            }

            .header-logos img {
                height: 45px;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #4a90e2;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-link {
                padding: 12px 20px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                justify-content: flex-start;
            }

            .nav-item:first-child .nav-link {
                border-left: none;
            }

            .nav-dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.1);
                margin: 0;
            }

            .nav-dropdown a {
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding-left: 40px;
            }

            .nav-dropdown a:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
                padding-left: 48px;
            }

            /* Mobile sub-menu styles */
            .nav-sub-item {
                position: static;
            }

            .nav-sub-link {
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding-left: 40px;
            }

            .nav-sub-link:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
                padding-left: 48px;
            }

            .nav-sub-dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                background: rgba(255, 255, 255, 0.1);
                margin: 0;
            }

            .nav-sub-dropdown a {
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding-left: 60px;
            }

            .nav-sub-dropdown a:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
                padding-left: 68px;
            }
        }

        @media (max-width: 576px) {
            .header-main {
                padding: 10px 0;
            }

            .govt-emblem {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            .govt-title h1 {
                font-size: 10px;
            }

            .govt-title h2 {
                font-size: 14px;
            }

            .govt-title h3 {
                font-size: 9px;
            }

            .header-logos {
                gap: 8px;
            }

            .header-logos img {
                height: 35px;
            }

            .header-top .utility-left,
            .header-top .utility-right {
                gap: 8px;
            }

            .header-top a,
            .header-top button {
                padding: 2px 4px;
                font-size: 10px;
            }
        }
    </style>
    @php

    $settings = App\Models\SiteSetting::first();
    @endphp

    <div class="header-top">
        <div class="container">
            <div class="utility-left">
                <a href="#"><i class="bi bi-search"></i></a>
                @if($settings && $settings->contact_phone)
                <a href="tel:{{ $settings->contact_phone }}"><i class="bi bi-telephone"></i></a>
                @endif

                <!-- Email link -->
                @if($settings && $settings->contact_email)
                <a href="mailto:{{ $settings->contact_email }}"><i class="bi bi-envelope"></i></a>
                @endif
            </div>
            <div class="utility-right"><!-- Language dropdown example -->
                <li class="nav-item dropdown">
                    <a class=" dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="    /* color: #007bff !important;">
                        {{ __('messages.language') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="langDropdown">
                        <li>
                            <div id="google_translate_element"></div>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item @if(app()->getLocale() == 'en') active @endif"
                                href="{{ route('change.language', ['locale' => 'en']) }}">
                                English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item @if(app()->getLocale() == 'hi') active @endif"
                                href="{{ route('change.language', ['locale' => 'hi']) }}">
                                हिन्दी
                            </a>
                        </li> -->
                    </ul>
                </li>

                @guest
                <a href="{{ route('login') }}">Login</a>
                @else
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
                @endguest
            </div>
        </div>
    </div>

    <div class="header-main">
        <div class="container">
            <div class="govt-left">
                <a href="{{url('/')}}">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/Emblem_of_India.svg"
                        alt="Government of India Emblem" class="govt-emblem">
                </a>
                <div class="govt-title">
                    <h1>भारत सरकार GOVERNMENT OF INDIA</h1>
                    <h2>IR Wing Portal</h2>
                    <h3>Department of Telecommunications, Ministry of Communications</h3>
                </div>
            </div>
            <div class="header-logos d-none d-md-flex">
                <img src="{{asset('images/azadi.png')}}"
                    alt="Azadi Ka Amrit Mahotsav">
                <img src="{{asset('images/swach.png')}}"
                    alt="Swachh Bharat Mission">
                <img src="{{asset('images/WhatsApp Image 2025-09-13 at 17.48.33.jpeg')}}"
                    alt="Department Logo">
            </div>
        </div>
    </div>

    <div class="header-nav">
        <div class="container">
            <nav class="main-nav">
                <button class="mobile-menu-toggle d-lg-none" onclick="toggleMobileMenu()">
                    <i class="bi bi-list"></i>
                </button>
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="bi bi-house-door-fill"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            About Us <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="nav-dropdown">
                            {{-- <a href="{{ url('message') }}">Message from Hon'ble MoC</a> --}}
                            <a href="{{ url('role-ir') }}">Role of IR Wing</a>
                            {{-- <a href="{{url('structure')}}">Organization Structure</a> --}}
                            <a href="{{url('contact-us')}}">Contact Us</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Information <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="nav-dropdown">



                            <a href="{{url('orms')}}">IR Wing OMs</a>
                            <a href="{{url('vacancies')}}">Vacancies</a>

                            @php
                            $Information = App\Models\Information::orderBy('position', 'asc')->get();
                            @endphp
                            @foreach($Information as $info)
                            <a href="{{ url('circular/'.$info->id) }}">{{$info->title}}</a>
                            @endforeach


                            {{-- <a href="{{url('achivements')}}">Achievements</a> --}}
                            <!-- <div class="nav-sub-item">
                                <a href="#" class="nav-sub-link">International Forums <i class="bi bi-chevron-right"></i></a>
                                <div class="nav-sub-dropdown">
                                                                        <div class="nav-sub-item">
                                        <a href="#" class="nav-sub-link">ITU-T <i class="bi bi-chevron-right"></i></a>
                                        <div class="nav-sub-dropdown">
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg21') }}">NWG 21</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg2') }}">NWG 2</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg3') }}">NWG 3</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg5') }}">NWG 5</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg9') }}">NWG 9</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg11') }}">NWG 11</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg12') }}">NWG 12</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg13') }}">NWG 13</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg15') }}">NWG 15</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg16') }}">NWG 16</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg17') }}">NWG 17</a>
                                            <a href="{{ url('internation-forums?section=itu-t&sub=nwg20') }}">NWG 20</a>
                                        </div>
                                    </div>
                                    <div class="nav-sub-item">
                                        <a href="#" class="nav-sub-link">ITU-R <i class="bi bi-chevron-right"></i></a>
                                        <div class="nav-sub-dropdown">
                                            <a href="{{ url('internation-forums?section=itu-r&sub=npc-wrc') }}">NPC WRC</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg1') }}">NSG 1</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg2') }}">NSG 2</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg3') }}">NSG 3</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg4') }}">NSG 4</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg5') }}">NSG 5</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg6') }}">NSG 6</a>
                                            <a href="{{ url('internation-forums?section=itu-r&sub=nsg7') }}">NSG 7</a>
                                        </div>
                                    </div>

                                    <div class="nav-sub-item">
                                        <a href="#" class="nav-sub-link">ITU-D <i class="bi bi-chevron-right"></i></a>
                                        <div class="nav-sub-dropdown">
                                            <a href="{{ url('internation-forums?section=itu-d&sub=sg1') }}">Study Group 1</a>
                                            <a href="{{ url('internation-forums?section=itu-d&sub=sg2') }}">Study Group 2</a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Media <i class="bi bi-chevron-down"></i>
                        </a>
                        <div class="nav-dropdown">
                            <a href="{{url('pressrelease')}}">Press Releases</a>
                            <a href="{{url('social-media')}}">Social Media</a>
                            <!-- <a href="{{url('promotional-videos')}}">Promotional Videos</a> -->
                            <a href="{{url('brouches')}}">Brochures</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            International Forums <i class="bi bi-chevron-down"></i>
                        </a>
                        @php

                        $internationalForm = App\Models\InternationalForm::get();
                        @endphp
                        <div class="nav-dropdown">
                            @foreach($internationalForm as $form)
                            <a href="{{ url('internation-forums/'.$form->id) }}">{{$form->title}}</a>
                            @endforeach
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            Telecom Policies <i class="bi bi-chevron-down"></i>
                        </a>
                        @php

                        $internationalForm = App\Models\InternationalForm::get();
                        @endphp
                        <div class="nav-dropdown">
                            @foreach($internationalForm as $form)
                            <a href="#">{{$form->title}}</a>
                    @endforeach
                    <a href="#">Broadband Policy</a>
                    <a href="#">Spectrum Policy</a>
                    <a href="#">Digital India</a>
        </div>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                Telecom & Spectrum Licensing <i class="bi bi-chevron-down"></i>
            </a>
            <div class="nav-dropdown">
                <a href="#">Licensing Framework</a>
                <a href="#">Spectrum Allocation</a>
                <a href="#">License Applications</a>
                <a href="#">Compliance</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                Investment Promotion <i class="bi bi-chevron-down"></i>
            </a>
            <div class="nav-dropdown">
                <a href="#">FDI Policy</a>
                <a href="#">Investment Opportunities</a>
                <a href="#">Ease of Doing Business</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                Telecom Reforms <i class="bi bi-chevron-down"></i>
            </a>
            <div class="nav-dropdown">
                <a href="#">Reform Initiatives</a>
                <a href="#">Policy Updates</a>
                <a href="#">Consultation Papers</a>
            </div>
        </li> --}}
        </ul>
        </nav>
    </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const toggleButton = document.querySelector('.mobile-menu-toggle');

            if (!navMenu.contains(event.target) && !toggleButton.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });
    </script>
</header>