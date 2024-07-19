<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo electrónico no registrado.";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container">
  <h2>Iniciar Sesión</h2>
  <form method="POST" action="">
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <input type="submit" value="Iniciar Sesión">
    <?php if (isset($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
  </form>
</div>
<?php include 'footer.php'; ?>
