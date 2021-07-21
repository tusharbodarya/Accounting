<!DOCTYPE html>
<html>

<head>
    @include("components.head")
    @yield('css')
</head>

<body data-topbar="dark" data-layout="horizontal">
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
    @yield('script')
</body>
</html>
