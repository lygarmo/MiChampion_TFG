<?php

    class Usuario {
        private $db;
        
        public function __construct($db) {
            $this->db = $db;
        }

        // Método para insertar un nuevo usuario
            public function insertarUsuario($nombre, $apellidos, $email, $password){
                $consulta = "INSERT INTO usuarios (nombre, apellidos, email, password) VALUES 
                    (:nombre, :apellidos, :email, :password)";
                $stmt = $this->db->prepare($consulta);

                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);

                $stmt->execute();
                return $stmt;
            }

        public function existeUsuario($email) {
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch() !== false;
        }

        // Método para autenticar usuario
        public function autenticarUsuario($email, $password){
            $consulta = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
            $stmt = $this->db->prepare($consulta);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();

            // Si el usuario existe, devuelve el resultado
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado; // Devuelve los datos del usuario
            } else {
                return null; // Usuario no encontrado
            }
        }

        public function obtenerIdUsuario($email) {
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetchColumn();
        }

        public function obtenerNombre($email) {
            $stmt = $this->db->prepare("SELECT nombre FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetchColumn();
        }

        public function obtenerDatosUsuarios($usuarioEmail) {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :usuarioEmail");
            $stmt->execute([
                ':usuarioEmail' => $usuarioEmail
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function verificarPassword($usuarioId, $passwordActual) {
            $stmt = $this->conn->prepare("SELECT password FROM usuarios WHERE id = ?");
            $stmt->execute([$usuarioId]);
            $hash = $stmt->fetchColumn();
            return password_verify($passwordActual, $hash);
        }

        public function actualizarPassword($usuarioId, $nuevaPassword) {
            $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            return $stmt->execute([$hash, $usuarioId]);
        }

    }
?>