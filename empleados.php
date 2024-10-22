<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    if (isset($_COOKIE['error'])) {
        echo $_COOKIE['error'];
        unset($_COOKIE['error']);
        setcookie('error', '', 1);
    }
    if (isset($_COOKIE['exito'])) {
        echo $_COOKIE['exito'];
        unset($_COOKIE['exito']);
        setcookie('exito', '', 1);
    }

    const CRITERIOS = [
        'AND' => 'Y',
        'OR' => 'O',
    ];

    $numero = obtener_get('numero');
    $apellidos = obtener_get('apellidos');
    $criterio = obtener_get('criterio');
    $pdo = conectar();

    $where = [];
    $execute = [];

    if ($numero !== null && $numero != '') {
        $where[] = "numero = :numero";
        $execute[':numero'] = $numero;
    }


    if ($apellidos !== null && $apellidos != '') {
        $where[] = "apellidos ILIKE :apellidos";
        $execute[':apellidos'] = "%$apellidos%";
    }

    if (!empty($where)) {
        $separador = $criterio == 'OR' ? 'OR' : 'AND';
        $where = 'WHERE ' . implode(" $separador ", $where);
    } else {
        $where = '';
    }

    $stmt = $pdo->prepare("SELECT *
                             FROM empleados
                           $where
                         ORDER BY numero");
    $stmt->execute($execute);
    ?>
    <form action="" method="get">
        <label>Numero:
            <input type="text" name="numero" value="<?= $numero ?>" size="3">
        </label>
        <label>Apellidos:
            <input type="text" name="apellidos" value="<?= $apellidos ?>">
        </label>
        <label>Criterio:
            <select name="criterio">
                <?php foreach (CRITERIOS as $value => $texto): ?>
                    <option value="<?= $value ?>" <?= selected($criterio, $value) ?> >
                        <?= $texto ?>
                    </option>
                <?php endforeach ?>
            </select>
        </label>

        <button type="submit">Buscar</button>
    </form>
    <br>
    <table border="1">
        <thead>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Departamento</th>
            <th colspan="2">Acciones</th>
        </thead>
        <tbody>
            <?php foreach ($stmt as $fila): ?>
                <tr>
                    <td><?= $fila['numero'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td><?= $fila['apellidos'] ?></td>
                    <td><?= $fila['departamento_id'] ?></td>
                    <td><a href="modificar_empleado.php?id=<?= $fila['id'] ?>">Modificar</a></td>
                    <td><a href="borrar_empleado.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="insertar_empleado.php">Insertar un nuevo empleado</a>
</body>
</html>
