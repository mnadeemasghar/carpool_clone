<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="google-adsense-account" content="ca-pub-7167306244112785">

        <title>
            {{ config('app.name', 'Laravel') }} | 
            {{ strtoupper(str_replace('.', ' | ', \Illuminate\Support\Facades\Route::currentRouteName())) }}
        </title>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{env('FIREBASE_MEASUREMENT_ID')}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', "{{env('FIREBASE_MEASUREMENT_ID')}}");
        </script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <!-- firebase -->
        <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <x-banner />

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

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
    </body>
</html>
