// js/app.js
document.addEventListener('DOMContentLoaded', function() {
    
    // Elementos
    const backdrop = document.getElementById('backdrop');
    const form = document.getElementById('formEvento');
    const btnNovo = document.getElementById('btnNovo');
    const btnFechar = document.getElementById('btnFechar');
    // NOVO: Referência ao botão de deletar
    const btnDeletar = document.getElementById('btnDeletar');
    const listaEventos = document.getElementById('listaEventos');

    // --- LÓGICA DO MODAL ---
    function openModal(data) {
        const isEdit = data && data.id;

        document.getElementById('modalTitle').textContent = isEdit ? 'Editar evento' : 'Novo evento';
        document.getElementById('eventId').value = isEdit ? data.id : '';
        document.getElementById('titulo').value = data && data.title ? data.title : '';
        document.getElementById('descricao').value = data && data.description ? data.description : '';

        // Lógica do botão Deletar (Só aparece se for edição)
        if (isEdit) {
            btnDeletar.style.display = 'block';
        } else {
            btnDeletar.style.display = 'none';
        }

        // Formatar datas para o input datetime-local
        if(data && data.start){
            const d = new Date(data.start);
            // Ajuste de fuso horário simples para visualização correta
            d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
            document.getElementById('data_inicio').value = d.toISOString().slice(0,16);
        } else {
            document.getElementById('data_inicio').value = '';
        }

        if(data && data.end){
            const d = new Date(data.end);
            d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
            document.getElementById('data_fim').value = d.toISOString().slice(0,16);
        } else {
            document.getElementById('data_fim').value = '';
        }

        // Mostra o modal com flexbox para centralizar
        backdrop.style.display = 'flex';
    }

    function closeModal() {
        backdrop.style.display = 'none';
        form.reset();
    }

    btnNovo.addEventListener('click', () => openModal());
    btnFechar.addEventListener('click', closeModal);
    
    // Fechar se clicar fora do modal
    backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) closeModal();
    });

    // --- LÓGICA DE BACKEND (Fetch) ---
    async function fetchEventos(){
        try{
            const res = await fetch('events.php'); // Certifique-se que o caminho está certo (ex: php/events.php se estiver em pasta)
            if(!res.ok) throw new Error('Backend offline');
            const data = await res.json();
            return data;
        } catch(err) {
            console.warn('Backend não respondeu. Usando modo offline.', err);
            return []; 
        }
    }

    async function salvarEvento(payload){
        try {
            const formData = new FormData();
            Object.keys(payload).forEach(k=> formData.append(k,payload[k]));
            await fetch('add_event.php', {method:'POST', body:formData});
        } catch(e) { console.error(e); }
    }

    async function atualizarEvento(payload){
        try {
            const formData = new FormData();
            Object.keys(payload).forEach(k=> formData.append(k,payload[k]));
            await fetch('update_event.php', {method:'POST', body:formData}); // Se não tiver update_event, use add_event se ele suportar UPDATE
        } catch(e) { console.error(e); }
    }

    // NOVO: Função para deletar
    async function deletarEvento(id){
        try {
            const formData = new FormData();
            formData.append('id', id);
            
            const res = await fetch('delete_event.php', {method:'POST', body:formData});
            const data = await res.json();
            
            if(data.success) {
                return true;
            } else {
                alert('Erro: ' + (data.error || 'Erro desconhecido'));
                return false;
            }
        } catch(e) { 
            console.error(e); 
            alert("Erro de conexão ao tentar deletar.");
            return false;
        }
    }

    // --- CONFIGURAÇÃO DO FULLCALENDAR ---
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today:    'Hoje',
            month:    'Mês',
            week:     'Semana',
            day:      'Dia',
            list:     'Lista'
        },
        editable: true,
        selectable: true,
        
        select: function(info) {
            openModal({start: info.start, end: info.end});
        },
        eventClick: function(info) {
            const ev = info.event;
            openModal({
                id: ev.id, 
                title: ev.title, 
                description: ev.extendedProps.description, 
                start: ev.start, 
                end: ev.end
            });
        },
        eventDrop: async function(info){
             const ev = info.event;
             const payload = {
                id: ev.id, 
                start: ev.start.toISOString().slice(0,19).replace('T',' '), 
                end: ev.end? ev.end.toISOString().slice(0,19).replace('T',' '): ''
             };
             await atualizarEvento(payload);
        },
        
        events: async function(fetchInfo, successCallback, failureCallback) {
            const data = await fetchEventos();
            const evs = data.map(e => ({
                id: e.id,
                title: e.title,
                start: e.start,
                end: e.end || null,
                description: e.description
            }));
            
            renderListaEventos(evs);
            successCallback(evs);
        }
    });

    calendar.render();

    // --- FUNÇÕES AUXILIARES ---
    function renderListaEventos(evs) {
        listaEventos.innerHTML = '';
        if(evs.length === 0) {
            listaEventos.innerHTML = '<li style="color:#999">Nenhum evento.</li>';
            return;
        }
        // Ordena por data (mais recente primeiro ou futuro primeiro)
        evs.sort((a,b) => new Date(a.start) - new Date(b.start));

        evs.forEach(e => {
            const li = document.createElement('li');
            li.innerHTML = `<strong>${e.title}</strong><br><small>${formatDate(e.start)}</small>`;
            li.addEventListener('click', () => {
                calendar.gotoDate(e.start);
            });
            listaEventos.appendChild(li);
        });
    }

    function formatDate(dateStr) {
        if(!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleDateString('pt-BR', {day:'2-digit', month:'2-digit', hour:'2-digit', minute:'2-digit'});
    }

    // --- SUBMIT DO FORMULÁRIO ---
    form.addEventListener('submit', async function(e){
        e.preventDefault();
        
        const id = document.getElementById('eventId').value;
        const titulo = document.getElementById('titulo').value;
        const descricao = document.getElementById('descricao').value;
        const dInicio = document.getElementById('data_inicio').value;
        const dFim = document.getElementById('data_fim').value;

        const startSql = dInicio.replace('T', ' ');
        const endSql = dFim ? dFim.replace('T', ' ') : '';

        const payload = {
            title: titulo, 
            description: descricao, 
            start: startSql, 
            end: endSql
        };

        if (id) {
            payload.id = id;
            await atualizarEvento(payload); // Certifique-se que existe update_event.php
        } else {
            await salvarEvento(payload);
        }

        calendar.refetchEvents();
        closeModal();
    });

    // --- NOVO: CLICK NO BOTÃO DELETAR ---
    if(btnDeletar) {
        btnDeletar.addEventListener('click', async function() {
            const id = document.getElementById('eventId').value;
            if(!id) return;

            if(confirm("Tem certeza que deseja apagar este evento permanentemente?")) {
                const sucesso = await deletarEvento(id);
                if(sucesso) {
                    calendar.refetchEvents(); // Recarrega o calendário
                    closeModal(); // Fecha o modal
                }
            }
        });
    }
});