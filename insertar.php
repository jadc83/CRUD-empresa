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
    $pdo = conectar();

    if (isset($codigo, $denominacion, $localidad)) {
        $errores = [];
        comprobar_codigo($codigo, $errores, $pdo);
        comprobar_denominacion($denominacion, $errores, $pdo);
        comprobar_localidad($localidad, $errores, $pdo);

        if (!empty($errores)) {
            mostrar_errores($errores);
        } else {
            $stmt = $pdo->prepare('INSERT INTO departamentos
                               (codigo, denominacion, localidad)
                           VALUES (:codigo, :denominacion, :localidad)');
            $stmt->execute([
                ':codigo' => $codigo,
                ':denominacion' => $denominacion,
                ':localidad' => $localidad,
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
        <button type="submit">Insertar</button>
        <a href="departamentos.php">Cancelar</a>
    </form>
</body>
</html>