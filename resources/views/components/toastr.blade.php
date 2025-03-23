<script>
    @if (session('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
        };

        toastr.success("{{ session('success') }}", "Thành công 🎉");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
