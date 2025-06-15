<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipParents = document.querySelectorAll('.tooltip-parent');

        tooltipParents.forEach(parent => {
            const tooltip = parent.querySelector('.tooltip-content');
            let tooltipVisible = false;

            parent.addEventListener('click', function (e) {
                if (window.innerWidth <= 768) {
                    if (!tooltipVisible) {
                        e.preventDefault(); // Hindari aksi langsung (link, tombol)
                        tooltip.classList.remove('invisible', 'opacity-0');
                        tooltip.classList.add('visible', 'opacity-100');
                        tooltipVisible = true;

                        // Tutup tooltip otomatis setelah 2 detik
                        setTimeout(() => {
                            tooltip.classList.add('invisible', 'opacity-0');
                            tooltip.classList.remove('visible', 'opacity-100');
                            tooltipVisible = false;
                        }, 2000);
                    } else {
                        // Tap kedua, biarkan aksi lanjut (default)
                        tooltipVisible = false;
                    }
                }
            });
        });
    });
</script>

    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @stack('scripts')
</body>

</html>