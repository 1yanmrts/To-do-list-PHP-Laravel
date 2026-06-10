import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import '@fortawesome/fontawesome-free/css/all.min.css';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import 'datatables.net-buttons-dt/css/buttons.dataTables.min.css';

import DataTable from 'datatables.net-dt';
window.DataTable = DataTable;

import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';

import jszip from 'jszip';
window.JSZip = jszip;

import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
try {
    pdfMake.vfs = pdfFonts?.pdfMake?.vfs || pdfFonts?.vfs;
    window.pdfMake = pdfMake;
} catch (e) {
    console.warn('Aviso: Erro silencioso no PDFMake', e);
}

import Swal from 'sweetalert2';
window.Swal = Swal;

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

window.abrirModalNovaTarefa = function () {
    document.getElementById('modalNovaTarefa').style.display = 'flex';
}

window.fecharModalNovaTarefa = function () {
    document.getElementById('modalNovaTarefa').style.display = 'none';
}

window.fecharModalEditar = function () {
    document.getElementById('modalEditar').style.display = 'none';
}

window.abrirModalEditar = function (botao) {
    const id = botao.dataset.id;
    document.getElementById('formEditar').action = '/tarefas/' + id;
    document.querySelector('#formEditar input[name="nome"]').value = botao.dataset.nome;
    document.querySelector('#formEditar input[name="data_limite"]').value = botao.dataset.data;
    document.querySelector('#formEditar textarea[name="descricao"]').value = botao.dataset.desc;
    document.getElementById('modalEditar').style.display = 'flex';
}

window.confirmarExclusaoTabela = function (id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter a exclusão desta tarefa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#888',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/tarefas/' + id;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = csrfToken;
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            
            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    });
};

window.alternarStatusTabela = function (id, checkbox) {
    const linha = checkbox.closest('tr');
    const statusAtual = checkbox.checked;

    fetch('/tarefas/' + id + '/concluir', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => {
        if (!response.ok) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Erro ao atualizar o status.' });
            checkbox.checked = !checkbox.checked;
        } else {
            if (statusAtual) {
                linha.classList.add('tarefa-concluida');
            } else {
                linha.classList.remove('tarefa-concluida');
            }

            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            Toast.fire({ icon: 'success', title: 'Status atualizado!' });
        }
    }).catch(error => {
        Swal.fire({ icon: 'error', title: 'Erro de conexão', text: 'Não foi possível conectar ao servidor: ' + error.message });
        checkbox.checked = !checkbox.checked;
    });
};
window.clicarLinhaInteira = function(event, id, linha) {
    if (event.target.closest('button') || event.target.closest('a') || event.target.type === 'checkbox') {
        return;
    }
    const statusAtual = linha.classList.contains('tarefa-concluida');
    const novoStatus = !statusAtual; 

    fetch('/tarefas/' + id + '/concluir', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ concluida: novoStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (novoStatus) {
                linha.classList.add('tarefa-concluida');
            } else {
                linha.classList.remove('tarefa-concluida');
            }

            linha.cells[1].innerText = data.data_conclusao;

            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            Toast.fire({ icon: 'success', title: 'Status updated!' });
        } else {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Erro ao atualizar o status.' });
        }
    }).catch(error => {
        console.error("Erro na requisição:", error);
        Swal.fire({ icon: 'error', title: 'Erro de conexão', text: 'Não foi possível conectar ao servidor.' });
    });
};