<?php
session_start();
include 'db_connection.php';

if (!function_exists('check_login')) {
    include 'check_login.php';
}

if (!check_login()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = json_decode($_POST['cart'], true);

if (empty($cart)) {
    header("Location: cart.php");
    exit();
}

// Calcular el total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Guardar la orden en la base de datos
$sql = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;
    
    // Guardar los detalles de la orden
    $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    foreach ($cart as $product_id => $item) {
        $stmt->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
        $stmt->execute();
    }
    
    // Limpiar el carrito en localStorage (esto se hace en el cliente)
    echo "<script>
      localStorage.removeItem('cart');
      alert('Pago confirmado. Gracias por tu compra!');
      window.location.href = 'home.php';
    </script>";
} else {
    echo "Error al procesar el pago: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
