<?php
include 'header.php';
include 'db_connection.php';

if (!function_exists('check_login')) {
    include 'check_login.php';
}

if (!check_login()) {
    header("Location: login.php");
    exit();
}

$cart = json_decode($_POST['cart'], true);
$total = 0;

?>

<div class="container">
  <h2>Resumen del Pedido</h2>
  <div class="row">
    <?php if (!empty($cart)): ?>
      <?php foreach ($cart as $id => $item): ?>
        <div class="col-md-4">
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"><?= $item['name'] ?> $<?= number_format($item['price'], 2) ?></h5>
              <p class="card-text">Cantidad: <?= $item['quantity'] ?></p>
              <p class="card-text">Total: $<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
              <?php $total += $item['price'] * $item['quantity']; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="col-md-12">
        <h3>Total a Pagar: $<?= number_format($total, 2) ?></h3>
        <form action="confirm_payment.php" method="POST">
          <input type="hidden" name="cart" value='<?= json_encode($cart) ?>'>
          <button type="submit" class="btn btn-success">Confirmar Pago</button>
        </form>
      </div>
    <?php else: ?>
      <p>No tienes productos en tu carrito.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
