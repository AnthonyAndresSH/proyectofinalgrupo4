<!-- admin_horarios.php -->

<?php

$servername = "localhost";
$username = "id21473610_andres";
$password = "Andres123**";
$dbname = "id21473610_golf";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$horarioIdEditar = $fechaEditar = $horaInicioEditar = $horaFinEditar = "";

// Función para agregar horario
function agregarHorario($conn, $fecha, $horaInicio, $horaFin) {
    $sql = "INSERT INTO horarios_juego (fecha, hora_inicio, hora_fin) VALUES ('$fecha', '$horaInicio', '$horaFin')";
    return $conn->query($sql);
}

// Función para editar horario
function editarHorario($conn, $horarioId, $fecha, $horaInicio, $horaFin) {
    $sql = "UPDATE horarios_juego SET fecha='$fecha', hora_inicio='$horaInicio', hora_fin='$horaFin' WHERE id=$horarioId";
    return $conn->query($sql);
}

// Función para eliminar horario
function eliminarHorario($conn, $horarioId) {
    $sql = "DELETE FROM horarios_juego WHERE id=$horarioId";
    return $conn->query($sql);
}

// Obtener lista de horarios
function obtenerListaHorarios($conn) {
    $sql = "SELECT * FROM horarios_juego";
    return $conn->query($sql);
}

// Manejar acciones de formulario (Agregar, Editar, Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregarHorario"])) {
        agregarHorario($conn, $_POST["fecha"], $_POST["horaInicio"], $_POST["horaFin"]);
    } elseif (isset($_POST["editarHorario"])) {
        editarHorario($conn, $_POST["horarioId"], $_POST["fecha"], $_POST["horaInicio"], $_POST["horaFin"]);
    } elseif (isset($_POST["eliminarHorario"])) {
        eliminarHorario($conn, $_POST["horarioId"]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Administrar Horarios</title>
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
      <h2 class="text-center">Administrar Horarios</h2>
      
      <!-- Formulario para agregar/editar Horarios -->
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
          <div class="form-group col-md-4">
            <input type="date" class="form-control" name="fecha" value="<?php echo isset($fechaEditar) ? $fechaEditar : ''; ?>" required>
          </div>
          <div class="form-group col-md-4">
            <input type="time" class="form-control" name="horaInicio" value="<?php echo isset($horaInicioEditar) ? $horaInicioEditar : ''; ?>" required>
          </div>
          <div class="form-group col-md-4">
            <input type="time" class="form-control" name="horaFin" value="<?php echo isset($horaFinEditar) ? $horaFinEditar : ''; ?>" required>
          </div>
        </div>
        <div class="btn-container">
          <button type="submit" class="btn btn-success" name="agregarHorario">Agregar Horario</button>
          <button type="submit" class="btn btn-primary" name="editarHorario">Editar Horario</button>
        </div>
        <input type="hidden" name="horarioId" value="<?php echo isset($horarioIdEditar) ? $horarioIdEditar : ''; ?>">
      </form>

      <!-- Lista de Horarios -->
      <table class="table mt-3">
        <thead>
          <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Obtener lista de Horarios
          $resultHorarios = obtenerListaHorarios($conn);

          // Mostrar registros en la tabla
          while ($row = $resultHorarios->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['fecha']}</td>";
            echo "<td>{$row['hora_inicio']}</td>";
            echo "<td>{$row['hora_fin']}</td>";
            echo "<td>
                    <form method='POST' action='{$_SERVER["PHP_SELF"]}'>
                      <input type='hidden' name='horarioId' value='{$row['id']}'>";
            
            // Verificar si $row está definido y no es nulo
            if (isset($row['fecha']) && isset($row['hora_inicio']) && isset($row['hora_fin'])) {
              echo "<button type='submit' class='btn btn-warning' name='editarHorario'>Editar</button>
                      <button type='submit' class='btn btn-danger' name='eliminarHorario'>Eliminar</button>";
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
