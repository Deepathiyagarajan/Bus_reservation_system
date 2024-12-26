<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background: url('{{ asset('storage/images/Bus-Online-Booking-System.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Nunito', sans-serif;
            color: #ffffff;
        }

        .blur-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(8px);
            z-index: -1;
        }

        .navbar {
            background-color: rgba(0, 123, 255, 0.8);
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #f8f9fa !important;
            text-decoration: underline;
        }

        .dropdown-menu {
            border-radius: 0.5rem;
        }

        .dropdown-item:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .container {
            margin-top: 2rem;
        }

        main {
            padding-top: 4rem;
        }
    </style>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="blur-background"></div>

    <div id="app">

        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                     Welcome!!! To Bus Ticket Booking
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label=Toggle navigation>
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
