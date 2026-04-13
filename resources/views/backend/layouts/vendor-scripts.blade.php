<!-- JS Utama dari Vite -->
@vite(['resources/js/app.js'])

<!-- Fallback app2.js (karena Vite selalu menghasilkan app2.js) -->
<script src="{{ URL::asset('build/js/app2.js') }}"></script>
<!-- Global Bootstrap 5 Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi semua dropdown
        const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdowns.forEach(function(dropdown) {
            new bootstrap.Dropdown(dropdown, {
                popperConfig: {
                    strategy: 'fixed'   // biar dropdown tidak kepotong
                }
            });
        });
    });
</script>

@stack('script')