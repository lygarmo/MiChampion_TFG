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
                JOIN alergenos_burgers ab ON a.id = ab.id_alergeno");
            $stmt->execute([$burgerId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Alergenos por cada burger
        public function obtenerAlergenosPorBurger($burgerId) {
            $stmt = $this->db->prepare("
            SELECT a.nombre, a.icono
            FROM alergenos a
            JOIN alergenos_burgers ab ON a.id = ab.id_alergeno
            WHERE ab.id_burger = ?");
            $stmt->execute([$burgerId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        public function probada($usuarioId, $burgerId) {
            $stmt = $this->db->prepare("SELECT 1 FROM burgers_probadas WHERE id_usuario = :usuarioId AND id_burger = :burgerId LIMIT 1");
            $stmt->execute([
                ':usuarioId' => $usuarioId,
                ':burgerId' => $burgerId
            ]);
            return $stmt->fetchColumn() !== false;
        }

        public function marcarComoProbada($usuarioId, $burgerId) {
            $stmt = $this->db->prepare("INSERT INTO burgers_probadas (id_burger, id_usuario) VALUES (:burgerId, :usuarioId)");
            return $stmt->execute([
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
        }

        public function desmarcarComoProbada($usuarioId, $burgerId) {
            $stmt = $this->db->prepare("DELETE FROM burgers_probadas WHERE id_burger = :burgerId AND id_usuario = :usuarioId");
            return $stmt->execute([
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
        }

        public function guardarAtributoFavorito($usuarioId, $burgerId, $atributo) {
            $stmt = $this->db->prepare("UPDATE burgers_probadas SET atributo_favorito = :atributo WHERE id_burger = :burgerId AND id_usuario = :usuarioId");
            return $stmt->execute([
                ':atributo' => $atributo,
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
        }

        public function obtenerAtributoFavorito($usuarioId, $burgerId) {
            $stmt = $this->db->prepare("SELECT atributo_favorito FROM burgers_probadas WHERE id_burger = :burgerId AND id_usuario = :usuarioId");
            $stmt->execute([
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
            return $stmt->fetchColumn();
        }

        public function guardarValoracion($usuarioId, $burgerId, $valoracion) {
            $stmt = $this->db->prepare("UPDATE burgers_probadas SET calificacion = :valoracion WHERE id_burger = :burgerId AND id_usuario = :usuarioId");
            return $stmt->execute([
                ':valoracion' => $valoracion,
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
        }

        public function obtenerValoracion($usuarioId, $burgerId) {
            $stmt = $this->db->prepare("SELECT calificacion FROM burgers_probadas WHERE id_burger = :burgerId AND id_usuario = :usuarioId");
            $stmt->execute([
                ':burgerId' => $burgerId,
                ':usuarioId' => $usuarioId
            ]);
            return $stmt->fetchColumn(); // devuelve el número directamente
        }

        public function obtenerTodosLosAlergenos(){
            $stmt = $this->db->prepare("SELECT * FROM alergenos");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerBurgersSinAlergenos(array $idsAlergenos): array {
            if (empty($idsAlergenos)) {
                return $this->obtenerTodasLasBurgers();
            }

            $placeholders = implode(',', array_fill(0, count($idsAlergenos), '?'));

            // Consulta: selecciona burgers que NO tienen ninguno de los alérgenos seleccionados
            $stmt = $this->db->prepare("
                SELECT b.*
                FROM burgers b
                WHERE b.id NOT IN (
                    SELECT ab.id_burger
                    FROM alergenos_burgers ab
                    WHERE ab.id_alergeno IN ($placeholders))");
            $stmt->execute($idsAlergenos);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function saberBurgersProbadas($idUsuario){
            $stmt = $this->db->prepare("
                SELECT b.nombre, b.descripcion, b.imagen, b.logo, b.destacado, bp.calificacion, bp.atributo_favorito
                FROM burgers_probadas bp
                JOIN burgers b on bp.id_burger=b.id
                WHERE bp.id_usuario = :idUsuario");
            $stmt->execute([':idUsuario' => $idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


    }
?>