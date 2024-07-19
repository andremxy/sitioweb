<?php
include 'db_connection.php';
include 'check_login.php';

if (check_login()) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT COUNT(*) AS count FROM cart_items WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $cart_items = $row['count'];
    } else {
        $cart_items = 0; // Asignar un valor predeterminado si la consulta falla
        error_log("Error en la consulta SQL: " . $conn->error); // Registrar el error para su revisión
    }

    // Verificar si el usuario es administrador
    $sql = "SELECT role FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $is_admin = ($row['role'] == 'admin');
    } else {
        $is_admin = false; // Asignar un valor predeterminado si la consulta falla
        error_log("Error en la consulta SQL: " . $conn->error); // Registrar el error para su revisión
    }
} else {
    $cart_items = 0;
    $is_admin = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>alienlabs.cl</title>
  <link rel="stylesheet" href="css/start.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    ul.nav {
      text-align: center;
      background-color: #f8f9fa; /* Color de fondo gris */
    }
    ul.nav li a {
      color: red;
      font-size: 1.2em;
    }
    #logo {
      text-align: center;
      margin-top: 20px;
      background-color: #f8f9fa; /* Color de fondo gris */
    }
    #logo img {
      max-width: 200px;
    }
  </style>
</head>
<body>
  <div id="logo">
    <a href="home.php">
      <img src="image/Alien_LABS_2.jpg" alt="logo">
    </a>
  </div>

  <ul class="nav justify-content-center">
    <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="creatina.php">Creatinas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="proteina.php">Proteínas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="preentreno.php">Pre-entrenos</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="cart.php">
        Carrito <?= ($cart_items > 0) ? "($cart_items)" : ""; ?>
      </a>
    </li>
    <?php if (check_login()): ?>
      <?php if ($is_admin): ?>
        <li class="nav-item">
          <a class="nav-link" href="admin.php">Administración</a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
      </li>
    <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="registro.php">Registro</a>
      </li>
    <?php endif; ?>
  </ul>
</body>
</html>
