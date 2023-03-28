<?php $this->layout("template") ?>

<div class="container mt-5">

<h1>Cadastrar produto</h1>

<form>
  <div class="mb-3">
    <label for="inputTextDescricao" class="form-label">Descrição</label>
    <input type="text" class="form-control" id="inputTextDescricao" required>
    <div id="emailHelp" class="form-text">255 caracters no maximo!</div>
  </div>
  <div class="mb-3">
    <label for="inputValorVenda" class="form-label">Valor</label>
    <input type="number" min="0" class="form-control" id="inputValorVenda" required>
  </div>
  <div class="mb-3">
    <label for="inputEstoque" class="form-label">Estoque</label>
    <input type="number" min="0" class="form-control" id="inputEstoque" required>
  </div>
  <div class="mb-3">
    <label for="inputFile" class="form-label">Imagem</label>
    <div id="inputFileBackground">
      <input style="width: 100%;" id="inputFile" type="file">
    </div>
  </div>
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-primary" onclick="store()">Cadastrar</button>
  </div>
</form>

<div class="mt-5">
  <a href="/produtos" class="btn btn-primary"><span><i class="bi bi-arrow-return-left"></i></span> Voltar</a>
</div>

</div>

<script src="/assets/js/fileInputBehavior.js"></script>
