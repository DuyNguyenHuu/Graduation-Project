@if(session('success'))
    <div id="toastfail">
        {{ session('success') }}
    </div>

    <script>
        const toast = document.getElementById('toastfail');
        setTimeout(() => { toast.style.opacity = 1; }, 100);
        setTimeout(() => { toast.style.opacity = 0; }, 3000);
    </script>
@endif