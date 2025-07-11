<?php

class Usuario {
    public ?int $id = null;
    public ?string $nome = null;
    public ?string $email = null;
    public ?string $senha_hash = null;
    public ?string $perfil = null;
    public ?string $cpf = null;
    public ?string $data_nascimento = null;

    public function create(PDO $pdo): bool
    {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, perfil, cpf, data_nascimento) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $this->senha_hash = password_hash($this->senha_hash, PASSWORD_DEFAULT);
        return $stmt->execute([$this->nome, $this->email, $this->senha_hash, $this->perfil, $this->cpf, $this->data_nascimento]);
    }

    public function findById(PDO $pdo, int $id): ?array
    {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function findByEmail(PDO $pdo, string $email): ?array
    {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function update(PDO $pdo): bool
    {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ?, cpf = ?, data_nascimento = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nome, $this->email, $this->perfil, $this->cpf, $this->data_nascimento, $this->id]);
    }

    public function updatePassword(PDO $pdo): bool
    {
        $sql = "UPDATE usuarios SET senha_hash = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $this->senha_hash = password_hash($this->senha_hash, PASSWORD_DEFAULT);
        return $stmt->execute([$this->senha_hash, $this->id]);
    }

    public function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function validatePasswordReset(PDO $pdo, string $cpf, string $data_nascimento): ?array
    {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = ? AND data_nascimento = ?");
        $stmt->execute([$cpf, $data_nascimento]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getCursosInscritos(PDO $pdo, int $aluno_id): array
    {
        $stmt = $pdo->prepare("
            SELECT c.*, u.nome as professor_nome
            FROM inscricoes_cursos ic
            JOIN cursos c ON ic.curso_id = c.id
            JOIN usuarios u ON c.professor_id = u.id
            WHERE ic.aluno_id = ?
            ORDER BY c.titulo ASC
        ");
        $stmt->execute([$aluno_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isProfessor(): bool
    {
        return isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'professor';
    }

    public function countByProfile(PDO $pdo, string $perfil): int {
        $stmt = $pdo->prepare("SELECT COUNT(id) FROM usuarios WHERE perfil = ?");
        $stmt->execute([$perfil]);
        return (int) $stmt->fetchColumn();
    }
}
