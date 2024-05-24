<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Debe iniciar sesión para subir documentos.');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

$target_dir = "uploads/" . $_SESSION['username'] . "/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES["archivo"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si el archivo es un tipo permitido
if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
    echo "<script>
            alert('Solo se permiten archivos PDF, DOC y DOCX.');
            window.location.href = 'alumno_dashboard.php';
          </script>";
    $uploadOk = 0;
}

// Verificar si $uploadOk está en 0 por algún error
if ($uploadOk == 0) {
    echo "Tu archivo no fue subido.";
// Si todo está bien, intentar subir el archivo
} else {
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
        echo "<script>
                alert('El archivo ". htmlspecialchars(basename($_FILES["archivo"]["name"])). " ha sido subido.');
                window.location.href = 'alumno_dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Hubo un error al subir tu archivo.');
                window.location.href = 'alumno_dashboard.php';
              </script>";
    }
}
?>
