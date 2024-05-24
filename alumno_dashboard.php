<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'alumno') {
    echo "<script>
            alert('Acceso denegado');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

$dir = "uploads/" . $_SESSION['username'] . "/";

// Crear el directorio si no existe
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

function listFolderFiles($dir){
    if (!is_dir($dir)) {
        echo "<p>El directorio no existe.</p>";
        return;
    }
    $ffs = scandir($dir);
    if ($ffs === false) {
        echo "<p>Error al abrir el directorio.</p>";
        return;
    }
    echo '<ul>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li>' . $ff . ' <a href="delete.php?file=' . urlencode($dir . $ff) . '">Eliminar</a></li>';
        }
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Alumno</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Panel del Alumno - Instituto Tecnológico Superior de Irapuato</h1>
    </header>
    <main>
        <section id="documents">
            <h2>Mis Documentos</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="archivo" accept=".pdf, .doc, .docx" required>
                <input type="submit" value="Subir Documento">
            </form>
            <?php listFolderFiles($dir); ?>
        </section>
    </main>
    <footer>
        <p>© 2024 Instituto Tecnológico Superior de Irapuato</p>
    </footer>
</body>
</html>
