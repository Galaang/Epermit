<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-Permit</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @include('partials.css')

</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">

        {{-- sidebar --}}
        @include('partials.sidebar')
        {{-- sidebar --}}

        {{-- content --}}
        <div class="content">

            {{-- narbar --}}
            @include('partials.navbar')
            {{-- narbar --}}

            @yield('container')

        </div>
        
        {{-- <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a> --}}

    </div>

@include('partials.js')
</body>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</html>
