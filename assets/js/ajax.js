function atualizarMensagens() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/messageNotify.php');

    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response);

            // Atualizar o número de mensagens novas antes de atualizá-las
            var numeroMensagensAntes = document.getElementById('numeroMensagemNovas').textContent;

            // Atualizar o número de mensagens novas
            var numeroMensagemNovas = document.getElementById('numeroMensagemNovas');
            numeroMensagemNovas.textContent = response.length;

            // Limpar as mensagens existentes
            var mensagemInfo = document.getElementById('mensagemInfo');
            var dropdownItems = mensagemInfo.getElementsByClassName('dropdown-item');
            for (var i = dropdownItems.length - 1; i >= 0; i--) {
                dropdownItems[i].remove();
            }

            // Adicionar as novas mensagens
            for (var i = 0; i < response.length; i++) {
                var mensagem = response[i];

                var mensagemHtml = `
                <a class="dropdown-item d-flex align-items-center" href="">
                    <div class="me-3">
                        <div class="icon-circle" style="background-color: #6b6b6b;">
                            <i class="gg-comment text-white"></i>
                        </div>
                    </div>
                    <div>
                        <span class="small text-gray-500">
                            ${mensagem.usu_nome} enviou uma mensagem, <b>clique no card em andamento para ver</b>
                        </span>
                    </div>
                </a>
            `;

                mensagemInfo.insertAdjacentHTML('beforeend', mensagemHtml);
            }

            // Verificar se houve novas mensagens
            if (response.length > numeroMensagensAntes) {
                // Reproduzir o som de notificação
                reproduzirSomNotificacao();
            }
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}

// Função para reproduzir o som de notificação
function reproduzirSomNotificacao() {
    var audio = new Audio('assets/sound/notifySound.mp3');
    audio.play();
}

// Atualizar as mensagens a cada 5 segundos (5000 milissegundos)
setInterval(atualizarMensagens, 5000);

// Chamar a função para atualizar as mensagens imediatamente
atualizarMensagens();
function atualizarNotificacoes() {

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/notify.php');

    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response);
            var numeroChamadosAbertos = document.getElementById('numeroChamadosAbertos');
            numeroChamadosAbertos.textContent = response.length;
            var chamadosInfo = document.getElementById('chamadosInfo');
            var dropdownItems = chamadosInfo.getElementsByClassName('dropdown-item');
            for (var i = dropdownItems.length - 1; i >= 0; i--) {
                if (!dropdownItems[i].classList.contains('text-center')) {
                    dropdownItems[i].remove();
                }
            }
            for (var i = 0; i < response.length; i++) {
                var chamado = response[i];
                var importanciaHtml = '';

                if (chamado.cha_importancia === 'grave') {
                    importanciaHtml = '<span style="color: white; font-weight:bold; background-color: red;">' + chamado.cha_importancia + '</span>';
                } else if (chamado.cha_importancia === 'medio') {
                    importanciaHtml = '<span style="color: white; font-weight:bold; background-color: orange;">' + chamado.cha_importancia + '</span>';
                } else {
                    importanciaHtml = '<span style="color: white; font-weight:bold; background-color: blue;">' + chamado.cha_importancia + '</span>';
                }
                var notificacaoHtml = `
                    <a class="dropdown-item d-flex align-items-center" href="manager_reply_request.php?chamado_id=${chamado.cha_id}">
                        <div class="me-3">
                            <div class="icon-circle" style="background-color: #6b6b6b;">
                                <i class="gg-bell text-white"></i>
                            </div>
                        </div>
                        <div>
                            <span class="small text-gray-500">
                            ${chamado.usu_nome}  Abriu um chamado de Importancia: ${importanciaHtml} 
                            </span>
                        </div>
                    </a>  
                `;


                chamadosInfo.insertAdjacentHTML('beforeend', notificacaoHtml);

            }
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}
setInterval(atualizarNotificacoes, 5000);
atualizarNotificacoes();
function atualizarChamadosAbertos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/calls.php', true);
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response)
            var novosChamados = document.getElementById('novosChamados');
            novosChamados.textContent = response.totalChamadosAbertos;
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}
atualizarChamadosAbertos();
setInterval(atualizarChamadosAbertos, 5000);


