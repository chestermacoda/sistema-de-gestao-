<div>
    @include('admin.Template.header')
    @yield('content')
    @include('admin.Template.footer')

    <script src="{{ asset('assets/js/global.js') }}"></script>
</div>
