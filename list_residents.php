<?php
require_once 'assets/php/db_connect.php';
session_start();

$email = $_SESSION["email"];
$email = mysqli_real_escape_string($conn, $email); // escapando caracteres especiais

$sql = "SELECT * FROM usuario LEFT JOIN apartamento ON ap_id = usu_ap_id WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);

$usu_tipo = $dados["usu_tipo"];

// // redirecionando para a página apropriada
if ($usu_tipo != "sindico" && $usu_tipo != "admin") {
    header("Location: index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Lista Moradores - CM</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cssIcons.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


</head>

<body>
    <!-- Pagina de Tabela de moradores/Sindicos -->
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion  p-0 d-none d-md-block"
            style="color: var(--bs-black);background: #353535;width: 250px;">
            <div class="container-fluid d-flex flex-column p-1">
                <div class="text-center">
                    <img src="assets/img/logo.png" width="180" height="180"
                        style="margin-top: 13px;padding-top: 0px;border-radius: 60%;" class="rounded-circles">
                </div>
                <hr class="sidebar-divider my-3">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item">
                        <a class="nav-link active d-flex align-items-center" href="dashboard_manager.php">
                            <i class="gg-home-alt me-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="profile_manager.php">
                            <i class="gg-profile me-2"></i>
                            <span>Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="list_residents.php">
                            <i class="gg-database me-2"></i>
                            <span>Moradores</span>
                        </a>
                    </li>

                    <div class="mt-5">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>"
                                    alt="Imagem do perfil do usuário" class="rounded-circle me-2" width="40"
                                    height="40">

                                <span>
                                    <?php echo $dados['usu_nome'] ?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile_manager.php">Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="assets/PHP/logout.php">Sair</a>
                            </div>
                        </li>
                    </div>
                </ul>
            </div>
        </nav>



        <div class="d-flex flex-column" id="content-wrapper">
            <div class="container-fluid mt-0 ">
                <div class="d-flex justify-content-end mb-0">
                    <nav class="d-none d-sm-block">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle btn-sm" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>"
                                        alt="Imagem do perfil do usuário" class="rounded-circle me-2" width="60"
                                        height="60">

                                </a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                                    aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="assets/PHP/logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="d-md-none d-flex justify-content-center align-items-center mt-3 ">
                    <a href="dashboard_manager.php"><i class="gg-home mx-2" id=></i></a>
                    <label>Voltar ao index</label>

                </div>
                <div class="container-fluid mt-5 mb-5">

                    <h3 class="text-center ">Lista Moradores</h3>
                </div>


                <div class="mb-4">
                    <form method="POST" action="list_residents.php" id="form-pesquisa">
                        <div class="input-group">
                            <input class="bg-light form-control border-0 small " name="nome" id="nome" type="text"
                                placeholder="Pesquisar..." >
                            <button class="btn btn-primary py-0" type="submit" name="btn-pesquisa" id="btn-pesquisa"
                                style="background: #6b6b6b;"><i class="gg-search"></i></button>
                        </div>
                    </form>
                    <div id="resultado-pesquisa"></div>
                </div>
                <!-- scroll aqui -->
                <div class="container-fluid  mt-0 mb-0 overflow-auto" style="max-height:450px;">
                    <div class="card" id="TableSorterCard">
                        <div class="card-header py-3">
                            <div class="row table-topper align-items-center">
                                <div class="col-12 col-sm-5 col-md-6 text-start" style="margin: 0px;padding: 5px 15px;">
                                    <h6 class="text-primary m-0 fw-bold">Moradores Cadastrados</h6>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-0 mb-0" id="dataTable" role="grid"
                            aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Bloco</th>
                                        <th>Apto</th>
                                        <th> <i class="gg-math-plus" data-bs-toggle="modal"
                                                data-bs-target="#includeModal"></i></th>
                                    </tr>
                                </thead>

                        </div>

                        <?php

                        require_once 'assets/PHP/db_connect.php';

                        if (isset($_POST['nome']) && $_POST['nome'] != null) {
                            $busca = $_POST['nome'];
                        } else {
                            $busca = '';
                        }

                        $sql = "SELECT usu_id, usu_nome, usu_email, usu_cpf, ap_bloco, ap_num
                        FROM usuario 
                        LEFT JOIN apartamento ON apartamento.ap_id = usuario.usu_ap_id 
                        WHERE usu_tipo = 'morador' AND usu_nome LIKE '%$busca%' 
                        GROUP BY usu_id";


                        $resultado = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($resultado)) {
                            while ($dados = mysqli_fetch_array($resultado)) {
                                ?>
                                <div class="table-responsive table mt-0 mb-0" id="dataTable" role="grid"
                                    aria-describedby="dataTable_info">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img class="rounded-circle me-2" width="40" height="40"
                                                    src="assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>">
                                                <?php echo $dados['usu_nome'] ?>

                                            </td>
                                            <td>

                                                <?php echo $dados['usu_email'] ?>
                                            </td>
                                            <td>
                                                <?php echo $dados['ap_bloco'] ?>
                                            </td>
                                            <td>
                                                <?php echo $dados['ap_num'] ?>
                                            </td>

                                            <td>
                                                <a href="assets/PHP/exclude_resident.php?id=<?php echo $dados['usu_id']; ?>"
                                                    class="gg-trash"></a>
                                            </td>
                                        </tr>

                                    </tbody>


                                </div>
                                <?php
                            }
                        } else {
                            echo "<br><p style='color: red;'>Nenhum morador encontrado.</p>";
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="assets/PHP/include_resident_and_manager.php" method="POST" id="form">
        <div class="modal fade p-5 " id="includeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color:#FFFFFF ;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Morador
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Insira seu nome" name="nome">
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
                        <input type="password" class="form-control" id="password" placeholder="Insira sua senha"
                            name="password">
                    </div>

                    <input type="hidden" name="ocupado" value="sim">
                    <div class="col-md-20">
                        <label for="selectTipo" class="form-label">Tipo</label>
                        <select class="form-select" id="selectTipo" name="tipo">
                            <option value="morador">Morador</option>
                        </select>
                    </div>
                    <div class="col-md-20">
                        <label for="selectBloco" class="form-label">Bloco</label>
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
                    <div class="col-md-20">
                        <label for="selectApto" class="form-label">Apartamento</label>
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
                    <br><br><br>
                    <button class="btn btn-secondary" id="btnEnviar">Enviar</button>
                </div>

            </div>
        </div>
    </form>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
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



</body>

</html>