<!--coment-->
<header>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
echo '<script>
    Swal.fire({
        title: "Solicitud enviada correctamente!",
        text:"Se comunicaran con usted lo mas pronto posible",
        icon: "success",
        confirmButtonText: "OK",
      })
  
      .then((value) => {
        switch (value) {
          default:
            setTimeout(function() {
              window.location.href = "./";
            }, 100);
            break;
        }
      });
  </script>';;


?>