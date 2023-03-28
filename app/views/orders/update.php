<?php $this->layout("template") ?>

<div class="container mt-5">

<h1>Editar produto</h1>

<form>
  <div class="d-flex align-items-center gap-2 mb-3">
    <label for="inputId" class="form-label m-0">ID:</label>
    <input type="number" class="form-control-plaintext" value="<?= $product["id"] ?>" id="inputId" readonly>
  </div>
  <div class="mb-3">
    <label for="inputTextDescricao" class="form-label">Descrição</label>
    <input type="text" class="form-control" value="<?= $product["descricao"] ?>" id="inputTextDescricao" required>
    <div id="emailHelp" class="form-text">255 caracters no maximo!</div>
  </div>
  <div class="mb-3">
    <label for="inputValorVenda" class="form-label">Valor</label>
    <input type="number" min="0" class="form-control" value="<?= $product["valor_venda"] ?>" id="inputValorVenda" required>
  </div>
  <div class="mb-3">
    <label for="inputEstoque" class="form-label">Estoque</label>
    <input type="number" min="0" class="form-control" value="<?= $product["estoque"] ?>" id="inputEstoque" required>
  </div>
  <div class="mb-3">
    <label for="inputImagens" class="form-label">Imagens do produto</label>
    <div class="d-flex gap-2">
      <?php foreach ($product["images"] as $image) { ?>
        <div>
          <div>
            <img src="/uploads/<?= $image["url"] ?>" width="auto" height="130px">
          </div>
          <!-- <div class="d-flex justify-content-between mt-2">
            <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>
          </div> -->
        </div>
      <?php } ?>
      <div id="inputFileBackground">
        <input id="inputFile" type="file">
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-primary" onclick="update(<?= $product['id'] ?>)">Salvar</button>
  </div>
</form>

<div class="mt-5">
  <a href="/produtos" class="btn btn-primary"><span><i class="bi bi-arrow-return-left"></i></span> Voltar</a>
</div>

</div>

<script src="/assets/js/fileInputBehavior.js"></script>
