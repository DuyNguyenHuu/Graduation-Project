@if($errors->any())
    @foreach ($errors->all() as $error)
        <div id="toastfail">
            {{ $error }}
        </div>

        <script>
            const toast = document.getElementById('toastfail');
            setTimeout(() => { toast.style.opacity = 1; }, 100);
            setTimeout(() => { toast.style.opacity = 0; }, 3000);
        </script>
    @endforeach
@endif