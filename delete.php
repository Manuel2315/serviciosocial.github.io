<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Debe iniciar sesión para eliminar documentos.');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

$file = $_GET['file'];

if (file_exists($file)) {
    $user_folder = "uploads/" . $_SESSION['username'] . "/";
    if ($_SESSION['user_type'] == 'admin' || strpos($file, $user_folder) === 0) {
        unlink($file);
        echo "<script>
                alert('Documento eliminado.');
                window.location.href = 'alumno_dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('No tiene permiso para eliminar este documento.');
                window.location.href = 'alumno_dashboard.php';
              </script>";
    }
} else {
    echo "<script>
            alert('El archivo no existe.');
            window.location.href = 'alumno_dashboard.php';
          </script>";
}
?>
