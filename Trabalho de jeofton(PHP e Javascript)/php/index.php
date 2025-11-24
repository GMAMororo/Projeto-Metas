<?php
// index.php - FullCalendar integration (PDO-ready, generic table 'events')
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Calendário - FullCalendar (PDO-ready)</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
  <link href="css/custom.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="topbar">
    <div class="brand">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none"><rect width="24" height="24" rx="4" fill="#0d6efd"/></svg>
      <h1>Agenda</h1>
    </div>
    <div>
      <button class="btn btn-primary" id="btnNovo">+ Novo Evento</button>
    </div>
  </div>

  <div class="layout">
    <aside class="sidebar">
      <div class="card">
        <h4>Eventos</h4>
        <ul class="event-list" id="listaEventos"></ul>
        <hr>
        <div style="display:flex;gap:8px">
          <button class="btn btn-outline" id="btnHoje">Hoje</button>
          <button class="btn" id="btnMes">Mês</button>
        </div>
      </div>
    </aside>

    <main>
      <div class="card">
        <div id="calendar"></div>
      </div>
    </main>
  </div>
</div>

<div class="modal-backdrop" id="backdrop">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <h3 id="modalTitle">Novo evento</h3>
    <form id="formEvento">
      <input type="hidden" name="id" id="eventId">
      <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" required>
      </div>
      <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"></textarea>
      </div>
      <div class="form-row">
        <div class="col form-group">
          <label for="data_inicio">Início</label>
          <input type="datetime-local" id="data_inicio" name="data_inicio" required>
        </div>
        <div class="col form-group">
          <label for="data_fim">Fim</label>
          <input type="datetime-local" id="data_fim" name="data_fim">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" id="btnFechar">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>

<script src="js/moment.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/app.js"></script>
<link rel="stylesheet" href="js/core/index.global.min.css">

<script src="js/core/index.global.min.js"></script>
<script src="js/interaction/index.global.min.js"></script>
<script src="js/daygrid/index.global.min.js"></script>
<script src="js/timegrid/index.global.min.js"></script>
<script src="js/list/index.global.min.js"></script>


</body>
</html>
