<?php $this->layout("template") ?>

<div class="container mt-5">

  <h1>Novo pedido</h1>
  <p>Selecione os produtos abaixo e clique em Cadastrar</p>

<table class="table mt-4">
  <thead>
    <tr>
      <td></td>
      <td scope="col">DESCRICAO</td>
      <td scope="col">VALOR VENDA</td>
      <td scope="col">ESTOQUE</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
      <tr>
        <td><input type="checkbox" class="checkbox" value="<?= $product["id"] ?>"></td>
        <td scope="col"><?= $product["descricao"] ?></td>
        <td scope="col">R$ <?= $product["valor_venda"] ?></td>
        <td scope="col"><?= $product["estoque"] ?></td>
      </tr>
      <?php } ?>
  </tbody>
</table>

  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-primary" onclick="storeOrder()">Cadastrar</button>
  </div>

  <div class="mt-5">
    <a href="/pedidos" class="btn btn-primary"><span><i class="bi bi-arrow-return-left"></i></span> Voltar</a>
  </div>

</div>
