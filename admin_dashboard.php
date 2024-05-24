<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    echo "<script>
            alert('Acceso denegado');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

$dir = "uploads/";

function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ul>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            echo '<li>' . $ff;
            if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            echo '</li>';
        }
    }
    echo '</ul>';
}

// Código para gestionar usuarios
$conn = new mysqli("localhost", "root", "", "servicio_social");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_to_delete = $_POST['username'];
        $delete_sql = "DELETE FROM users WHERE username='$user_to_delete'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<script>alert('Usuario eliminado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al eliminar el usuario: " . $conn->error . "');</script>";
        }
    } elseif (isset($_POST['add_admin'])) {
        $new_admin_user = $_POST['new_admin_username'];
        $new_admin_pass = password_hash('12345678', PASSWORD_DEFAULT); // Contraseña por defecto para nuevos administradores
        $add_sql = "INSERT INTO users (username, password, user_type) VALUES ('$new_admin_user', '$new_admin_pass', 'admin')";
        if ($conn->query($add_sql) === TRUE) {
            echo "<script>alert('Administrador agregado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al agregar el administrador: " . $conn->error . "');</script>";
        }
    }
}

$users_sql = "SELECT username, user_type FROM users";
$users_result = $conn->query($users_sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Panel de Administrador - Instituto Tecnológico Superior de Irapuato</h1>
    </header>
    <main>
        <section id="documents">
            <h2>Documentos de los Alumnos</h2>
            <?php listFolderFiles($dir); ?>
        </section>
        <section id="manage_users">
            <h2>Gestionar Usuarios</h2>
            <form action="admin_dashboard.php" method="post">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required>
                <input type="submit" name="delete_user" value="Eliminar Usuario">
            </form>
            <h3>Agregar Administrador</h3>
            <form action="admin_dashboard.php" method="post">
                <label for="new_admin_username">Nombre de Usuario del Nuevo Administrador:</label>
                <input type="text" id="new_admin_username" name="new_admin_username" required>
                <input type="submit" name="add_admin" value="Agregar Administrador">
            </form>
            <h3>Lista de Usuarios</h3>
            <ul>
                <?php
                if ($users_result->num_rows > 0) {
                    while($row = $users_result->fetch_assoc()) {
                        echo "<li>" . $row['username'] . " - " . $row['user_type'] . "</li>";
                    }
                } else {
                    echo "<li>No hay usuarios registrados.</li>";
                }
                ?>
            </ul>
        </section>
    </main>
    <footer>
        <p>© 2024 Instituto Tecnológico Superior de Irapuato</p>
    </footer>
</body>
</html>
