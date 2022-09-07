<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
   
    <!-- License -->
    @php
        $license_code = \App\Models\Setting::first()->license_code;
        $client_name = \App\Models\Setting::first()->license_client_name;

        $api = new LicenseBoxAPI();
        $verify = $api->verify_license();
        $set = \App\Models\Setting::first();

        if($verify['status'] == true) {
            if(!$set->license_status)
                $set->license_status = 1;
        }
        else {
            if($set->license_status)
                $set->license_status = 0;
        }
        $set->save();
        $license_status = \App\Models\Setting::first()->license_status;
    @endphp
    @php
        if(session('direction') == "rtl") {
            $dir = 'rtl';
        } else {
            $dir = 'ltr';
        }
    @endphp

    <!-- Dynamic color -->
    <?php $color = \App\Models\Setting::first()->color; ?>
    <?php
        $rgb = $color;
        $darker = 1.2;
        $hash = (strpos($rgb, '#') !== false) ? '#' : '';
        $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
        if(strlen($rgb) != 6) return $hash.'000000';
        $darker = ($darker > 1) ? $darker : 1;

        list($R16,$G16,$B16) = str_split($rgb,2);

        $R = sprintf("%02X", floor(hexdec($R16)/$darker));
        $G = sprintf("%02X", floor(hexdec($G16)/$darker));
        $B = sprintf("%02X", floor(hexdec($B16)/$darker));
        $hover_color =  $hash.$R.$G.$B;
    ?>

    <style>
        :root{
            --primary_color : <?php echo $color ?>;
            --primary_color_hover : <?php echo $hover_color ?>;
            --primary_color_light : <?php echo $color.'cc' ?>;
        }
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="primary_color" content="{{ $color }}">
    <meta name="direction" content="{{ $dir }}">
    
    <!-- Title -->
    <?php $app_name = \App\Models\Setting::first()->app_name; ?>
    <title>{{ $app_name }}</title>

    <!-- Favicon -->
    <?php $favicon = \App\Models\Setting::first()->favicon; ?>
    <link href="{{asset('image/app/'.$favicon)}}" rel="icon" type="image/png">
    

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/sweetalert2.scss') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/simpleLightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/stisla.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}" >

    <!-- My CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/mystyle.css') }}" >

    <script src="{{ asset('admin/js/jquery-3.3.1.min.js') }}"></script>
    @if (session('direction') == "rtl")
        <link rel="stylesheet" href="{{ asset('admin/css/rtl.css') }}" >
    @endif
    
</head>

<body>
    <div class="preload">
        <img src="{{asset('image/app/loader.gif')}}" class="loader" alt="">
    </div>
    
    <div class="for-loader">
        <div id="app">
            <div class="main-wrapper">
                <?php $bg_img = \App\Models\Setting::first()->bg_img; ?>
                <div class="navbar-bg admin-header-image" style="background-image: url({{asset('image/app/'.$bg_img)}});"></div>
            
                @include('layouts.navbar')
                @include('layouts.sidebar')

                <!-- Main Content -->
                <div class="main-content">
                    @if ($license_status == 1)
                        @yield('content')
                        @yield('content_setting')
                    @else
                        <script>
                            var base_url = $('meta[name=base_url]').attr("content");
                            var curr_url = window.location.href;
                            var set_url = base_url+'/admin/settings';
                            if (curr_url != set_url)
                            {
                                setTimeout(() => {
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Your License has been deactivated...!!',
                                    onClose: () => {
                                        window.location.replace(set_url);
                                        }
                                    })
                                }, 1000);
                            }
                        </script>
                        @yield('content_setting')
                    @endif
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('admin/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('admin/js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/summernote.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('admin/js/flatpickr.js') }}"></script>
    <script src="{{ asset('admin/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('admin/js/sweetalert.all.js') }}"></script>
    <script src="{{ asset('admin/js/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('admin/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/js/myjavascript.js') }}"></script>

    <!-- Page Specific JS File -->

</body>
</html>

