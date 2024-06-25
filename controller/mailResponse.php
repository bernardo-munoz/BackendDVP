<?php

$to = $_POST["correo"];
$nombre = $_POST["empresa"];
/*
$to = "ismael.meza@unisucre.edu.co";
$nombre = "Ing. Ismael Meza";
*/

$subject = "Solicitud de registro de empresa";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: noreply@unisucre.edu.co";

/*
$to = $_POST["correo"];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo_institucional = $_POST["correo_institucional"];
$password = $_POST["password"];
*/

/*
$message = '
<div style="text-align: center;">
<img src="http://servicios.unisucre.edu.co/correo/images/head.png" alt="">
<div style ="
color: #087959;
background: #ffffff;
padding: 25px;
margin: 0px;
width: 58%;
margin: auto;
">
<p><strong>Usuario:</strong> '.$correo_institucional.'</p>
<p><strong>Contraseña:</strong> '.$password.'</p>
</div>
<img src="http://servicios.unisucre.edu.co/correo/images/foot.png" alt="">
</div>

';
*/

$message = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo Insitucional | Unisucre</title>


    <style type="text/css">

.testimonial {
    background: #0fc690;
    padding: 60px 0px;
}

.testimonial .titlepage {
    text-align: center;
}

.testimonial .titlepage h3 {
    padding: 0px 0px 6px 0px;
    font-size: 30px;
    font-weight: bold;
    color: #fff;
    line-height: 46px;
    border-bottom: #fff solid 1px;
    width: 184px;
    margin: 0 auto;
    margin-bottom: 60px;
}

p{
    font-size:20px;
}

.footer{
    font-family: "poppins", sans-serif;
    background: #023023;
    padding-top: 55px;
    box-sizing: border-box !important;
    color: white;
    font-size: 14px;
    font-weight: normal;
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    box-sizing: border-box;
}

#row_footer{
    display: flex;
    justify-content: center;
}

.address{
    text-align: center;
}

.copyright{
    color: #000;
    text-align: center;
    background-color: #fff;
    padding: 20px 0px;
    margin-top: 55px;
}

i{
    display: flex;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
}

.footer a{
    color: #222222;
}


.footer strong{
    font-weight: 700;
}

ul.contant_icon li{
    float: left;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding-right: 8px;
}

    </style>
    

</head>
<body>


<!-- Testimonial -->
<div id="testimonial" class="testimonial">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                    <img style="width: 10%;" src="http://servicios.unisucre.edu.co/correo/images/unisucre.png" alt="">
                     <h3  style="width: 80%;">Universidad de Sucre</h3>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2 style="color:white;">Hola '.$nombre.',</h2>
                     <p style="color:white;">Su solicitud de registro ha sido tramitada con exito, para hacer las consultas de egresados, ingrese dando <a href="https://servicios.unisucre.edu.co/uds/loginEmpresarios.php"> click aqui</a> con su NIT y contraseña registrada.</p>

                     <p style="color:white;">Para más información, escriba al correo: egresados@unisucre.edu.co</p>
                         
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end Testimonial -->


<footr>
         <div class="footer">
            <div class="container">
               <div id="row_footer" class="row">
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Dirección</h3>
                        <i><img src="http://servicios.unisucre.edu.co/correo/controller/icon/3.png">Cra 28 # 5-267 Barrio Puerta Roja - Sincelejo (Sucre)</i>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Horario de atención</h3>
                        <i><img src="http://servicios.unisucre.edu.co/correo/controller/icon/2.png">Lunes a Viernes de 8:00 a.m.- 12 m. y de 2:00 p.m.- 6:00 p.m</i>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Enlaces de interes</h3>
                        <a href="https://unisucre.edu.co/" target="_blank" ><i ><img src="http://servicios.unisucre.edu.co/correo/controller/icon/1.png">Universidad de Sucre</i></a>
                     </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-12 width">
                     <div class="address">
                        <h3>Redes Sociales </h3>
                        <ul class="contant_icon">
                           <a href="https://www.facebook.com/Unisucreco" target="_blank"><li><img  src="http://servicios.unisucre.edu.co/correo/controller/icon/fb.png" alt="icon"/></li></a>
                           <a href="https://twitter.com/unisucre" target="_blank"><li><img  src="http://servicios.unisucre.edu.co/correo/controller/icon/tw.png" alt="icon"/></li></a>
                           <a href="https://www.instagram.com/unisucreco/" target="_blank"><li><img src="http://servicios.unisucre.edu.co/correo/controller/icon/instagram.png" alt="icon"/></li></a>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <p>Copyright 2021 Todos los derechos reservados a <a href="https://unisucre.edu.co/" target="_blank"><strong>Universidad de Sucre</strong></a></p>
            </div>
         </div>
      </footr>

</body>
</html>
';

/*
$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<h3>Saludos ".$nombre.",</h3>
<img src= 'http://gestiondocumental.unisucre.edu.co/creditos/images/correo.png' alt='' />

<p><?php echo $correo_institucional; ?></p>
<p><?php echo $password; ?></p>
</body>
</html>";
*/

if($to != ""){
    mail($to, $subject, $message, $headers);
    $arrayJson['success'] = '1';
}
else
    $arrayJson['success'] = '0'.$to.$nombre;

echo json_encode($arrayJson,JSON_FORCE_OBJECT);


?>