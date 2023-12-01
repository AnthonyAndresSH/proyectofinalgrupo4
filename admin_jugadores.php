<!-- admin_jugadores.php -->

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "id21473610_andres";
$password = "Andres123**";
$dbname = "id21473610_golf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para agregar jugador
function agregarJugador($conn, $nombre, $correo, $contrasena, $telefono) {
    $sql = "INSERT INTO jugadores (nombre, correo, contraseña, teléfono) VALUES ('$nombre', '$correo', '$contrasena', '$telefono')";
    return $conn->query($sql);
}

// Función para editar jugador
function editarJugador($conn, $id, $nombre, $correo, $contrasena, $telefono) {
    $sql = "UPDATE jugadores SET nombre='$nombre', correo='$correo', contraseña='$contrasena', teléfono='$telefono' WHERE id=$id";
    return $conn->query($sql);
}

// Función para eliminar jugador
function eliminarJugador($conn, $id) {
    $sql = "DELETE FROM jugadores WHERE id=$id";
    return $conn->query($sql);
}

if (isset($_POST["regresar"])) {

}


if (isset($_POST["editar"])) {
    $idEditar = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($idEditar !== null) {
        $sqlEditar = "SELECT * FROM jugadores WHERE id=?";
        $stmt = $conn->prepare($sqlEditar);
        $stmt->bind_param("i", $idEditar);
        $stmt->execute();
        $resultEditar = $stmt->get_result();

        if ($resultEditar->num_rows > 0) {
            $rowEditar = $resultEditar->fetch_assoc();
            $nombreEditar = $rowEditar['nombre'];
            $correoEditar = $rowEditar['correo'];
            $telefonoEditar = $rowEditar['teléfono'];
            // La contraseña no debería ser cargada en el formulario por razones de seguridad
        }

        $stmt->close();
    }
}

// Manejar acciones de formulario (Agregar, Editar, Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar"])) {
        agregarJugador($conn, isset($_POST["nombre"]) ? $_POST["nombre"] : '', isset($_POST["correo"]) ? $_POST["correo"] : '', isset($_POST["contrasena"]) ? $_POST["contrasena"] : '', isset($_POST["telefono"]) ? $_POST["telefono"] : '');
    } elseif (isset($_POST["editar"])) {
        $idEditar = isset($_POST["id"]) ? $_POST["id"] : null;
        $nombreEditar = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        $correoEditar = isset($_POST["correo"]) ? $_POST["correo"] : '';
        $telefonoEditar = isset($_POST["telefono"]) ? $_POST["telefono"] : '';
        $contrasenaEditar = isset($_POST["contrasena"]) ? $_POST["contrasena"] : '';

        if ($idEditar !== null) {
            // Ejecutar la consulta de actualización
            $sqlActualizar = "UPDATE jugadores SET nombre=?, correo=?, teléfono=?, contraseña=? WHERE id=?";
            $stmtActualizar = $conn->prepare($sqlActualizar);
            $stmtActualizar->bind_param("ssssi", $nombreEditar, $correoEditar, $telefonoEditar, $contrasenaEditar, $idEditar);
            $stmtActualizar->execute();
            $stmtActualizar->close();
        }
    } elseif (isset($_POST["eliminar"])) {
        eliminarJugador($conn, isset($_POST["id"]) ? $_POST["id"] : '');
    }
}

// Obtener lista de jugadores
$sql = "SELECT * FROM jugadores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Administrar Jugadores</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      background: url('https://www.toptal.com/designers/subtlepatterns/patterns/symphony.png');
    }
    .container {
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      padding: 20px;
      margin-top: 50px;
    }
    .btn-container {
      text-align: center;
      margin-top: 20px;
    }
    .btn-container button {
      margin: 10px;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <h2 class="text-center">Administrar Jugadores</h2>
      
      <!-- Formulario para agregar/editar jugadores -->
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-row">
        <div class="form-group col-md-4">
            <input type="text" class="form-control" placeholder="Nombre" name="nombre" value="<?php echo isset($nombreEditar) ? $nombreEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-4">
            <input type="email" class="form-control" placeholder="Correo" name="correo" value="<?php echo isset($correoEditar) ? $correoEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" placeholder="Teléfono" name="telefono" value="<?php echo isset($telefonoEditar) ? $telefonoEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-2">
            <!-- Mantener el campo de contraseña vacío para edición -->
            <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" value="" required>
        </div>
    </div>
    <div class="btn-container">
        <button type="submit" class="btn btn-success" name="agregar">Agregar</button>
        <button type="submit" class="btn btn-primary" name="editar">Editar</button>
        <a href="startAdmin.php" class="btn btn-secondary">Volver a StartAdmin</a>
    </div>
    <input type="hidden" name="id" value="<?php echo isset($idEditar) ? $idEditar : ''; ?>">
</form>

      <!-- Lista de jugadores -->
      <table class="table mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['correo']}</td>";
            echo "<td>{$row['teléfono']}</td>";
            echo "<td>
                    <form method='POST' action='{$_SERVER["PHP_SELF"]}'>
                      <input type='hidden' name='id' value='{$row['id']}'>
                      <button type='submit' class='btn btn-warning' name='editar'>Editar</button>
                      <button type='submit' class='btn btn-danger' name='eliminar'>Eliminar</button>
                    </form>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
