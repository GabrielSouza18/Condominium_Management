<?php
require_once 'db_connect.php';

if (isset($_POST['nome'])) {
    $busca = $_POST['nome'];

    // Realiza a consulta SQL para buscar os moradores com o tipo "morador" e que contenham a string de busca
    $resultado = mysqli_query($conn, "SELECT * FROM usuario WHERE usu_tipo='morador' AND usu_nome LIKE '%$busca%'");

    // Verifica se há resultados
    if (mysqli_num_rows($resultado) > 0) {
        // Exibe o nome de cada morador com um ícone de lixeira para cada um
        while ($morador = mysqli_fetch_array($resultado)) {
            echo $morador['usu_nome'] . ' <i class="gg-trash"></i><br>';
        }
    } else {
        // Exibe uma mensagem se não houver resultados
        echo '<p color="red">Nenhum morador encontrado.</p>';
    }
} else {
    // Exibe uma mensagem se o parâmetro de busca não estiver definido
    echo '<p color="red">Por favor, digite um nome para pesquisar.</p>';
}
