// MASCARAS PARA OS CAMPOS


function formatCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); // remove tudo que não for dígito
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // adiciona um ponto após os primeiros 3 dígitos
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2"); // adiciona um ponto após os segundos 3 dígitos
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // adiciona um traço e os dois últimos dígitos

    return cpf;
}

function formatTel(tel) {
    tel = tel.replace(/\D/g, ""); // remove tudo que não for dígito
    tel = tel.replace(/(\d{1})(\d)/, "($1$2)"); // adiciona um parênteses após os primeiros 2 dígitos
    tel = tel.replace(/(\d{4})(\d)/, "$1-$2"); // adiciona um traço após os primeiros 4 dígitos

    return tel;
}

function formatTelM(telm) {
    telm = telm.replace(/\D/g, ""); // remove tudo que não for dígito
    telm = telm.replace(/(\d{1})(\d)/, "($1$2)"); // adiciona um parênteses após os primeiros 2 dígitos
    telm = telm.replace(/(\d{5})(\d)/, "$1-$2"); // adiciona um traço após os primeiros 5 dígitos
    return telm;
}

function formatNome(name) {
    name = name.replace(/[^a-zA-Z\u00C0-\u00FF\s]/g, '').replace(/\s{2,}/g, ' '); // remove tudo que não for letra, letra com acento ou espaços adicionais
    return name;
}

function formatEmail(email) {
    email = email.replace(/[^a-zA-Z0-9.@_-]/g, '');

    return email;
}

// SwalFire 
const form = document.getElementById("form");
form.addEventListener("submit", (event) => {
    event.preventDefault(); // previne o envio do formulário por enquanto
    Swal.fire({
        title: "Tem certeza que deseja enviar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, enviar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar o formulário
            form.submit();
        }
    });
}); // fecha a função de callback e o método addEventListener




