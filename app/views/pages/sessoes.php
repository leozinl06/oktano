<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>
    
    <main class="pagina">
        <div class="container">
            <div class="pagina__cabecalho">
                <div>
                    <h1>Sessões de Treino</h1>
                    <p>Acompanhe o histórico de treinos finalizados pelos seus alunos.</p>
                </div>
            </div>

            <?php if (empty($historico)): ?>
                <div class="card estado-vazio">
                    <i class="ph ph-calendar-blank"></i>
                    <h3>Nenhuma sessão registrada</h3>
                    <p>Assim que seus alunos finalizarem os treinos, o histórico aparecerá aqui.</p>
                </div>
            <?php else: ?>
                <div>
                    <?php foreach ($historico as $alunoId => $aluno): ?>
                        <div class="aluno-item">
                            <!-- Cabeçalho Acordeão do Aluno -->
                            <button type="button" class="aluno-item__cabecalho js-sessoes-accordion" aria-expanded="false">
                                <span class="aluno-item__identidade">
                                    <span class="aluno-item__avatar"><?= strtoupper(substr($aluno['nome'], 0, 1)) ?></span>
                                    <span>
                                        <span class="aluno-item__nome"><?= htmlspecialchars($aluno['nome']) ?></span>
                                    </span>
                                </span>
                                <i class="ph ph-caret-down aluno-item__chevron"></i>
                            </button>
                            
                            <!-- Corpo Acordeão do Aluno -->
                            <div class="aluno-item__corpo">
                                <div class="aluno-item__conteudo">
                                    <div style="padding: var(--espaco-4) 0;">
                                        
                                        <!-- Lista de Fichas do Aluno -->
                                        <?php foreach ($aluno['fichas'] as $fichaId => $ficha): ?>
                                            <div class="historico-ficha">
                                                <h3 class="historico-ficha__titulo">Ficha: <?= htmlspecialchars($ficha['titulo']) ?></h3>
                                                
                                                <!-- Lista de Treinos da Ficha -->
                                                <?php foreach ($ficha['treinos'] as $treinoId => $treino): ?>
                                                    <div class="historico-treino">
                                                        <h4 class="historico-treino__titulo"><?= htmlspecialchars($treino['titulo']) ?></h4>
                                                        
                                                        <div class="tabela-wrapper">
                                                            <table class="tabela">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Data da Realização</th>
                                                                        <th>Tempo de Duração</th>
                                                                        <th>Nível de Fadiga</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($treino['sessoes'] as $sessao): ?>
                                                                        <tr>
                                                                            <td data-rotulo="Data"><?= $sessao['data'] ?></td>
                                                                            <td data-rotulo="Duração"><?= $sessao['duracao'] ?></td>
                                                                            <td data-rotulo="Fadiga">
                                                                                <span class="badge badge--ativa">Nível <?= $sessao['fadiga'] ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script type="module" src="<?= BASE_URL ?>/assets/js/sessoes.js"></script>
</body>
</html>