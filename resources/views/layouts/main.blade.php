<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials._head')
    </head>
    <body>
        <div class="wrapper">
            <nav id="sidebar">
                @include('partials._sidebar')
            </nav>
            <div id="content">
                <div class="container-fluid px-0">
                    @include('partials._nav')
                    <div class="row mt-3">
                        <div class="col-md-8 offset-md-2">
                            @include('partials._messages')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partials._footer')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </body>
</html>
