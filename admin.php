<?php
require_once 'assets/php/db_connect.php';
session_start();

$email = $_SESSION["email"];

$sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);


$dados = mysqli_fetch_array($resultado);

$usu_tipo = $dados["usu_tipo"];
$primeiroLogin = isset($dados["usu_primeiroLogin"]) ? $dados["usu_primeiroLogin"] : 0;
// redirecionando para a página apropriada
// verificando se é o primeiro login
if ($primeiroLogin == true) {
    // definindo a variável de sessão "primeiroLogin" como true
    $_SESSION["primeiroLogin"] = true;
}

if ($usu_tipo != "admin") {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>CM - Admin Painel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #EEF1F4;
        }
    </style>
</head>

<body class="bg-light">



    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Painel </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="assets/PHP/dashboard_manager.php">Síndico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assets/PHP/dashboard_resident.php">Morador</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="assets/PHP/logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header with image -->
    <header class="p-1 text-center bg-light">
        <img src="assets/img/logo.png" class="rounded-circle" alt="Admin Image" width="140px"><br><br>
        <?php
        // Obtendo o nome do usuário logado
        $nome = $dados["usu_nome"];

        // Obtendo a hora atual
        $agora = date('H');


        if ($agora >= 6 && $agora < 12) {
            $saudacao = "Bom dia";
        } elseif ($agora >= 12 && $agora <= 18) {
            $saudacao = "Boa tarde";
        } else {
            $saudacao = "Boa noite";
        }
        echo "<h3 class='text-dark mb-0'>{$saudacao}, {$nome}!</h3>";
        ?>
    </header>


    <!-- MODAL PARA CADASTRAR SINDICO -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroModalLabel">Cadastro de Sindico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Admin cadastra o sindico -->
                    <form action="assets/PHP/include_resident_and_manager.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" placeholder="Digite seu nome" name="nome"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="email" placeholder="Insira seu email"
                                    name="email">
                                <div class="input-group-append">
                                    <span class="input-group-text">@condominium.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Digite sua senha" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Usuário</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="" disabled></option>Selecione Abaixo</option>
                                <option value="sindico">Síndico</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bloco" class="form-label">Bloco</label>
                            <select class="form-select " id="selectBloco" name="bloco">
                                <option hidden>Selecione uma opção</option>
                                <?php
                                $sql = "SELECT DISTINCT `ap_bloco` FROM `apartamento` WHERE ap_ocupado LIKE 'nao'";
                                $resultado = mysqli_query($conn, $sql);
                                while ($dados = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $dados['ap_bloco'] . '">' . $dados['ap_bloco'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="apto" class="form-label">Apartamento</label>
                            <select class="form-select " id="selectApto" name="apto">
                                <option hidden>Selecione uma opção</option>
                                <?php
                                $sql = "SELECT `ap_id`,`ap_num`,`ap_bloco` FROM `apartamento` WHERE ap_ocupado LIKE 'nao'";
                                $resultado = mysqli_query($conn, $sql);
                                while ($dados = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $dados['ap_id'] . '" data-bloco="' . $dados['ap_bloco'] . '">' . $dados['ap_num'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA VER SINDICOS CADASTRADOS -->


    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Dados Sindicos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action=""></form>
                    <div class="container-fluid">
                        <?php
                        $sql = "SELECT usu_id, usu_nome, usu_tipo, ap_bloco, ap_num FROM usuario JOIN apartamento ON usuario.usu_ap_id = apartamento.ap_id WHERE usuario.usu_tipo = 'sindico'";
                        $resultado = mysqli_query($conn, $sql);

                        while ($dados = mysqli_fetch_assoc($resultado)) {
                            ?>
                            <div class="row">
                                <div class="col-md-6">Nome:</div>
                                <div class="col-md-6">
                                    <?php echo $dados["usu_nome"] ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">Tipo de usuário:</div>
                                <div class="col-md-6">
                                    <?php echo $dados["usu_tipo"] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Bloco:</div>
                                <div class="col-md-6">
                                    <?php echo $dados["ap_bloco"] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Apartamento:</div>
                                <div class="col-md-6">
                                    <?php echo $dados["ap_num"] ?>
                                </div>
                            </div><br><br>
                            <a type="submit"
                                href="assets/PHP/exclude_manager_for_admin.php?id=<?php echo $dados['usu_id']; ?>"
                                class="btn btn-danger">Excluir usuário</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>


    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-sm">
                    <img src="assets/img/adminGif.gif" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Síndico</h5>
                        <p class="card-text">Aqui Voce podera alterar cadastrar os sindicos do Condominio</p>
                        <a href="dashboard_manager.php" class="btn btn-secondary">Abrir</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 my-md-0 my-2">
                <div class="card card-sm">
                    <img src="assets/img/moradorGif.gif" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Morador</h5>
                        <p class="card-text">Aqui voce podera acessar a pagina de morador para ajustar possiveis bugs.
                        </p>
                        <a href="dashboard_resident.php" class="btn btn-secondary">Abrir</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card card-sm">
                    <img src="assets/img/sindico.gif" class="card-img-top" alt="Card Image">
                    <div class="card-body">
                        <h5 class="card-title">Cadastrar Sindico</h5>
                        <p class="card-text">Aqui voce pode Cadastrar um Sindico</p>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#cadastroModal">Cadastro</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#userModal">Ver Sindicos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL QUE PARA ALTERAÇÃO DE DADOS CASO SEJA O PRIMEIRO LOGIN DO USUARIO -->

    <div class="modal fade" id="alterar-dados-modal" tabindex="-1" aria-labelledby="alterar-dados-modal-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alterar-dados-modal-label">Alterar dados do usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form action="assets/PHP/first_login_admin.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $dados['usu_id']; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <p>Olá, altere sua senha</p>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="p-3 bg-dark text-white text-center">
        &copy; 2023 Condominium Management
    </footer>


    <!-- SCRIPT PARA APARECER O APARTAMENTO DE ACORDO COM O BLOCO ESCOLHIDO -->
    <script>
        // Seleciona os elementos do DOM
        const selectBloco = document.querySelector('#selectBloco');
        const selectApto = document.querySelector('#selectApto');

        // Cria um objeto com as opções disponíveis para cada bloco
        const optionsPorBloco = {};
        <?php
        $sql = "SELECT `ap_id`,`ap_num`,`ap_bloco` FROM `apartamento` WHERE ap_ocupado LIKE 'nao'";
        $resultado = mysqli_query($conn, $sql);
        while ($dados = mysqli_fetch_array($resultado)) {
            echo 'if (!optionsPorBloco["' . $dados['ap_bloco'] . '"]) optionsPorBloco["' . $dados['ap_bloco'] . '"] = [];';
            echo 'optionsPorBloco["' . $dados['ap_bloco'] . '"].push({id: "' . $dados['ap_id'] . '", num: "' . $dados['ap_num'] . '"});';
        }
        ?>

        // Função para atualizar as opções do select do apartamento com base no bloco selecionado
        function atualizaOpcoesApto() {
            const blocoSelecionado = selectBloco.value;
            const optionsApto = optionsPorBloco[blocoSelecionado] || [];
            selectApto.innerHTML = '<option value="">Selecione uma opção</option>';
            optionsApto.forEach(option => {
                selectApto.innerHTML += '<option value="' + option.id + '">' + option.num + '</option>';
            });
        }

        // Adiciona um listener para o evento de mudança

        selectBloco.addEventListener('change', atualizaOpcoesApto);

        // Chama a função para exibir as opções iniciais
        atualizaOpcoesApto();
    </script>


    <?php
    // verificando se é o primeiro login
    if ($primeiroLogin == true) {
        // incluindo o script para exibir o modal de alterar dados
        echo '<script>var modal = new bootstrap.Modal(document.getElementById("alterar-dados-modal"), {keyboard: false}); modal.show();</script>';

        // atualizando o valor da coluna "usu_primeiroLogin" no banco de dados para false
        $sql = "UPDATE usuario SET usu_primeiroLogin = false WHERE usu_email = '$email'";
        $resultado = mysqli_query($conn, $sql);
    }
    ?>


</body>

</html>