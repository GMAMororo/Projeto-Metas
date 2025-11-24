// js/app.js - FullCalendar + endpoints (PDO-ready)
document.addEventListener('DOMContentLoaded', function() {
  const backdrop = document.getElementById('backdrop');
  const btnNovo = document.getElementById('btnNovo');
  const btnFechar = document.getElementById('btnFechar');
  const form = document.getElementById('formEvento');
  const listaEventos = document.getElementById('listaEventos');

  function openModal(data){
    document.getElementById('modalTitle').textContent = data && data.id ? 'Editar evento' : 'Novo evento';
    document.getElementById('eventId').value = data && data.id ? data.id : '';
    document.getElementById('titulo').value = data && data.title ? data.title : '';
    document.getElementById('descricao').value = data && data.description ? data.description : '';

    if(data && data.start){
      const dstart = new Date(data.start);
      document.getElementById('data_inicio').value = dstart.toISOString().slice(0,16);
    } else {document.getElementById('data_inicio').value = ''}
    if(data && data.end){
      const dend = new Date(data.end);
      document.getElementById('data_fim').value = dend.toISOString().slice(0,16);
    } else {document.getElementById('data_fim').value = ''}

    backdrop.style.display = 'flex';
  }
  function closeModal(){backdrop.style.display = 'none'; form.reset();}

  btnNovo.addEventListener('click', ()=> openModal());
  btnFechar.addEventListener('click', closeModal);
  backdrop.addEventListener('click', function(e){ if(e.target === backdrop) closeModal(); });

  async function fetchEventos(){
    try{
      const res = await fetch('events.php');
      const data = await res.json();
      return data;
    }catch(err){console.error('Erro ao buscar eventos',err);return []}
  }

  async function salvarEvento(payload){
    try{
      const formData = new FormData();
      Object.keys(payload).forEach(k=> formData.append(k,payload[k]));
      const res = await fetch('add_event.php',{method:'POST',body:formData});
      const data = await res.json();
      return data;
    }catch(err){console.error(err);return null}
  }

  async function atualizarEvento(payload){
    try{
      const formData = new FormData();
      Object.keys(payload).forEach(k=> formData.append(k,payload[k]));
      const res = await fetch('update_event.php',{method:'POST',body:formData});
      const data = await res.json();
      return data;
    }catch(err){console.error(err);return null}
  }

  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'pt-br',
    initialView: 'dayGridMonth',
    headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
    editable: true,
    selectable: true,
    eventResizableFromStart: true,
    select: function(info){
      openModal({start: info.startStr, end: info.endStr});
    },
    eventClick: function(info){
      const ev = info.event;
      openModal({id:ev.id, title:ev.title, description: ev.extendedProps.description, start:ev.start, end:ev.end});
    },
    eventDrop: async function(info){
      const ev = info.event;
      const payload = {id: ev.id, start: ev.start.toISOString().slice(0,19).replace('T',' '), end: ev.end? ev.end.toISOString().slice(0,19).replace('T',' '): ''};
      await atualizarEvento(payload);
      calendar.refetchEvents();
    },
    eventResize: async function(info){
      const ev = info.event;
      const payload = {id: ev.id, start: ev.start.toISOString().slice(0,19).replace('T',' '), end: ev.end? ev.end.toISOString().slice(0,19).replace('T',' '): ''};
      await atualizarEvento(payload);
      calendar.refetchEvents();
    },
    events: async function(fetchInfo, successCallback){
      const data = await fetchEventos();
      const evs = data.map(e=>({ id: e.id, title: e.title, start: e.start, end: e.end ? e.end : null, description: e.description }));
      successCallback(evs);
      renderListaEventos(evs);
    }
  });

  calendar.render();

  function renderListaEventos(evs){
    listaEventos.innerHTML = '';
    evs.forEach(e=>{
      const li = document.createElement('li');
      li.innerHTML = `<strong>${escapeHtml(e.title)}</strong><br><small>${formatDate(e.start)} ${e.end? ' - '+formatDate(e.end):''}</small>`;
      li.addEventListener('click', ()=>{ calendar.gotoDate(e.start); });
      listaEventos.appendChild(li);
    });
  }

  function escapeHtml(txt){
    if(!txt) return '';
    return txt.replace(/[&<>"']/g, function(m){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
    });
  }

  form.addEventListener('submit', async function(e){
    e.preventDefault();
    const id = document.getElementById('eventId').value;
    const titulo = document.getElementById('titulo').value;
    const descricao = document.getElementById('descricao').value;
    const data_inicio = document.getElementById('data_inicio').value.replace('T',' ');
    const data_fim = document.getElementById('data_fim').value ? document.getElementById('data_fim').value.replace('T',' ') : '';

    if (id) {
      const payload = {id: id, title: titulo, description: descricao, start: data_inicio, end: data_fim};
      await atualizarEvento(payload);
    } else {
      const payload = {title: titulo, description: descricao, start: data_inicio, end: data_fim};
      await salvarEvento(payload);
    }

    calendar.refetchEvents();
    closeModal();
  });
});
