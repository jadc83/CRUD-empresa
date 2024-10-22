<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $codigo = obtener_post('codigo');
    $denominacion = obtener_post('denominacion');
    $localidad = obtener_post('localidad');
    $fecha_alta = obtener_post('fecha_alta');
    $pdo = conectar();

    if (isset($codigo, $denominacion, $localidad, $fecha_alta)) {
        $errores = [];
        comprobar_codigo($codigo, $errores, $pdo);
        comprobar_denominacion($denominacion, $errores, $pdo);
        comprobar_localidad($localidad, $errores);
        comprobar_fecha_alta($fecha_alta, $errores);

        if (!empty($errores)) {
            mostrar_errores($errores);
        } else {
            $stmt = $pdo->prepare('INSERT INTO departamentos
                               (codigo, denominacion, localidad, fecha_alta)
                           VALUES (:codigo, :denominacion, :localidad, :fecha_alta)');
            $stmt->execute([
                ':codigo' => $codigo,
                ':denominacion' => $denominacion,
                ':localidad' => $localidad,
                ':fecha_alta' => $fecha_alta,
            ]);
            setcookie('exito', 'El departamento se ha insertado correctamente');
            volver_departamentos();
            return;
        }
    }
    ?>
    <form action="" method="post">
        <label>
            Código:
            <input type="text" name="codigo" value="<?= $codigo ?>">
        </label>
        <br>
        <label>
            Denominación:
            <input type="text" name="denominacion" value="<?= $denominacion ?>">
        </label>
        <br>
        <label>
            Localidad:
            <input type="text" name="localidad" value="<?= $localidad ?>">
        </label>
        <br>
        <label>
            Fecha de alta:
            <input type="datetime-local" name="fecha_alta" value="<?= fecha_formulario($fecha_alta, true) ?>">
        </label>
        <br>
        <button type="submit">Insertar</button>
        <a href="departamentos.php">Cancelar</a>
    </form>
</body>
</html>
