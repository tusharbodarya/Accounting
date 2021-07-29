<!DOCTYPE html>
<html>

<head>
    @include("components.head")
    @yield('css')
</head>

<body data-topbar="dark" data-layout="horizontal">
    <!--start loader-->
    <div class="loader">
        <div class="cssload-loader">
            <div class="cssload-inner cssload-one"></div>
            <div class="cssload-inner cssload-two"></div>
            <div class="cssload-inner cssload-three"></div>
        </div>
    </div>
    <!--loader end-->
    @include("components.header")
    @include("components.navbar")
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('title')
                @yield('content')

            </div>
        </div>
    </div>
    @include("components.footer")
    <script>
        $(window).on("load", function() {

            "use strict";

            /* ===================================
                    Loading Timeout
             ====================================== */

            $('.side-menu.hidden').removeClass('hidden');

            setTimeout(function() {
                $(".loader").fadeOut("slow");
            }, 1000);


        });
    </script>
    @yield('script')
</body>

</html>
