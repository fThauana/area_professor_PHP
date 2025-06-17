<?php

class SiteController extends BaseController {

    public function home() {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $cursoModel = new Curso();
        $usuarioModel = new Usuario();

        $viewData = [
            'total_cursos' => $cursoModel->countAll($this->pdo),
            'total_alunos' => $usuarioModel->countByProfile($this->pdo, 'aluno'),
            'total_professores' => $usuarioModel->countByProfile($this->pdo, 'professor'),
            'cursos_recentes' => $cursoModel->getLatest($this->pdo, 3)
        ];

        require __DIR__ . '/../view/site/home.php';
    }

    public function sobre() {
        require __DIR__ . '/../view/site/sobre.php';
    }

    public function listaCursosPublicos() {
        $cursoModel = new Curso();
        $cursos = $cursoModel->getAll($this->pdo);
        require __DIR__ . '/../view/site/lista_cursos.php';
    }
}