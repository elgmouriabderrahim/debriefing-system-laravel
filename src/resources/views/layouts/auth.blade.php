<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Geist', sans-serif; }
        .grid-bg {
            background-image: radial-gradient(circle at 1px 1px, #e5e7eb 1px, transparent 0);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="h-full grid-bg bg-white antialiased">
    @yield('content')
</body>
</html>