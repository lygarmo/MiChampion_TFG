<?php

    class Hamburguesas {
        private $db;
        
        public function __construct($db) {
            $this->db = $db;
        }

        public function obtenerTodasLasBurgers() {
            $stmt = $this->db->prepare("SELECT * FROM burgers");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerBurgerPorId($id) {
            $stmt = $this->db->prepare("SELECT * FROM burgers WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerAlergenosDeTodasLasBurgers() {
            $stmt = $this->db->prepare("
                SELECT ab.id_burger AS burger_id, a.nombre, a.icono
                FROM alergenos a
                JOIN alergenos_burgers ab ON a.id = ab.id_alergeno");
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $resultado = [];

            foreach ($datos as $fila) {
                $id = $fila['burger_id'];
                $alergeno = [
                    'nombre' => $fila['nombre'],
                    'icono' => $fila['icono']
                ];

                if (!isset($resultado[$id])) {
                    $resultado[$id] = [];
                }
                $resultado[$id][] = $alergeno;
            }
            return $resultado;
        }

        // Alergenos todas las burgers
        public function obtenerAlergenosDeBurger($burgerId) {
            $stmt = $this->db->prepare("
                SELECT a.nombre
                FROM alergenos a
                JOIN alergenos_burgers ab ON a.id = ab.alergeno_id");
            $stmt->execute([$burgerId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Alergenos por cada burger
        public function obtenerAlergenosPorBurger($burgerId) {
            $stmt = $this->db->prepare("
            SELECT a.nombre
            FROM alergenos a
            JOIN alergenos_burgers ab ON a.id = ab.alergeno_id
            WHERE ab.burger_id = ?");
            $stmt->execute([$burgerId]);

            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Recuento burgers probadas
        public function contarBurgersProbadasPorUsuario($usuarioId) {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM burgers_probadas 
                WHERE id_usuario = ?
            ");
            $stmt->execute([$usuarioId]);
            return (int) $stmt->fetchColumn();
        }

        public function contarTotalBurgers() {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM burgers");
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        }

        public function obtenerBurgersDestacadas() {
            $stmt = $this->db->prepare("SELECT * FROM burgers WHERE destacado = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>