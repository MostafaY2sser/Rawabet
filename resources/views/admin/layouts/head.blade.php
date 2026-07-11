<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">


    {{-- Fontawesome  --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/provider/provider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer/customer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

      
  

    @stack('styles')
</head>
