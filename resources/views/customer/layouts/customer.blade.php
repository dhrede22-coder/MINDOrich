<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer') | MINDOrich</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>
<body>

<div class="customer-wrapper">

    @include('customer.partials.navbar')

    <main class="main-content">
    @yield('content')
   </main>

    @includeWhen(View::exists('customer.partials.footer'), 'customer.partials.footer')

</div>

@stack('scripts')

</body>
</html>
