<!-- admin_precios.php -->

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

// Inicializar variables
$tarifaIdEditar = $fechaEditar = $greenfeeEditar = "";

// Funciones para manejar tarifas
function agregarTarifa($conn, $fecha, $greenfee) {
    $sql = "INSERT INTO tarifas (fecha, greenfee) VALUES ('$fecha', '$greenfee')";
    return $conn->query($sql);
}

function editarTarifa($conn, $tarifaId, $fecha, $greenfee) {
    $sql = "UPDATE tarifas SET fecha=?, greenfee=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fecha, $greenfee, $tarifaId);
    $stmt->execute();
    $stmt->close();
}

function eliminarTarifa($conn, $tarifaId) {
    $sql = "DELETE FROM tarifas WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tarifaId);
    $stmt->execute();
    $stmt->close();
}

// Manejar acciones de formulario (Agregar, Editar, Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregarTarifa"])) {
        agregarTarifa($conn, $_POST["fecha"], $_POST["greenfee"]);
    } elseif (isset($_POST["editarTarifa"])) {
        $tarifaIdEditar = isset($_POST["tarifaId"]) ? $_POST["tarifaId"] : null;

        if ($tarifaIdEditar !== null) {
            $sqlEditar = "SELECT * FROM tarifas WHERE id=?";
            $stmt = $conn->prepare($sqlEditar);
            $stmt->bind_param("i", $tarifaIdEditar);
            $stmt->execute();
            $resultEditar = $stmt->get_result();

            if ($resultEditar->num_rows > 0) {
                $rowEditar = $resultEditar->fetch_assoc();
                $fechaEditar = $rowEditar['fecha'];
                $greenfeeEditar = $rowEditar['greenfee'];
            }

            $stmt->close();
        }
    } elseif (isset($_POST["eliminarTarifa"])) {
        eliminarTarifa($conn, $_POST["tarifaId"]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Administrar Precios</title>
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
            <h2 class="text-center">Administrar Precios</h2>
            
            <!-- Formulario para agregar/editar tarifas -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="date" class="form-control" name="fecha" value="<?php echo isset($fechaEditar) ? $fechaEditar : ''; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="number" class="form-control" placeholder="Greenfee" name="greenfee" step="0.01" value="<?php echo isset($greenfeeEditar) ? $greenfeeEditar : ''; ?>" required>
                    </div>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn btn-success" name="agregarTarifa">Agregar Tarifa</button>
                    <button type="submit" class="btn btn-primary" name="editarTarifa">Editar Tarifa</button>
                </div>
                <input type="hidden" name="tarifaId" value="<?php echo isset($tarifaIdEditar) ? $tarifaIdEditar : ''; ?>">
            </form>

            <!-- Lista de tarifas -->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Greenfee</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener lista de tarifas
                    $resultTarifas = $conn->query("SELECT * FROM tarifas");

                    // Mostrar registros en la tabla
                    while ($row = $resultTarifas->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['fecha']}</td>";
                        echo "<td>{$row['greenfee']}</td>";
                        echo "<td>
                                <form method='POST' action='{$_SERVER["PHP_SELF"]}'>
                                    <input type='hidden' name='tarifaId' value='{$row['id']}'>
                                    <button type='submit' class='btn btn-warning' name='editarTarifa'>Editar</button>
                                    <button type='submit' class='btn btn-danger' name='eliminarTarifa'>Eliminar</button>
                                </form>
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
