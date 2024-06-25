<?php

    require_once 'conexion.php';

    class Session{

        private $sessionStatus;
        
        public function __construct()
        {
            session_start();
            $this->setSession();
        }

        public function setSession(){
            $_SESSION["id_session"] = session_id();
        }

        public function getSession(){
            return $_SESSION["id_session"];
        }

        public function verifySession(){
            $handle = new Conexion();

            $querry = 'SELECT * FROM session WHERE idsession = ? AND active = ?';
            $TypeParam = 'ss';
            $ValueParam = array($this->getSession(),1);

            $result = $handle->runQuerySession($querry,$TypeParam,$ValueParam);

            if(!empty($result)){
                $this->sessionStatus = true;
                $handle->close();
                return $result['nip'];
            }else{
                $this->closeSession();
                $handle->close();
            }
        }

        public function setCloseSession(){
            $handle = new Conexion();

            $querry = 'UPDATE usuarios SET active = ? WHERE idsession = ?';
            $TypeParam = 'ss';
            $ValueParam = array('0',$this->getSession());

            $handle->update($querry,$TypeParam,$ValueParam);

            $handle->close();
            $this->closeSession();

        }

        public function getSessionStatus(){
            return $this->sessionStatus;
        }

        public function closeSession(){
            session_unset();
            session_destroy();
            $this->sessionStatus = false;
        }

    }

?>