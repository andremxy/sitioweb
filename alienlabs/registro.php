<?php
include 'header.php';
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    // Verificar si el email ya está registrado
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $email_error = "El correo electrónico ya está registrado.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Registro</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #c2ffc1; /* Verde */
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #e0d2f1; /* Morado claro */
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    label {
      font-weight: bold;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    input[type="submit"] {
      background-color: #4CAF50; /* Verde oscuro */
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    input[type="submit"]:hover {
      background-color: #45a049; /* Verde más claro */
    }

    .error {
      color: red;
      font-size: 0.9em;
      margin-top: 5px;
    }

    /* Estilos para el logo */
    #logo {
      text-align: center;
      margin-bottom: 20px;
    }

    #logo img {
      width: 350px;
    }
  </style>
</head>
<body>

  <!-- Logo -->
  <div id="logo">
    <a href="home.php">
      <img src="image/Alien_LABS_1.jpg" alt="logo">
    </a>
  </div>

  <div class="container">
    <h2>Registro de Usuario</h2>
    <form id="registrationForm" action="registro.php" method="POST">
      <!-- Campo de nombre -->
      <label for="name">Nombre:</label><br>
      <input type="text" id="name" name="name" required minlength="2" maxlength="50"><br>
      <!-- Campo de correo electrónico -->
      <label for="email">Correo Electrónico:</label><br>
      <input type="email" id="email" name="email" required><br>
      <?php if (isset($email_error)): ?>
        <div class="error"><?= $email_error ?></div>
      <?php endif; ?>
      <!-- Campo de contraseña -->
      <label for="password">Contraseña:</label><br>
      <input type="password" id="password" name="password" required minlength="6" maxlength="20"><br>
      <!-- Confirmación de contraseña -->
      <label for="confirmPassword">Confirmar Contraseña:</label><br>
      <input type="password" id="confirmPassword" name="confirmPassword" required minlength="6" maxlength="20"><br>
      <!-- Mensajes de error -->
      <div class="error" id="passwordError"></div>
      <!-- Botón de enviar -->
      <input type="submit" value="Registrar">
    </form>
  </div>

  <!-- Script para validar la confirmación de contraseña -->
  <script>
    var password = document.getElementById("password");
    var confirmPassword = document.getElementById("confirmPassword");

    function validatePassword() {
      if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("Las contraseñas no coinciden");
      } else {
        confirmPassword.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
  </script>

</body>
</html>

<?php include 'footer.php'; ?>
