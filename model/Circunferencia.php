<?php
require_once __DIR__ . '/../config/Database.php';

class Circunferencia
{
    private PDO $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    // Listar todas las circunferencias o buscar registros
    public function listar(string $buscar = ''): array
    {
        if ($buscar !== '') {
            $sql = "SELECT * FROM circunferencia
                    WHERE detalle LIKE :buscarDetalle
                       OR CAST(radio AS CHAR) LIKE :buscarRadio
                       OR CAST(area AS CHAR) LIKE :buscarArea
                       OR CAST(perimetro AS CHAR) LIKE :buscarPerimetro
                    ORDER BY id_circunferencia DESC";

            $stmt = $this->pdo->prepare($sql);
            $valorBuscar = '%' . $buscar . '%';

            $stmt->execute([
                'buscarDetalle' => $valorBuscar,
                'buscarRadio' => $valorBuscar,
                'buscarArea' => $valorBuscar,
                'buscarPerimetro' => $valorBuscar,
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = "SELECT * FROM circunferencia
                ORDER BY id_circunferencia DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una circunferencia por su ID
    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM circunferencia
                WHERE id_circunferencia = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        return $registro ?: null;
    }

    // Guardar una nueva circunferencia
    public function guardar(string $detalle, float $radio): bool
    {
        if ($radio <= 0) {
            throw new InvalidArgumentException(
                'El radio debe ser mayor que cero.'
            );
        }

        $area = pi() * pow($radio, 2);
        $perimetro = 2 * pi() * $radio;

        $sql = "INSERT INTO circunferencia
                    (detalle, radio, area, perimetro)
                VALUES
                    (:detalle, :radio, :area, :perimetro)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'detalle' => $detalle,
            'radio' => $radio,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    // Actualizar una circunferencia existente
    public function actualizar(
        int $id,
        string $detalle,
        float $radio
    ): bool {
        if ($radio <= 0) {
            throw new InvalidArgumentException(
                'El radio debe ser mayor que cero.'
            );
        }

        $area = pi() * pow($radio, 2);
        $perimetro = 2 * pi() * $radio;

        $sql = "UPDATE circunferencia
                SET detalle = :detalle,
                    radio = :radio,
                    area = :area,
                    perimetro = :perimetro
                WHERE id_circunferencia = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'detalle' => $detalle,
            'radio' => $radio,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    // Eliminar una circunferencia
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM circunferencia
                WHERE id_circunferencia = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}