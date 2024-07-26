@if(Session::has('success') || Session::has('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            timer: 1500,
            timerProgressBar: true,
            icon: '{{session("success") ? 'success' : 'error'}}',
            title: '{{session("success") ?? session("error")}}',
            showConfirmButton: false,
        })
    </script>
@endif
