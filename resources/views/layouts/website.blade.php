<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.ico">

    <!-- Dynamic Title -->
    <title>{{ $page ?? 'Best Free Community Carpool Service for Convenient, Eco-Friendly Rides' }} - {{ env('APP_NAME') }}</title>

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ env('APP_NAME') }}">
    <meta name="google-adsense-account" content="ca-pub-7167306244112785">

    <!-- Additional Meta -->
    @yield('meta')

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('FIREBASE_MEASUREMENT_ID')}}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', "{{env('FIREBASE_MEASUREMENT_ID')}}");
    </script>

    @auth
    <!-- firebase -->
    <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>
    
    @endauth

    <!-- Fonts and Stylesheets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600,800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            /* line-height: 1.6;
            background-color: #f8f9fa;
            color: #495057; */
        }
        .navbar {
            background-color: #f3f4f6;
            border-bottom: 1px solid #e0e0e0;
        }
        .navbar-brand, .nav-link {
            color: #495057 !important;
            font-weight: 600;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #2e3a48 !important;
        }
        .cta-button {
            background-color: #ef4444;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #dc0031;
        }
        .footer {
            background-color: #fff;
            border-top: 1px solid #e0e0e0;
            padding: 40px 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .footer a {
            color: #495057;
            text-decoration: none;
        }
        .footer a:hover {
            color: #212529;
        }
        .alert-feedback {
            background-color: #f7e87b;
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <i class="bi bi-house-door"></i> {{ env('APP_NAME') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ride.search' ? 'active' : '' }}" href="{{ route('ride.search') }}">
                            <i class="bi bi-search"></i> Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'about.us' ? 'active' : '' }}" href="{{ route('about.us') }}">
                            <i class="bi bi-info-circle"></i> About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'contact.us' ? 'active' : '' }}" href="{{ route('contact.us') }}">
                            <i class="bi bi-envelope"></i> Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'faqs' ? 'active' : '' }}" href="{{ route('faqs') }}">
                            <i class="bi bi-question-circle"></i> FAQs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ride.create' ? 'active' : '' }}" href="{{ route('ride.create') }}">
                            <i class="bi bi-plus-circle"></i> Create Ride
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'login' ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Log in
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i> Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">

    @if (session('message'))
        <div class="alert alert-{{ session('alert-type', 'info') }} my-3">
            {{ session('message') }}
        </div>
    @endif


        <!-- Page Content -->
        <main class="mt-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer text-center mt-5">
        <div class="container">
            <p><a href="{{ url('sitemap.xml') }}">Site Map</a></p>
            <p>&copy; 2024 {{ env('APP_NAME') }}. All rights reserved.</p>
            <div class="alert alert-feedback mt-3" role="alert">
                <strong>We value your input!</strong> Please help us improve by providing feedback or reporting suggestions and bugs.
                <div class="mt-2">
                    <a href="https://forms.gle/deyFejp47D19e18B9" class="alert-link">Give Feedback</a> | 
                    <a href="https://forms.gle/1Y2n8kRbo57Twdzk9" class="alert-link">Report Suggestions & Bugs</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
    @auth
    <script>
        // Your Firebase configuration
        var firebaseConfig = {
            apiKey: "{{env('FIREBASE_API_KEY')}}",
            authDomain: "{{env('FIREBASE_AUTH_DOMAIN')}}",
            projectId: "{{env('FIREBASE_PROJECT_ID')}}",
            storageBucket: "{{env('FIREBASE_STORAGE_BUCKET')}}",
            messagingSenderId: "{{env('FIREBASE_MESSAGING_SENDER_ID')}}",
            appId: "{{env('FIREBASE_APP_ID')}}",
            measurementId: "{{env('FIREBASE_MEASUREMENT_ID')}}"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        // Request permission to send notifications
        messaging.requestPermission().then(function() {
            console.log('Notification permission granted.');
            return messaging.getToken();
        }).then(function(token) {
            // Send the device token to your Laravel backend to store it in the user's table
            fetch("{{route('notification.store.device')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({token: token})
            });
        }).catch(function(err) {
            console.log('Unable to get permission to notify.', err);
        });

        // Handle incoming infocus messages
        messaging.onMessage(function(payload) {
            console.log('Message received. ', payload);
            // Customize notification handling here
            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon
            };

            if (Notification.permission === "granted") {
                var notification = new Notification(notificationTitle, notificationOptions);
                notification.onclick = function(event) {
                    event.preventDefault(); // Prevent the browser from focusing the Notification's tab
                    window.open(payload.notification.click_action, '_blank');
                };
            }
        });
    </script>
    @endauth
</body>
</html>
