<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=empleados', 'empleados', 'empleados');
}

function obtener_get($par) {
    return isset($_GET[$par]) ? trim($_GET[$par]) : null;
}

function obtener_post($par) {
    return isset($_POST[$par]) ? trim($_POST[$par]) : null;
}

function selected($criterio, $valor)
{
    return $criterio == $valor ? 'selected' : '';
}

function volver_departamentos()
{
    header('Location: departamentos.php');
}

function departamento_por_id($id, ?PDO $pdo = null, $bloqueo = false): array|false
{
    $pdo = $pdo ?? conectar();
    $sql = 'SELECT * FROM departamentos WHERE id = :id';
    if ($bloqueo) {
        $sql .= ' FOR UPDATE';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function departamento_por_codigo($codigo, ?PDO $pdo = null, $bloqueo = false): array|false
{
    $pdo = $pdo ?? conectar();
    $sql = 'SELECT * FROM departamentos WHERE codigo = :codigo';
    if ($bloqueo) {
        $sql .= ' FOR UPDATE';
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':codigo' => $codigo]);
    return $stmt->fetch();
}


function anyadir_error($par, $mensaje, &$errores)
{
    if (!isset($errores[$par])) {
        $errores[$par] = [];
    }
    $errores[$par][] = $mensaje;
}

function comprobar_codigo($codigo, &$errores, ?PDO $pdo = null)
{
    $pdo = $pdo ?? conectar();
    if ($codigo == '') {
        anyadir_error('codigo', 'El código no puede estar vacío', $errores);
    } elseif (mb_strlen($codigo) > 2) {
        anyadir_error('codigo', 'El código es demasiado largo', $errores);
    } elseif (departamento_por_codigo($codigo, $pdo)) {
        anyadir_error('codigo', 'Ese departamento ya existe', $errores);
    }
}

function comprobar_denominacion($denominacion, &$errores, ?PDO $pdo = null)
{
    $pdo = $pdo ?? conectar();
    if ($denominacion == '') {
        anyadir_error('denominacion', 'La denominación no puede estar vacía', $errores);
    } elseif (mb_strlen($denominacion) > 255) {
        anyadir_error('denominacion', 'La denominación es demasiado larga', $errores);
    }
}

function comprobar_localidad(&$localidad, &$errores, ?PDO $pdo = null)
{
    $pdo = $pdo ?? conectar();
    if ($localidad == '') {
        $localidad = null;
    } elseif (mb_strlen($localidad) > 255) {
        anyadir_error('localidad', 'La localidad es demasiado larga', $errores);
    }
}

function mostrar_errores($errores)
{
    foreach ($errores as $par => $mensajes) {
        foreach ($mensajes as $mensaje) { ?>
            <h2><?= $mensaje ?></h3><?php
        }
    }
}