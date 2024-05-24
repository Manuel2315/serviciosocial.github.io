<?php
$servername = "localhost";
$username = "id22171046_root";
$password = "0|mJw!CtRrQ{IPMS";
$dbname = "id22171046_servicio_social";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];
$user_type = 'alumno'; // Todos los registros desde la página principal serán alumnos

// Validar nombre de usuario y contraseña
if (!preg_match('/^IS\d{8}$/', $user)) {
    echo "<script>
            alert('El nombre de usuario debe comenzar con IS seguido de 8 números.');
            window.location.href = 'index.html#register';
          </script>";
    exit();
}

if (strlen($pass) !== 8) {
    echo "<script>
            alert('La contraseña debe tener exactamente 8 caracteres.');
            window.location.href = 'index.html#register';
          </script>";
    exit();
}

// Insertar usuario en la base de datos
$pass_hashed = password_hash($pass, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password, user_type) VALUES ('$user', '$pass_hashed', '$user_type')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Registro exitoso');
            window.location.href = 'index.html#login';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
