<!doctype html>
<html lang="pt-BR">
<head>
<?php
require 'config/conexao.php';
session_start();

// Se o usuário não estiver logado, redireciona para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agenda</title>

  
  <link href="php/css/custom.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <div class="topbar">
    <div class="brand">
      <div style="width:24px; height:24px; background:#0d6efd; border-radius:4px;"></div>
      <h1>Agenda</h1>
    </div>
    <button class="btn btn-primary" id="btnNovo">+ Novo Evento</button>
  </div>

  <div class="layout">
    
    <aside class="sidebar">
      <h4>Eventos Recentes</h4>
      <ul id="listaEventos">
        <li style="color:#777; font-size:0.9em;">Carregando...</li>
      </ul>
    </aside>

    <main>
      <div id="calendar"></div>
    </main>
  </div>
</div>

<div class="modal-backdrop" id="backdrop">
  <div class="modal">
    <h3 id="modalTitle">Novo evento</h3>
    <form id="formEvento">
      <input type="hidden" name="id" id="eventId">
      
      <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" required placeholder="Ex: Reunião">
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
    <button type="button" class="btn btn-danger" id="btnDeletar" style="display: none;">Excluir</button>
    
    <button type="button" class="btn btn-outline" id="btnFechar">Cancelar</button>
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>
    </form>
  </div>
</div>

<a href="actions/logout.php" class="btn-logout-flutuante">Encerrar sessão</a>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="php/js/app.js"></script>
</body>
</html>