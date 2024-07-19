<?php include 'header.php'; ?>
<!-- Contenido específico de la página de Proteínas -->
<div class="container">
  <div class="row">
    <?php
    include 'db_connection.php';

    // Obtener productos de la base de datos
    $sql = "SELECT * FROM products WHERE name LIKE '%Proteína%' OR name LIKE '%Protein%' OR name LIKE '%Gainer%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0):
      while($row = $result->fetch_assoc()):
    ?>
        <div class="col-md-4">
          <div class="card mb-3">
            <img src="<?= $row['image_url'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $row['name'] ?> $<?= number_format($row['price'], 2) ?></h5>
              <p class="card-text"><?= $row['description'] ?></p>
              <button class="btn btn-primary add-to-cart" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-price="<?= $row['price'] ?>" data-image="<?= $row['image_url'] ?>">Agregar al carro</button>
            </div>
          </div>
        </div>
    <?php
      endwhile;
    else:
    ?>
      <p>No hay productos de proteínas disponibles en este momento.</p>
    <?php endif; ?>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
      button.addEventListener('click', addToCart);
    });

    function addToCart(event) {
      const button = event.target;
      const id = button.getAttribute('data-id');
      const name = button.getAttribute('data-name');
      const price = button.getAttribute('data-price');
      const image = button.getAttribute('data-image');
      
      let cart = JSON.parse(localStorage.getItem('cart')) || {};
      
      if (cart[id]) {
        cart[id].quantity++;
      } else {
        cart[id] = {
          name: name,
          price: parseFloat(price),
          image: image,
          quantity: 1
        };
      }

      localStorage.setItem('cart', JSON.stringify(cart));
      alert('Producto agregado al carrito');
    }
  });
</script>

<?php include 'footer.php'; ?>
