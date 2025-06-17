<?php

class Curso
{
    public ?int $id = null;
    public ?string $titulo = null;
    public ?string $descricao = null;
    public ?int $professor_id = null;
    public ?string $codigo_turma = null;

    private function generateCode(PDO $pdo, int $length = 6): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
        } while ($this->findByCode($pdo, $code));
        
        return $code;
    }

    public function create(PDO $pdo): bool
    {
        $this->codigo_turma = $this->generateCode($pdo);
        $stmt = $pdo->prepare("INSERT INTO cursos (titulo, descricao, professor_id, codigo_turma) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->titulo, $this->descricao, $this->professor_id, $this->codigo_turma]);
    }

    public function getAll(PDO $pdo): array
    {
        $stmt = $pdo->query("
            SELECT c.*, u.nome as professor_nome 
            FROM cursos c
            JOIN usuarios u ON c.professor_id = u.id
            ORDER BY c.titulo ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(PDO $pdo, int $id): ?array
    {
        $stmt = $pdo->prepare("
            SELECT c.*, u.nome as professor_nome
            FROM cursos c
            JOIN usuarios u ON c.professor_id = u.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function findByCode(PDO $pdo, string $code): ?array
    {
        $stmt = $pdo->prepare("SELECT * FROM cursos WHERE codigo_turma = ?");
        $stmt->execute([$code]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function findByProfessorId(PDO $pdo, int $professor_id): array
    {
        $stmt = $pdo->prepare("SELECT c.*, u.nome as professor_nome FROM cursos c JOIN usuarios u ON c.professor_id = u.id WHERE c.professor_id = ? ORDER BY c.titulo ASC");
        $stmt->execute([$professor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(PDO $pdo): bool
    {
        $stmt = $pdo->prepare("UPDATE cursos SET titulo = ?, descricao = ? WHERE id = ? AND professor_id = ?");
        return $stmt->execute([$this->titulo, $this->descricao, $this->id, $this->professor_id]);
    }

    public function delete(PDO $pdo, int $id, int $professor_id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM cursos WHERE id = ? AND professor_id = ?");
        return $stmt->execute([$id, $professor_id]);
    }

    public function getMateriais(PDO $pdo, int $curso_id, int $user_id, string $user_profile): array
    {
        $materialModel = new Material();
        return $materialModel->getByCursoId($pdo, $curso_id, $user_id, $user_profile);
    }

    public function countAll(PDO $pdo): int {
        $stmt = $pdo->query("SELECT COUNT(id) FROM cursos");
        return (int) $stmt->fetchColumn();
    }

    public function getLatest(PDO $pdo, int $limit = 3): array {
        $stmt = $pdo->query("
            SELECT c.*, u.nome as professor_nome 
            FROM cursos c
            JOIN usuarios u ON c.professor_id = u.id
            ORDER BY c.data_criacao DESC
            LIMIT " . $limit
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
