<?php

class AtividadeAtribuicao {

    public function create(PDO $pdo, int $material_id, int $aluno_id): bool {
        $sql = "INSERT INTO atividade_atribuicoes (material_id, aluno_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$material_id, $aluno_id]);
    }

    public function deleteByMaterial(PDO $pdo, int $material_id): bool {
        $sql = "DELETE FROM atividade_atribuicoes WHERE material_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$material_id]);
    }

    public function findAlunosByMaterial(PDO $pdo, int $material_id): array {
        $sql = "SELECT aluno_id FROM atividade_atribuicoes WHERE material_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$material_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}