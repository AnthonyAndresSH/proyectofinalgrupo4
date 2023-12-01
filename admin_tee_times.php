<!-- admin_TeeTimes.php -->

<?php
// Aquí debes incluir la conexión a la base de datos y cualquier función necesaria

// Verificar la conexión a la base de datos
$servername = "localhost";
$username = "id21473610_andres";
$password = "Andres123**";
$dbname = "id21473610_golf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para agregar Tee Time
function agregarTeeTime($conn, $jugador_id, $fecha, $hora, $greenfee) {
    $sql = "INSERT INTO tee_times (jugador_id, fecha, hora, greenfee) VALUES ('$jugador_id', '$fecha', '$hora', '$greenfee')";
    return $conn->query($sql);
}

// Función para editar Tee Time
function editarTeeTime($conn, $teeTimeId, $jugador_id, $fecha, $hora, $greenfee) {
    $sql = "UPDATE tee_times SET jugador_id='$jugador_id', fecha='$fecha', hora='$hora', greenfee='$greenfee' WHERE id=$teeTimeId";
    return $conn->query($sql);
}

// Función para eliminar Tee Time
function eliminarTeeTime($conn, $teeTimeId) {
    $sql = "DELETE FROM tee_times WHERE id=$teeTimeId";
    return $conn->query($sql);
}

// Obtener lista de Tee Times
function obtenerListaTeeTimes($conn) {
    $sql = "SELECT * FROM tee_times";
    return $conn->query($sql);
}

// Manejar acciones de formulario (Agregar, Editar, Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregarTeeTime"])) {
        agregarTeeTime($conn, $_POST["jugador_id"], $_POST["fecha"], $_POST["hora"], $_POST["greenfee"]);
    } elseif (isset($_POST["editarTeeTime"])) {
        editarTeeTime($conn, $_POST["teeTimeId"], $_POST["jugador_id"], $_POST["fecha"], $_POST["hora"], $_POST["greenfee"]);
    } elseif (isset($_POST["eliminarTeeTime"])) {
        eliminarTeeTime($conn, $_POST["teeTimeId"]);
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Administrar Tee Times</title>
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
      <h2 class="text-center">Administrar Tee Times</h2>
      
<!-- Formulario para agregar/editar Tee Times -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-row">
        <div class="form-group col-md-3">
            <input type="text" class="form-control" placeholder="Jugador ID" name="jugador_id" value="<?php echo isset($jugadorIdEditar) ? $jugadorIdEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-3">
            <input type="date" class="form-control" name="fecha" value="<?php echo isset($fechaEditar) ? $fechaEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-3">
            <input type="time" class="form-control" name="hora" value="<?php echo isset($horaEditar) ? $horaEditar : ''; ?>" required>
        </div>
        <div class="form-group col-md-3">
            <input type="number" class="form-control" placeholder="Greenfee" name="greenfee" step="0.01" value="<?php echo isset($greenfeeEditar) ? $greenfeeEditar : ''; ?>" required>
        </div>
    </div>
    <div class="btn-container">
        <button type="submit" class="btn btn-success" name="agregarTeeTime">Agregar Tee Time</button>
        <button type="submit" class="btn btn-primary" name="editarTeeTime">Editar Tee Time</button>
    </div>
    <input type="hidden" name="teeTimeId" value="<?php echo isset($teeTimeIdEditar) ? $teeTimeIdEditar : ''; ?>">
</form>


      <!-- Lista de Tee Times -->     
<!-- Lista de Tee Times -->
<table class="table mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Jugador ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Greenfee</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Obtener lista de Tee Times
        $resultTeeTimes = obtenerListaTeeTimes($conn);

        // Mostrar registros en la tabla
        // Mostrar registros en la tabla
while ($row = $resultTeeTimes->fetch_assoc()) {
  echo "<tr>";
  echo "<td>{$row['id']}</td>";
  echo "<td>{$row['jugador_id']}</td>";
  echo "<td>{$row['fecha']}</td>";
  echo "<td>{$row['hora']}</td>";
  echo "<td>{$row['greenfee']}</td>";
  echo "<td>
          <form method='POST' action='{$_SERVER["PHP_SELF"]}'>
              <input type='hidden' name='teeTimeId' value='{$row['id']}'>";

  // Inicializar las variables de edición aquí
  $jugadorIdEditar = isset($row['jugador_id']) ? $row['jugador_id'] : '';
  $fechaEditar = isset($row['fecha']) ? $row['fecha'] : '';
  $horaEditar = isset($row['hora']) ? $row['hora'] : '';
  $greenfeeEditar = isset($row['greenfee']) ? $row['greenfee'] : '';

  if ($jugadorIdEditar !== '' && $fechaEditar !== '' && $horaEditar !== '' && $greenfeeEditar !== '') {
      echo "<button type='submit' class='btn btn-warning' name='editarTeeTime'>Editar</button>
              <button type='submit' class='btn btn-danger' name='eliminarTeeTime'>Eliminar</button>";
  } else {
      echo "<button type='button' class='btn btn-warning' disabled>Editar</button>
              <button type='button' class='btn btn-danger' disabled>Eliminar</button>";
  }

  echo "</form>
      </td>";
  echo "</tr>";
}


        ?>
    </tbody>
</table>



      <!-- Botón para regresar a StartAdmin.php -->
      <div class="btn-container">
        <a href="startadmin.php" class="btn btn-secondary">Volver a StartAdmin</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
