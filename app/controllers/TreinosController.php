<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/TreinoExercicio.php';
require_once __DIR__ . '/../models/Treino.php';

class TreinosController extends BaseController{
    private $db;
    private $fichaTreinoModel;
    private $praticanteModel;
    private $treinoModel;
    private $treinoExercicioModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->conectar();
        $this->fichaTreinoModel = new FichaTreino($this->db);
        $this->praticanteModel = new Praticante($this->db);
        $this->treinoModel = new Treino($this->db);
        $this->treinoExercicioModel = new TreinoExercicio($this->db);
    }

    private function buscarFichaAutorizada(int $id_personal): array {
        $id_ficha = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (!$id_ficha) {
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Ficha não especificada.');
        }

        $ficha = $this->fichaTreinoModel->buscarPorId($id_ficha);
        $aluno = $ficha ? $this->praticanteModel->buscarPorId($ficha['id_praticante']) : false;

        if (!$ficha || !$aluno || (int)$aluno['id_personal'] !== $id_personal) {
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Ficha inválida ou não autorizada.');
        }

        return [$ficha, $aluno];
    }

    private function alterarStatusFicha(string $novoStatus, string $urlPadrao, string $msgSucesso, string $msgErro): void {
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: $urlPadrao;

            if ($this->fichaTreinoModel->alterarStatusArquivamento($id_ficha, $novoStatus)) {
                $this->redirecionarComResultado($url_retorno, true, $msgSucesso);
            } else {
                $this->redirecionarComResultado($url_retorno, false, $msgErro);
            }
        }
    }

    public function index(){
        $id_personal = $this->exigirAutenticacao('personal');
        $fichas = $this->fichaTreinoModel->buscarFichasPorPersonal($id_personal);
        $resultado = $this->obterResultadoSessao();

        require_once __DIR__ . '/../views/pages/treinos.php';
    }

    //-----------------FICHA-----------------

    public function novaFicha(){
        $id_personal = $this->exigirAutenticacao('personal');
        $id_aluno = filter_input(INPUT_GET, 'aluno_id', FILTER_SANITIZE_NUMBER_INT);

        if (!$id_aluno) {
            $this->redirecionarComResultado('/oktano/public/alunos', false, 'Aluno não especificado.');
        }

        $aluno = $this->praticanteModel->buscarPorId($id_aluno);
        if (!$aluno || (int)$aluno['id_personal'] !== $id_personal) {
            $this->redirecionarComResultado('/oktano/public/alunos', false, 'Aluno inválido ou não autorizado.');
        }

        $resultado = $this->obterResultadoSessao();
        require_once __DIR__ . '/../views/pages/nova_ficha.php';
    }

    public function criarFicha(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_aluno = filter_input(INPUT_POST, 'id_aluno', FILTER_SANITIZE_NUMBER_INT);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $url = '/oktano/public/treinos/nova-ficha?aluno_id=' . $id_aluno;

            if (empty($titulo)) {
                $this->redirecionarComResultado($url, false, 'Título é obrigatório.');
            }

            $id_nova_ficha = $this->fichaTreinoModel->cadastrar($id_aluno, $titulo, $descricao, 'rascunho');
            if ($id_nova_ficha) {
                $this->redirecionarComResultado('/oktano/public/treinos/detalhes?id=' . $id_nova_ficha, true, 'Ficha criada com sucesso!');
            } else {
                $this->redirecionarComResultado($url, false, 'Erro ao criar a ficha.');
            }
        }
    }

    public function editarFicha(){
        $id_personal = $this->exigirAutenticacao('personal');
        [$ficha, $aluno] = $this->buscarFichaAutorizada($id_personal);

        $treinosDaFicha = $this->treinoModel->buscarPorFicha($ficha['id']);
        $podeAtivar = count($treinosDaFicha) > 0;
        $resultado = $this->obterResultadoSessao();
        $url_origem = $_SERVER['HTTP_REFERER'] ?? '/oktano/public/treinos';

        require_once __DIR__ . '/../views/pages/editar_ficha.php';
    }

    public function arquivados(){
        $id_personal = $this->exigirAutenticacao('personal');
        $fichas = $this->fichaTreinoModel->buscarFichasArquivadasPorPersonal($id_personal);
        $resultado = $this->obterResultadoSessao();

        require_once __DIR__ . '/../views/pages/treinos_arquivados.php';
    }

    public function arquivarFicha() {
        $this->alterarStatusFicha('arquivada', '/oktano/public/treinos', 'Ficha arquivada com sucesso!', 'Falha ao arquivar a ficha.');
    }

    public function desarquivarFicha() {
        $this->alterarStatusFicha('rascunho', '/oktano/public/treinos/arquivados', 'Ficha restaurada para rascunho com sucesso!', 'Falha ao restaurar a ficha.');
    }

    public function excluirFicha(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos';

            if (empty($id_ficha)) {
                $this->redirecionarComResultado($url_retorno, false, 'ID da ficha não fornecido para exclusão.');
            }

            if ($this->fichaTreinoModel->excluir($id_ficha)) {
                $this->redirecionarComResultado($url_retorno, true, 'Ficha excluída permanentemente com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao excluir a ficha. Tente novamente.');
            }
        }
    }

    public function atualizarFicha(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos';
            $url_erro = '/oktano/public/treinos/editar-ficha?id=' . $id_ficha;

            if (empty($titulo) || empty($status) || empty($id_ficha)) {
                $this->redirecionarComResultado($url_erro, false, 'Título e status são obrigatórios.');
            }

            if ($status === 'ativa' && empty($this->treinoModel->buscarPorFicha($id_ficha))) {
                $this->redirecionarComResultado($url_erro, false, 'A ficha precisa ter ao menos um treino.');
            }

            if ($this->fichaTreinoModel->atualizar($id_ficha, $titulo, $descricao, $status)) {
                $this->redirecionarComResultado($url_retorno, true, 'Ficha atualizada com sucesso!');
            } else {
                $this->redirecionarComResultado($url_erro, false, 'Erro ao atualizar a ficha.');
            }
        }
    }

    public function detalhesFicha(){
        $id_personal = $this->exigirAutenticacao('personal');
        [$ficha, $aluno] = $this->buscarFichaAutorizada($id_personal);

        $treinosBrutos = $this->treinoModel->buscarPorFicha($ficha['id']);
        $treinos = [];
        foreach ($treinosBrutos as $t) {
            $t['exercicios'] = $this->treinoExercicioModel->buscarPorTreino($t['id']);
            $treinos[] = $t;
        }

        $resultado = $this->obterResultadoSessao();
        require_once __DIR__ . '/../views/pages/detalhes_ficha.php';
    }

    private function processarNovaOrdem(BaseModel $model, array $itensOrdem): bool {
        $sucesso = true;
        foreach ($itensOrdem as $index => $idItem) {
            if (!$model->atualizarOrdem($idItem, $index + 1)) {
                $sucesso = false;
            }
        }
        return $sucesso;
    }

    public function reordenarTreinos(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $ordem_treinos = $_POST['treinos_ordem'] ?? [];
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos/detalhes?id=' . $id_ficha;

            if (empty($ordem_treinos) || empty($id_ficha)) {
                $this->redirecionarComResultado($url_retorno, false, 'Nenhuma ordem recebida.');
            }

            if ($this->processarNovaOrdem($this->treinoModel, $ordem_treinos)) {
                $this->redirecionarComResultado($url_retorno, true, 'Ordem dos treinos atualizada com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao salvar a nova ordem de alguns treinos.');
            }
        }
    }

    public function reordenarExercicios(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $id_treino = filter_input(INPUT_POST, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
            $ordem_exercicios = $_POST['exercicios_ordem'] ?? [];
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos/detalhes?id=' . $id_ficha;

            if (empty($ordem_exercicios) || empty($id_treino)) {
                $this->redirecionarComResultado($url_retorno, false, 'Nenhuma ordem de exercícios recebida.');
            }

            if ($this->processarNovaOrdem($this->treinoExercicioModel, $ordem_exercicios)) {
                $this->redirecionarComResultado($url_retorno, true, 'Ordem dos exercícios atualizada com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao salvar a nova ordem de alguns exercícios.');
            }
        }
    }

    //-----------------TREINO DA FICHA-----------------
    
    public function adicionarTreino(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos/detalhes?id=' . $id_ficha;

            if (empty($titulo) || empty($id_ficha)) {
                $this->redirecionarComResultado($url_retorno, false, 'O título do treino é obrigatório.');
            }

            if ($this->treinoModel->cadastrar($id_ficha, $titulo, $descricao)) {
                $this->redirecionarComResultado($url_retorno, true, 'Treino adicionado com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao adicionar o treino. Tente novamente.');
            }
        }
    }

    public function editarTreino(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_treino = filter_input(INPUT_POST, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            $titulo = trim($_POST['titulo'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos/detalhes?id=' . $id_ficha;

            if (empty($titulo) || empty($id_treino)) {
                $this->redirecionarComResultado($url_retorno, false, 'O título do treino é obrigatório.');
            }

            if ($this->treinoModel->atualizar($id_treino, $titulo, $descricao)) {
                $this->redirecionarComResultado($url_retorno, true, 'Treino atualizado com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao atualizar o treino.');
            }
        }
    }

    public function excluirTreino(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_treino = filter_input(INPUT_POST, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos';

            if (empty($id_treino)) {
                $this->redirecionarComResultado($url_retorno, false, 'ID do treino não fornecido.');
            }

            if ($this->treinoModel->excluir($id_treino)) {
                $this->redirecionarComResultado($url_retorno, true, 'Treino excluído com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao excluir o treino.');
            }
        }
    }

    public function excluirExercicio(){
        $this->exigirAutenticacao('personal');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_treino_exercicio = filter_input(INPUT_POST, 'id_treino_exercicio', FILTER_SANITIZE_NUMBER_INT);
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos';

            if (empty($id_treino_exercicio)) {
                $this->redirecionarComResultado($url_retorno, false, 'ID do exercício não fornecido.');
            }

            $exercicio = $this->treinoExercicioModel->buscarPorId($id_treino_exercicio);
            if (!$exercicio) {
                $this->redirecionarComResultado($url_retorno, false, 'Exercício não encontrado neste treino.');
            }

            if ($this->treinoExercicioModel->excluir($id_treino_exercicio)) {
                $exerciciosRestantes = $this->treinoExercicioModel->buscarPorTreino($exercicio['id_treino']);
                if (!empty($exerciciosRestantes)) {
                    $idsRestantes = array_column($exerciciosRestantes, 'id');
                    $this->processarNovaOrdem($this->treinoExercicioModel, $idsRestantes);
                }

                $this->redirecionarComResultado($url_retorno, true, 'Exercício excluído do treino com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao excluir o exercício.');
            }
        }
    }
}