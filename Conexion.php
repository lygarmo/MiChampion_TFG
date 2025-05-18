<?php

    class Conexion{
        private $host="localhost";
        private $port = "3306";
        // private $port = "3000";
        private $db="MiChampion_TFG";
        private $user="lydia";
        private $password="lydia";
        private $conexion;

        public function __construct() {
            try {
                $this->conexion = new PDO(
                    "mysql:host=$this->host;port=$this->port;dbname=$this->db",$this->user,$this->password,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                // echo "✅ Conexión exitosa en el puerto $this->port";
            } catch (PDOException $e) {
                die("❌ Error de conexión: " . $e->getMessage());
            }
        }

        public function getConexion() {
            return $this->conexion;
        }
    }

?>