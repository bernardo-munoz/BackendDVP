<?php

include 'config/conexion.php';

$placa_inventario = $_POST["placa_inventario"];

//$placa_inventario = "001-1245";


$sql = "SELECT id_mantenimiento, fecha, observaciones, CONCAT(nombres, ' ', apellidos) AS tecnico FROM mantenimientos m, usuarios u WHERE m.`id_tecnico` = u.`documento`AND placa_inventario = '".$placa_inventario."' ";

$resultado = mysqli_query($con, $sql);

if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){

    $arrayJson['success'] = '0';
    $arrayJson['message'] = "No hay información.";
}
else{

    $arrayJson['success'] = '1';
    $arrayJson['message'] = "Información encontrada.";
    ?>
    <table class="table" style="background: #dcdcdc;">
    <thead>
        <tr>
        <th scope="col">Id.</th>
        <th style="width: 10%;" scope="col">Fecha</th>
        <th scope="col">Observaciones</th>
        <th style="width: 20%;"scope="col">Tecnico</th>
        </tr>
    </thead>
    <tbody>

    <?php

    while($reg = mysqli_fetch_array($resultado)){
                                 
        $id_mantenimiento = $reg["id_mantenimiento"];
        $observaciones = $reg["observaciones"];
        $tecnico = $reg["tecnico"];
        $fecha = $reg["fecha"];

    ?>
        <tr>
        <th scope="row"><?php echo $id_mantenimiento; ?></th>
        <td style="color:black;"><?php echo $fecha; ?></td>
        <td style="color:black;"><?php echo $observaciones; ?></td>
        <td style="color:black;"><?php echo $tecnico; ?></td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
    </table>

    <?php
}

?>
