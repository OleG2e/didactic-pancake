<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<section class="section">
    <div class="container is-fluid">
        @hasSection('title')
            <h1 class="title">
                @yield('title')
            </h1>
        @endif
        @yield('content')
    </div>
</section>
</body>
</html>