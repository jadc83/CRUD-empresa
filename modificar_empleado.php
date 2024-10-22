<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un departamento</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');
    $pdo = conectar();

    if (!($fila = comprobar_id($id, $pdo))) {
        setcookie('error', 'Error al recuperar el empleado');
        volver_empleados();
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numero = obtener_post('numero');
        $nombre = obtener_post('nombre');
        $apellidos = obtener_post('apellidos');
        $departamento_id = obtener_post('departamento_id');

        if (isset($numero, $nombre, $apellidos, $departamento_id)) {
            $errores = [];
            //comprobar_numero($numero, $errores, $pdo, $id);
            //comprobar_nombre($nombre, $errores, $pdo);
            //comprobar_apellidos($apellidos, $errores);
            //comprobar_departamento_id($departamento_id, $errores);

            if (!empty($errores)) {
                mostrar_errores($errores);
            } else {
                $stmt = $pdo->prepare('UPDATE empleados
                                          SET numero = :numero,
                                              nombre = :nombre,
                                              apellidos = :apellidos,
                                              departamento_id = :departamento_id
                                        WHERE id = :id');
                $stmt->execute([
                    ':id' => $id,
                    ':numero' => $numero,
                    ':nombre' => $nombre,
                    ':apellidos' => $apellidos,
                    ':departamento_id' => $departamento_id,
                ]);
                setcookie('exito', 'El empleado se ha modificado correctamente');
                volver_empleados();
                return;
            }
        }
    } else {
        $numero = $fila['numero'];
        $nombre = $fila['nombre'];
        $apellidos = $fila['apellidos'];
        $departamento_id = $fila['departamento_id'];
    }
    ?>
    <form action="" method="post">
        <label>
            Numero:
            <input type="text" name="numero" value="<?= $numero ?>">
        </label>
        <br>
        <label>
            Nombre:
            <input type="text" name="nombre" value="<?= $nombre ?>">
        </label>
        <br>
        <label>
            Apellidos:
            <input type="text" name="apellidos" value="<?= $apellidos ?>">
        </label>
        <br>
        <label>
            Departamento:
            <input type="text" name="departamento_id" value="<?= $departamento_id ?>">
        </label>
        <br>
        <button type="submit">Modificar</button>
        <a href="empleados.php">Cancelar</a>
    </form>
</body>
</html>
