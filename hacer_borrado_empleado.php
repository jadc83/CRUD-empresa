<?php
require 'auxiliar.php';

$id = obtener_post('id');
if (!isset($id)) {
    setcookie('error', 'Falta el parámetro id');
    volver_empleados();
    return;
}


$pdo = conectar();
$fila = empleado_por_id($id, $pdo, true);
if ($fila === false) {
    setcookie('error', 'El departamento no existe');
    volver_empleados();
    return;
}


$stmt = $pdo->prepare('DELETE FROM empleados
                             WHERE id = :id');
$stmt->execute([':id' => $id]);
$pdo->commit();
setcookie('exito', 'El empleado se ha borrado correctamente');
volver_empleados();
