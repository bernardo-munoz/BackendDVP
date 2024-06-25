<?php

	/*Datos de conexion a la base de datos*/
	define('DB_HOST', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
	define('DB_USER', 'servicio_admin');//Usuario de tu base de datos
	//define('DB_USER', 'root');//Usuario de tu base de datos
	define('DB_PASS', 'b0kC!J4;$2H7');//Contraseña del usuario de la base de datos
	//<<define('DB_PASS', 'admin');//Contraseña del usuario de la base de datos
	//define('DB_PASS', 'tmpserverweb22017');//Contraseña del usuario de la base de datos
	define('DB_NAME', 'servicio_uds');//Nombre de la base de datos
	//define('DB_NAME', 'belbox');//Nombre de la base de datos b0kC!J4;$2H7


    class Conexion{

        //private $config;
        private $conexion;

        function __construct()
        {
            //$this->config = parse_ini_file('config/config.ini');
            $this->conexion = $this->connectionDB();
        }

        function connectionDB(){
            return mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        }

        function runQuery($query, $param_type, $param_value_array){
            $sql = $this->conexion->prepare($query);
            $this->bindQueryParams($sql, $param_type, $param_value_array);
            $sql->execute();
            $result = $sql->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);

        }

        function runQuerySession($query, $param_type, $param_value_array){
            $sql = $this->conexion->prepare($query);
            $this->bindQueryParams($sql, $param_type, $param_value_array);
            $sql->execute();
            $result = $sql->get_result();
            
            if ($result->num_rows > 0) {
                $resultset = $result->fetch_array(MYSQLI_ASSOC);
                return $resultset;
            }
        }
    
        function bindQueryParams($sql, $param_type, $param_value_array) {
            $param_value_reference[] = & $param_type;
            for($i=0; $i<count($param_value_array); $i++) {
                $param_value_reference[] = & $param_value_array[$i];
            }
            call_user_func_array(array(
                $sql,
                'bind_param'
            ), $param_value_reference);
        }
    
        function insert($query, $param_type, $param_value_array) {
            $sql = $this->conexion->prepare($query);
            $this->bindQueryParams($sql, $param_type, $param_value_array);
            
            if($sql->execute()){
                return 1;
            }else{
                return 0;
            }
        }
    
        function update($query, $param_type, $param_value_array) {
            $sql = $this->conexion->prepare($query);
            $this->bindQueryParams($sql, $param_type, $param_value_array);
            $sql->execute();
        }

        function close(){
            $this->conexion->close();
        }

    }
?>