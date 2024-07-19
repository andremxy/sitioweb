<?php include 'header.php'; ?>
<!-- Contenido del carrito -->
<div class="container">
  <h2>Tu Carrito</h2>
  <div class="row" id="cart-items">
    <!-- Los ítems del carrito se generarán dinámicamente con JavaScript -->
  </div>
  <div class="row" id="cart-summary">
    <!-- Resumen del carrito se generará dinámicamente con JavaScript -->
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartSummaryContainer = document.getElementById('cart-summary');
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    let total = 0;

    if (Object.keys(cart).length === 0) {
      cartItemsContainer.innerHTML = '<p>No tienes productos en tu carrito.</p>';
      return;
    }

    Object.keys(cart).forEach(id => {
      const item = cart[id];
      total += item.price * item.quantity;

      const itemHTML = `
        <div class="col-md-4">
          <div class="card mb-3">
            <img src="${item.image}" class="card-img-top" alt="${item.name}">
            <div class="card-body">
              <h5 class="card-title">${item.name} $${item.price.toFixed(2)}</h5>
              <p class="card-text">Cantidad: ${item.quantity}</p>
              <p class="card-text">Total: $${(item.price * item.quantity).toFixed(2)}</p>
              <button class="btn btn-danger remove-from-cart" data-id="${id}">Eliminar</button>
            </div>
          </div>
        </div>
      `;
      cartItemsContainer.insertAdjacentHTML('beforeend', itemHTML);
    });

    const summaryHTML = `
      <div class="col-md-12">
        <h3>Total a Pagar: $${total.toFixed(2)}</h3>
        ${<?= json_encode(check_login()) ?> ? 
          `<form action="checkout.php" method="POST">
            <input type="hidden" name="cart" id="cart-input">
            <button type="submit" class="btn btn-success">Proceder al Pago</button>
          </form>` : 
          '<a href="login.php" class="btn btn-primary">Inicia sesión para confirmar la compra</a>'}
      </div>
    `;
    cartSummaryContainer.insertAdjacentHTML('beforeend', summaryHTML);

    document.getElementById('cart-input').value = JSON.stringify(cart);

    document.querySelectorAll('.remove-from-cart').forEach(button => {
      button.addEventListener('click', removeFromCart);
    });

    function removeFromCart(event) {
      const id = event.target.getAttribute('data-id');
      delete cart[id];
      localStorage.setItem('cart', JSON.stringify(cart));
      location.reload();
    }
  });
</script>

<?php include 'footer.php'; ?>
