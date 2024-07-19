<?php
include 'db_connection.php';
include 'header.php';

if (!check_login()) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Obtener información del usuario actual
$sql = "SELECT role, name FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user_info = $result->fetch_assoc();
$is_admin = ($user_info['role'] == 'admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];

            $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
            if ($conn->query($sql) === TRUE) {
                header('Location: admin.php');
                exit;
            } else {
                error_log("Error en la consulta SQL: " . $conn->error);
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                header('Location: admin.php');
                exit;
            } else {
                error_log("Error en la consulta SQL: " . $conn->error);
            }
        } elseif ($action === 'delete') {
            $id = $_POST['id'];

            $sql = "DELETE FROM users WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                header('Location: admin.php');
                exit;
            } else {
                error_log("Error en la consulta SQL: " . $conn->error);
            }
        }
    }
}

// Obtener lista de usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    error_log("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha de Creación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?= $user['id'] ?>" data-name="<?= $user['name'] ?>" data-email="<?= $user['email'] ?>" data-role="<?= $user['role'] ?>">Editar</button>
                    <form method="POST" action="admin.php" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Agregar Usuario</button>
</div>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="admin.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rol</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="admin.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit-user-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-role" class="form-label">Rol</label>
                        <select class="form-select" id="edit-role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    // Rellenar los datos del modal de edición cuando se haga clic en el botón de edición
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var role = button.getAttribute('data-role');

        var modalIdInput = editUserModal.querySelector('#edit-user-id');
        var modalNameInput = editUserModal.querySelector('#edit-name');
        var modalEmailInput = editUserModal.querySelector('#edit-email');
        var modalRoleInput = editUserModal.querySelector('#edit-role');

        modalIdInput.value = id;
        modalNameInput.value = name;
        modalEmailInput.value = email;
        modalRoleInput.value = role;
    });
</script>
</body>
</html>
