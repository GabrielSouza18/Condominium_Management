<?php
require_once 'assets/PHP/db_connect.php';
// Verificar se o parâmetro chamado_id foi passado na URL
if (isset($_GET['chamado_id'])) {
    $chamado_id = $_GET['chamado_id'];

    // Consultar o banco de dados para obter informações do chamado e do usuário correspondente
    $sql = "SELECT * FROM chamado LEFT JOIN usuario ON usu_id = cha_usu_id LEFT JOIN apartamento ON ap_id = usu_ap_id WHERE cha_id = '$chamado_id'";
    $resultado = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_array($resultado);
    $usu_tipo = $dados["usu_tipo"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>CM - Responder Chamado</title>
    <link rel="icon" type="image/png" sizes="500x500" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <style>
        html,
        body {
            height: 100% !important;

            overflow: hidden !important;
        }

        .container {
            height: 100% !important;
            margin: 0 !important;

        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100" id=bg-white>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card shadow-lg o-hidden border-0  mt-2" id="cardResident">
                <div>
                    <center>
                        <img src="assets/img/call.png" alt="LogoSite" id="callImg" class="d-none d-sm-block">
                        <h3 id="pIndex">Chamado</h3>
                    </center>
                    <div class="p-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <p class="mx-2">Nome:
                                    <?php echo $dados['usu_nome']; ?>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <p class="mx-2 d-none d-md-block">Apto:
                                    <?php echo $dados['ap_num']; ?>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <p class="mx-2">Bloco:
                                    <?php echo $dados['ap_bloco']; ?>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <p class="mx-2">Tipo:
                                    <?php echo $dados['cha_tipo']; ?>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <p class="mx-2">Status:
                                    <?php echo $dados['cha_status']; ?>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <p class="mx-2">Importancia
                                    <?php
                                    if ($dados['cha_importancia'] === 'grave') {
                                        echo '<span class="importanciaGrave">' . $dados['cha_importancia'] . '</span>';
                                    } elseif ($dados['cha_importancia'] === 'medio') {
                                        echo '<span  class="importanciaMedio">' . $dados['cha_importancia'] . '</span>';
                                    } else {
                                        echo '<span  class="importanciaComum">' . $dados['cha_importancia'] . '</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <p align="center" class="mt-1 mb-2"><b>Histórico de Mensagens:</b></p>
                        <div class="d-flex justify-content-center">
                            <textarea class="form-control" id="historico_mensagens" rows="10" readonly>
                                    <?php
                                    // Consultar o banco de dados para obter o histórico de mensagens do chamado
                                    
                                    $sqlMensagens = "SELECT m.*, u.usu_nome AS usu_nome FROM mensagem m
                                                    INNER JOIN usuario u ON m.men_usu_id = u.usu_id
                                                    WHERE m.men_cha_id = '$chamado_id'
                                                    ORDER BY m.men_data";
                                    $resultadoMensagens = mysqli_query($conn, $sqlMensagens);

                                    if (!$resultadoMensagens) {
                                        die("Erro na consulta: " . mysqli_error($conn));
                                    }

                                    while ($mensagem = mysqli_fetch_assoc($resultadoMensagens)) {
                                        echo $mensagem['usu_nome'] . ':' . $mensagem['men_mensagem'] . "\n";
                                    }
                                    ?>
                                </textarea>
                        </div>
                        <a class="d-flex justify-content-center mb-1 text-danger" id="aRecovery"
                            onclick="finalizarChamado()">Finalizar
                            Chamado</a>
                        <div class="d-flex justify-content-center mt-1">
                            <div class="input-group" style="max-width: 35rem;">
                                <?php
                                if ($dados['cha_status'] === "fechado") {
                                    $disabled = "disabled";
                                } else {
                                    $disabled = "";
                                }
                                ?>

                                <input type="text" class="form-control" id="nova_mensagem"
                                    placeholder="Digite sua mensagem..." <?php echo $disabled; ?>>
                                <button class="btn text-white" type="button" id="btnEnviar" onclick="enviarMensagem()"
                                    <?php echo $disabled; ?>>Enviar
                                </button>

                            </div>
                        </div>
                    </div>
                    <a class="d-flex justify-content-center mb-1" id="aRecovery" href="dashboard_manager.php">Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function enviarMensagem() {
            // Capturar o conteúdo da caixa de texto
            var chamado_id = <?php echo $dados['cha_id']; ?>;
            var mensagem = document.getElementById("nova_mensagem").value;
            var status = "em_andamento"; // Define o status padrão como "andamento"

            // Verificar se a mensagem não está vazia
            if (mensagem.trim() === "") {
                console.error("A mensagem está vazia");
                return;
            }

            // Criar um objeto FormData para enviar os dados
            var formData = new FormData();
            formData.append('chamado_id', chamado_id);
            formData.append('mensagem', mensagem);
            formData.append('status', status);

            // Enviar a requisição AJAX
            fetch('assets/PHP/reply_request.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        // A resposta do servidor foi bem-sucedida
                        // Atualize a página ou faça qualquer outra ação necessária
                        location.reload();
                    } else {
                        // A resposta do servidor foi inválida
                        console.error("Erro ao enviar a mensagem: " + response.status);
                    }
                })
                .catch(error => {
                    console.error("Erro ao enviar a mensagem: " + error);
                });
        }
        function finalizarChamado() {
            // Capturar o conteúdo da caixa de texto
            var chamado_id = <?php echo $dados['cha_id']; ?>;
            var mensagem = document.getElementById("nova_mensagem").value;
            var status = "fechado"; // Define o status padrão como fechado

            if (mensagem === "") {
                mensagem = "Chamado FINALIZADO, por favor abra um novo chamado";
            }

            document.getElementById("nova_mensagem").value = mensagem;

            // Criar um objeto FormData para enviar os dados
            var formData = new FormData();
            formData.append('chamado_id', chamado_id);
            formData.append('mensagem', mensagem);
            formData.append('status', status);

            // Enviar a requisição AJAX
            fetch('assets/PHP/reply_request.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        // A resposta do servidor foi bem-sucedida
                        // Atualize a página ou faça qualquer outra ação necessária
                        location.reload();
                    } else {
                        // A resposta do servidor foi inválida
                        console.error("Erro ao enviar a mensagem: " + response.status);
                    }
                })
                .catch(error => {
                    console.error("Erro ao enviar a mensagem: " + error);
                });
        }
    </script>
</body>


</html>