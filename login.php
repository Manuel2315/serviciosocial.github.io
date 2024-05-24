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
$login_user = $_POST['login_username'];
$login_pass = $_POST['login_password'];

// Validar nombre de usuario y contraseña
if (!preg_match('/^IS\d{8}$/', $login_user) && $login_user !== 'Amezquita') {
    echo "<script>
            alert('El nombre de usuario debe comenzar con IS seguido de 8 números o ser el usuario Amezquita.');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

if (strlen($login_pass) !== 8 && $login_user !== 'Amezquita') {
    echo "<script>
            alert('La contraseña debe tener exactamente 8 caracteres.');
            window.location.href = 'index.html#login';
          </script>";
    exit();
}

// Verificar usuario en la base de datos
$sql = "SELECT * FROM users WHERE username='$login_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($login_pass, $row['password'])) {
        session_start();
        $_SESSION['username'] = $login_user;
        $_SESSION['user_type'] = $row['user_type'];
        if ($row['user_type'] == 'admin') {
            echo "<script>
                    alert('Inicio de sesión exitoso');
                    window.location.href = 'admin_dashboard.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Inicio de sesión exitoso');
                    window.location.href = 'alumno_dashboard.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Contraseña incorrecta');
                window.location.href = 'index.html#login';
              </script>";
    }
} else {
    echo "<script>
            alert('Usuario no encontrado. Por favor, regístrate.');
            window.location.href = 'index.html#register';
          </script>";
}

$conn->close();
?>