function atualizarChamadosAndamento() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/in_progress.php', true);
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response)
            var emAndamento = document.getElementById('emAndamento');
            emAndamento.textContent = response.totalChamadosAndamento;
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}
atualizarChamadosAndamento();
setInterval(atualizarChamadosAndamento, 5000);
function atualizarChamadosFechados() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/close_calls.php', true);
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response)
            var fechados = document.getElementById('fechados');
            fechados.textContent = response.totalChamadosFechados;
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}
atualizarChamadosFechados();
setInterval(atualizarChamadosFechados, 5000);
function cardChamadosAbertos() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/ticketOpen_card.php');
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response);
            var cardChamados = document.getElementById('cardChamados');

            if (response.length === 0) {
                cardChamados.innerHTML = 'Não há chamados abertos.';
            } else {
                cardChamados.innerHTML = '';

                for (var i = 0; i < response.length; i++) {
                    var chamado = response[i];
                    var importanciaHtml = '';

                    if (chamado.cha_importancia === 'grave') {
                        importanciaHtml = '<div class="importanciaGrave">' + chamado.cha_importancia + '</div>';
                    } else if (chamado.cha_importancia === 'medio') {
                        importanciaHtml = '<div class="importanciaMedio">' + chamado.cha_importancia + '</div>';
                    } else {
                        importanciaHtml = '<div class="importanciaComum">' + chamado.cha_importancia + '</div>';
                    }

                    var chamadoHtml = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">${chamado.usu_nome}</div>
                        </div>
                        <div class="mx-2">
                            ${importanciaHtml}
                        </div>
                        <a class="text-decoration-none me-4" href="manager_reply_request.php?chamado_id=${chamado.cha_id}">
                            <span class="gg-mail text-danger "></span>
                        </a>
                    </li>
                     `;

                    cardChamados.innerHTML += chamadoHtml;
                }
            }
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}

cardChamadosAbertos();
setInterval(cardChamadosAbertos, 5000);


function cardChamadosAndamento() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/inProgress_card.php');
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response);
            var cardChamadosAndamento = document.getElementById('cardChamadosAndamento');

            if (response.length === 0) {
                cardChamadosAndamento.innerHTML = 'Não há chamados em andamento.';
            } else {
                cardChamadosAndamento.innerHTML = '';

                for (var i = 0; i < response.length; i++) {
                    var chamado = response[i];
                    var importanciaHtml = '';

                    if (chamado.cha_importancia === 'grave') {
                        importanciaHtml = '<div class="importanciaGrave">' + chamado.cha_importancia + '</div>';
                    } else if (chamado.cha_importancia === 'medio') {
                        importanciaHtml = '<div class="importanciaMedio">' + chamado.cha_importancia + '</div>';
                    } else {
                        importanciaHtml = '<div class="importanciaComum">' + chamado.cha_importancia + '</div>';
                    }

                    var chamadoHtml = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">${chamado.usu_nome}</div>
                        </div>
                        <div class="mx-2">
                            ${importanciaHtml}
                        </div>
                        <a class="text-decoration-none me-4" href="manager_reply_request.php?chamado_id=${chamado.cha_id}">
                            <span class="gg-time text-danger "></span>
                        </a>
                    </li>
                     `;

                    cardChamadosAndamento.innerHTML += chamadoHtml;
                }
            }
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}


cardChamadosAndamento();
setInterval(cardChamadosAndamento, 5000);

function cardChamadosFechados() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'assets/PHP/close_card.php');
    xhr.responseType = 'json';
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = xhr.response;
            console.log(response);
            var cardChamadosFechados = document.getElementById('cardChamadosFechados');

            if (response.length === 0) {
                cardChamadosFechados.innerHTML = 'Não há chamados fechados.';
            } else {
                cardChamadosFechados.innerHTML = '';

                for (var i = 0; i < response.length; i++) {
                    var chamado = response[i];
                    var importanciaHtml = '';

                    if (chamado.cha_importancia === 'grave') {
                        importanciaHtml = '<div class="importanciaGrave">' + chamado.cha_importancia + '</div>';
                    } else if (chamado.cha_importancia === 'medio') {
                        importanciaHtml = '<div class="importanciaMedio">' + chamado.cha_importancia + '</div>';
                    } else {
                        importanciaHtml = '<div class="importanciaComum">' + chamado.cha_importancia + '</div>';
                    }

                    var chamadoHtml = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">${chamado.usu_nome}</div>
                        </div>
                        <div class="mx-2">
                            ${importanciaHtml}
                        </div>
                        <a class="text-decoration-none me-4" href="manager_reply_request.php?chamado_id=${chamado.cha_id}">
                            <span class="gg-check text-success "></span>
                        </a>
                    </li>
                     `;

                    cardChamadosFechados.innerHTML += chamadoHtml;
                }
            }
        } else {
            console.log('Erro na requisição AJAX. Status: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        console.log('Erro na requisição AJAX. Status: ' + xhr.status);
    };
    xhr.send();
}

cardChamadosFechados();
setInterval(cardChamadosFechados, 5000);
