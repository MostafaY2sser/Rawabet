<!DOCTYPE html>
<html lang="en">

@include('site.layouts.head')

{{-- change style header in some pages --}}
<body class="@yield('body-class')">




    <!-- Header --------------------- -->
    @include("site.layouts.navbar")
    <!-- Header --------------------- -->



    <!-- Home Page -------------- -->
    @yield('content')


    @include('site.layouts.footer')
    

    <!-- Home Page -------------- -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    @stack('scripts')


    <script src="/assets/js/site/site.js"></script>

</body>
</html>