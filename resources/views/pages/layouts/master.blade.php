<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.4.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">
    <head>
        {{-- meta --}}
        @include('pages.layouts._meta')
        @stack('meta')

        <title>@yield('title')</title>

        {{-- css --}}
        @include('pages.layouts._css')
        @stack('css')
    </head>
    <body class="c-app">

        {{-- sidebar --}}
        @include('pages.layouts._sidebar')

        <div class="c-wrapper c-fixed-components">

            {{-- header --}}
            @include('pages.layouts._header')

            <div class="c-body">
                <main class="c-main">
                    <div class="container-fluid">
                        <div class="fade-in">
                            <h2>@yield('title')</h2>
                            @yield('content')
                        </div>
                    </div>
                </main>

                {{-- footer --}}
                @include('pages.layouts._footer')

            </div>
            <div id="modals">@yield('modal')</div>
        </div>

        {{-- js --}}
        @include('pages.layouts._js')
        @stack('js')
    </body>
</html>
