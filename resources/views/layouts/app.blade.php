

    @include('partials.header')

    {{-- CONTENT --}}
    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- JS dyalna --}}
    <script src="{{ asset('js/main.js') }}"></script>

