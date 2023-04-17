<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <title>Solutech App</title>
    <link rel="icon" type="image/x-icon" href="logo.png">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="bg-gradient-to-tl from-[#b985ca] to-[#e6d4a5]">
    <div id="app"></div>
</body>

</html>