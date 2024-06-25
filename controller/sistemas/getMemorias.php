<?php

include 'config/conexion.php';

$placa_inventario = $_POST["placa_inventario"];

//$placa_inventario = "001-1245";


$sql = "SELECT * FROM memorias WHERE placa_inventario = '".$placa_inventario."' ";

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
        <th >Id.</th>
        <th >Capacidad</th>
        <th >Tipo de memoria</th>
        <th >Fecha Registro</th>
        </tr>
    </thead>
    <tbody>

    <?php
    while($reg = mysqli_fetch_array($resultado)){
    ?>
        <tr>
        <th scope="row"><?php echo $reg["id_memoria"]; ?></th>
        <td style="color:black;"><?php echo $reg["capacidad"]; ?></td>
        <td style="color:black;"><?php echo $reg["tipo_memoria"]; ?></td>
        <td style="color:black;"><?php echo $reg["fecha"]; ?></td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
    </table>

    <?php
}

?>
