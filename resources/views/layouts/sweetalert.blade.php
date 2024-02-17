<script>
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });
</script>

@if (Session::has('success'))
  <script>
    Toast.fire({
      icon: "success",
      title: "{{ session('success') }}",
    });
  </script>
@endif

@if ($errors->any() || count($errors->getBags()) > 0)
  <script>
    Toast.fire({
      icon: "error",
      title: "Oops! something went wrong",
      html: ``
    });
  </script>
@endif
