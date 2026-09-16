<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | MINDOrich Admin</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">

</head>

<body>

<div class="admin-wrapper">

    @include('admin.partials.sidebar')

    <div class="main-wrapper">

        @include('admin.partials.navbar')

        <main class="main-content">

            @yield('content')

        </main>

    </div>

</div>

@include('admin.partials.footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Bootstrap JavaScript --}}

@stack('scripts')

</body>

</html>