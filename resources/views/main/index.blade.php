<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Codescandy" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ArtisanFaso</title>
    <link rel="stylesheet" href="{{ asset('admin/dasher-1.0.0/src/node_modules/swiper/swiper-bundle.min.css') }}" />
  <!-- Favicon icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-60x60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/apple-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/android-icon-192x192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/favicon-96x96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/favicon-16x16.png') }}" />

    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="{{ asset('admin/dasher-1.0.0/src/assets/images/favicon/ms-icon-144x144.png') }}" />
    <meta name="theme-color" content="#ffffff" />
    <!-- Color modes -->
    <script src="{{ asset('admin/dasher-1.0.0/src/assets/js/vendors/color-modes.js') }}"></script>
    <script>
    if (localStorage.getItem('sidebarExpanded') === 'false') {
        document.documentElement.classList.add('collapsed');
        document.documentElement.classList.remove('expanded');
    } else {
        document.documentElement.classList.remove('collapsed');
        document.documentElement.classList.add('expanded');
    }
    </script>
    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="{{ asset('admin/dasher-1.0.0/src/node_modules/simplebar/dist/simplebar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/dasher-1.0.0/src/node_modules/@tabler/icons-webfont/tabler-icons.min.css') }}" />

    <!-- Theme CSS -->
    <!-- build:css {{ asset('admin/dasher-1.0.0/src/assets/css/theme.min.css') }} -->
    <link rel="stylesheet" href="{{ asset('admin/dasher-1.0.0/src/assets/css/theme.css') }}" />
    <!-- endbuild -->

</head>

<body>
  
{{-- @include('main.sidebar') --}}

@yield('content')

{{-- @include('main.navbar') --}}

<!-- Libs JS -->
<script src="{{ asset('admin/dasher-1.0.0/src/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/dasher-1.0.0/src/node_modules/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Theme JS -->
<!-- build:js {{ asset('admin/dasher-1.0.0/src/assets/js/theme.min.js') }} -->
<script src="{{ asset('admin/dasher-1.0.0/src/assets/js/main.js') }}"></script>
<!-- endbuild -->

  <footer>
    <p class="text-center">©2026 UTM HACHATHON <a href="https://codescandy.com" target="_blank">ArtisanFaso</a>. Distributed by JuniorTeam.</p>
  </footer>
  <!-- jsvectormap -->
  <script src="{{ asset('admin/dasher-1.0.0/src/assets/js/vendors/sidebarnav.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/jsvectormap/dist/js/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/jsvectormap/dist/maps/world.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/jsvectormap/dist/maps/world-merc.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/assets/js/vendors/chart.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/choices.js/public/assets/scripts/choices.min.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/assets/js/vendors/choice.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/node_modules/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('admin/dasher-1.0.0/src/assets/js/vendors/swiper.js') }}"></script>
</body>

</html>
