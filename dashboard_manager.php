<?php
require_once 'assets/php/db_connect.php';
session_start();

$email = $_SESSION["email"];

$sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_email = '$email'";
$resultado = mysqli_query($conn, $sql);
$dados = mysqli_fetch_array($resultado);

$usu_tipo = $dados["usu_tipo"];
$nome = $dados['usu_nome'];
$primeiroLogin = isset($dados["usu_primeiroLogin"]) ? $dados["usu_primeiroLogin"] : 0;
// verificando se é o primeiro login
if ($primeiroLogin == true) {
    // definindo a variável de sessão "primeiroLogin" como true
    $_SESSION["primeiroLogin"] = true;
}
// redirecionando para a página apropriada
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
    <title>Tela Inicial - CM</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cssIcons.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


</head>
<!-- Tela Inicial Sindico -->

<body>
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

        <div class="container-fluid mt-5">





            <div class="d-flex justify-content-end mb-3">
                <!-- Notificações novas -->
                <div class="nav-item dropdown no-arrow">
                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in" id="chamadosInfo"
                        style="max-height: 400px;overflow-y: auto;">
                        <h6 class="dropdown-header bg-secondary">Chamados Abertos</h6>
                    </div>
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        <span class="badge bg-danger badge-counter mx-2 mt-0" id="numeroChamadosAbertos"></span>
                        <i class="gg-bell mt-4 mx-4 text-primary"></i>
                    </a>

                </div>
                <!-- Mensagens Novas -->
                <div class="nav-item dropdown no-arrow">
                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in" id="mensagemInfo"
                        style="max-height: 400px;overflow-y: auto;">
                        <h6 class="dropdown-header bg-secondary">Mensagens</h6>
                    </div>
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        <span class="badge bg-danger badge-counter mx-1 mt-0" id="numeroMensagemNovas"></span>
                        <i class="gg-comment mt-4 mx-3 text-warning"></i>

                    </a>
                </div>
                <nav>

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


            <div class="d-sm-flex justify-content-between align-items-center mt-0 mb-3">

                <?php
                // Obtendo o nome do usuário logado
                $nome = $dados["usu_nome"];

                // Obtendo a hora atual
                $agora = date('H');

                if ($agora >= 6 && $agora <= 12) {
                    $saudacao = "Bom dia";
                } elseif ($agora > 12 && $agora <= 18) {
                    $saudacao = "Boa tarde";
                } else {
                    $saudacao = "Boa noite";
                }
                echo "<h3 class='text-dark mb-0'>{$saudacao}, {$nome}!</h3>";
                ?>
                <!-- //Se o usuario for administrador ele mostrará o botão, caso não o botão não aparecerá -->
                <?php

                if ($usu_tipo === "admin") {
                    ?>
                    <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="admin.php"
                        style="background: #D60D0D;">
                        &nbsp;Voltar ao Index
                    </a>
                    <a class="nav-link d-flex align-items-center" role="button" href="register_condominium.php">
                        <i class="gg-home me-2"></i>
                        <span>Cadastrar Apto/bloco</span>
                    </a>
                    <?php
                } else if ($usu_tipo === 'sindico') {
                    ?>

                        <a class="nav-link d-flex align-items-center" role="button" href="register_condominium.php">
                            <i class="gg-home me-2 text-info"></i>
                            <span>Cadastrar Apto/bloco</span>
                        </a>

                    <?php
                }
                ?>


            </div>

            <div class="row">
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                        <span>Moradores Cadastrados</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0">
                                        <span>
                                            <?php
                                            $NumMoradores = "SELECT COUNT(usu_id) FROM usuario WHERE usu_tipo = 'morador'";
                                            $Usuarios = mysqli_query($conn, $NumMoradores);
                                            $MoradoresRow = mysqli_fetch_array($Usuarios);
                                            $totalMoradores = $MoradoresRow[0];
                                            echo ($totalMoradores);
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary d-md-none d-block"
                                        data-bs-toggle="modal" data-bs-target="#moradoresModal"><i
                                            class="gg-user text-gray-300"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="moradoresModal" tabindex="-1" aria-labelledby="moradoresModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-white">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="moradoresModalLabel">Moradores Cadastrados</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body overflow-auto" style="max-height: 250px;">
                                    <?php
                                    require_once 'assets/PHP/db_connect.php';

                                    // Realiza a consulta SQL para buscar os moradores com o tipo "morador"
                                    $resultado = mysqli_query($conn, "SELECT * FROM usuario WHERE usu_tipo='morador'");

                                    // Verifica se há resultados
                                    if (mysqli_num_rows($resultado) > 0) {
                                        // Exibe o nome de cada morador com um ícone de lixeira para cada um
                                        while ($morador = mysqli_fetch_array($resultado)) {
                                            echo $morador['usu_nome'] . '<br><br>';


                                        }
                                    } else {
                                        // Exibe uma mensagem se não houver resultados
                                        echo '<p style="color:red;">Nenhum morador encontrado.</p>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                        <span class="text-danger">Chamados Abertos</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0">
                                        <span id="novosChamados">
                                            Carregando...
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger d-md-none d-block"
                                        data-bs-toggle="modal" data-bs-target="#chamadosModal"><i
                                            class="gg-mail text-gray-300"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="chamadosModal" tabindex="-1" aria-labelledby="chamadosModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-white">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="chamadosModalLabel">Chamados em aberto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body overflow-auto" style="max-height: 150px;">
                                    <!-- Total de chamados abertos -->
                                    <?php
                                    $NumAb = "SELECT COUNT(cha_id) FROM chamado WHERE cha_status = 'aberto'";
                                    $ChaAb = mysqli_query($conn, $NumAb);
                                    $AbRow = mysqli_fetch_array($ChaAb);
                                    $total_ab = $AbRow[0];
                                    echo "<p>Total de chamados abertos: " . $total_ab . "</p>";
                                    ?>

                                    <!-- Lista de chamados abertos -->
                                    <?php
                                    $sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE usu_tipo = 'morador'";
                                    $resultado = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($resultado) > 0) {
                                        while ($dados = mysqli_fetch_array($resultado)) {
                                            $id_usuario = $dados['usu_id'];
                                            $id_chamado = $dados['cha_id'];
                                            $importancia = $dados['cha_importancia'];
                                            if ($dados['cha_tipo'] != NULL) {
                                                ?>
                                                <li class="list-group-item d-flex align-items-center">
                                                    <i class="gg-bell"></i>&nbsp;&nbsp;
                                                    <a class="fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate"
                                                        href="manager_reply_request.php?chamado_id=<?php echo $id_chamado; ?>">
                                                        <?php echo $dados['usu_nome'] . ' - ' . $dados['cha_tipo'] . ' - ' . $dados['cha_importancia'] ?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <!-- olha -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                        <span class="text-warning">Em andamento</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0">
                                        <span id="emAndamento">
                                            Carregando...
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-warning d-md-none d-block"
                                        data-bs-toggle="modal" data-bs-target="#andamentoModal"><i
                                            class="gg-time  text-gray-300"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="andamentoModal" tabindex="-1" aria-labelledby="andamentoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-white">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="andamentoModalLabel">Em Andamento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <?php
                                    $NumAndamento = "SELECT COUNT(cha_id) FROM chamado WHERE cha_status = 'em_andamento'";
                                    $ChaAndamento = mysqli_query($conn, $NumAndamento);
                                    $AndamentoRow = mysqli_fetch_array($ChaAndamento);
                                    $total_andamento = $AndamentoRow[0];
                                    echo "<p>Total chamados em andamento " . $total_andamento . "</p>";

                                    ?>
                                    <!-- Lista de chamados em andamento -->
                                    <?php
                                    $sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE cha_status = 'em_andamento'";
                                    $resultado = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($resultado) > 0) {
                                        while ($dados = mysqli_fetch_array($resultado)) {
                                            $id_usuario = $dados['usu_id'];
                                            $id_chamado = $dados['cha_id'];
                                            $importancia = $dados['cha_importancia'];
                                            if ($dados['cha_tipo'] != NULL) {
                                                ?>
                                                <li class="list-group-item d-flex align-items-center">
                                                    <i class="gg-bell"></i>&nbsp;&nbsp;
                                                    <a class="fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate"
                                                        href="manager_reply_request.php?chamado_id=<?php echo $id_chamado; ?>">
                                                        <?php echo $dados['usu_nome'] . ' - ' . $dados['cha_tipo'] . ' - ' . $dados['cha_importancia'] ?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                        <span class="text-success">Resolvidos</span>
                                    </div>
                                    <div class="text-dark fw-bold h5 mb-0">
                                        <span id="fechados">
                                            Carregando...
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success d-md-none d-block"
                                        data-bs-toggle="modal" data-bs-target="#resolvidosModal"><i
                                            class="gg-check text-gray-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="resolvidosModal" tabindex="-1" aria-labelledby="resolvidosModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content bg-white">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resolvidosModalLabel">Resolvidos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <?php
                                    $NumResol = "SELECT COUNT(cha_id) FROM chamado WHERE cha_status = 'fechado'";
                                    $ChaResol = mysqli_query($conn, $NumResol);
                                    $ResolRow = mysqli_fetch_array($ChaResol);
                                    $total_resol = $ResolRow[0];
                                    echo "<p>Total Resolvidos " . $total_resol . "</p>";

                                    ?>
                                    <!-- Lista de chamados Fechados -->
                                    <?php
                                    $sql = "SELECT * FROM usuario LEFT JOIN chamado ON cha_usu_id = usu_id WHERE cha_status = 'fechado'";
                                    $resultado = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($resultado) > 0) {
                                        while ($dados = mysqli_fetch_array($resultado)) {
                                            $id_usuario = $dados['usu_id'];
                                            $id_chamado = $dados['cha_id'];
                                            $importancia = $dados['cha_importancia'];
                                            if ($dados['cha_tipo'] != NULL) {
                                                ?>
                                                <li class="list-group-item d-flex align-items-center">
                                                    <i class="gg-bell"></i>&nbsp;&nbsp;
                                                    <a class="fw-normal fs-6 text-decoration-none text-dark me-auto mb-0 text-truncate"
                                                        href="manager_reply_request.php?chamado_id=<?php echo $id_chamado; ?>">
                                                        <?php echo $dados['usu_nome'] . ' - ' . $dados['cha_tipo'] . ' - ' . $dados['cha_importancia'] ?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-md-none d-flex justify-content-center align-items-center">
                    <a href="list_residents.php"><i class="gg-database mx-4" id="gg-database"></i></a>
                    <label>Moradores</label>
                    <a href="profile_manager.php"><i class="gg-profile mx-4"></i></a>
                    <label>Perfil</label>
                </div>

                <div class="row no-gutters">
                    <div class="col-6" style="max-width: 300px;">
                        <div class="card d-none d-sm-block" style="width: 280px;">
                            <?php
                            $sql = "SELECT usu_id, usu_nome, usu_email, usu_cpf, ap_bloco, ap_num
                            FROM usuario 
                            LEFT JOIN apartamento ON apartamento.ap_id = usuario.usu_ap_id 
                            WHERE usu_tipo = 'morador' 
                            GROUP BY usu_id";

                            $resultado = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($resultado) > 0) {
                                ?>
                                <div class="card" style="max-width:300px;">
                                    <div class="card-header text-primary">
                                        Moradores Cadastrados
                                    </div>
                                    <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                        <ul class="list-group list-group-light">
                                            <?php
                                            while ($dados = mysqli_fetch_array($resultado)) {
                                                ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="fw-bold">
                                                            <img class="rounded-circle me-2" width="40" height="40"
                                                                src="assets/php/read_img.php?PicNum=<?php echo $dados['usu_id']; ?>">
                                                            <?php echo $dados['usu_nome'] ?>
                                                        </div>
                                                        <p style="font-size: 13px;" class="mt-1 mb-0 text-muted">
                                                            <?php echo 'Bloco: ' . $dados['ap_bloco'] ?>
                                                            <?php echo 'Apto: ' . $dados['ap_num'] ?>
                                                        </p>
                                                        <?php

                                                        ?>
                                                    </div>

                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-6" style="max-width: 300px;">
                        <div class="card d-none d-sm-block" style="width: 280px;">
                            <div class="card" style="max-width:300px;">
                                <div class="card-header text-danger">
                                    Chamados Abertos
                                </div>
                                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                    <ul id="cardChamados" class="list-group list-group-light">
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-6" style="max-width: 300px;">
                        <div class="card d-none d-sm-block" style="width: 280px;">
                            <div class="card" style="max-width:300px;">
                                <div class="card-header text-warning">
                                    Chamados Andamento
                                </div>
                                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                    <ul id="cardChamadosAndamento" class="list-group list-group-light">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="max-width: 300px;">
                        <div class="card d-none d-sm-block" style="width: 280px;">
                            <div class="card" style="max-width:300px;">
                                <div class="card-header text-success">
                                    Chamados Fechados
                                </div>
                                <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                    <ul id="cardChamadosFechados" class="list-group list-group-light">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <form action="assets/PHP/first_login_manager.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
                            <p>Olá Altere seus dados de logins</p>
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto:</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="cpf"
                                onkeyup="this.value = formatCPF(this.value)" maxlength="14" required>
                        </div>
                        <div class="mb-3">
                            <label for="telFixo" class="form-label">Tel. Fixo</label>
                            <input type="text" class="form-control" id="telFixo" name="telefonefixo"
                                onkeyup="this.value = formatTel(this.value)" maxlength="13" required>
                        </div>
                        <div class="mb-3">
                            <label for="telMovel" class="form-label">Tel. Movél</label>
                            <input type="text" class="form-control" id="telMovel" name="telefonemovel"
                                onkeyup="this.value = formatTelM(this.value)" maxlength="14" required>
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
    <script src="assets/js/ajax.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
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