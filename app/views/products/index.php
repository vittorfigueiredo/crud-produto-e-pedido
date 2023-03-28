<?php $this->layout("template") ?>

<div class="container mt-5">

<h1>Produtos</h1>

<div class="d-flex justify-content-end mb-3">
  <a href="/produtos/novo" class="btn bg-warning"><span><i class="bi bi-plus-square"></i></span> Novo Produto</a>
</div>

<table class="table">
  <thead>
    <tr>
      <td scope="col">ID</td>
      <td scope="col">DESCRICAO</td>
      <td scope="col">VALOR VENDA</td>
      <td scope="col">ESTOQUE</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
      <tr>
        <td scope="row"><?= $product["id"] ?></td>
        <td scope="col"><?= $product["descricao"] ?></td>
        <td scope="col">R$ <?= $product["valor_venda"] ?></td>
        <td scope="col"><?= $product["estoque"] ?></td>
        <td class="d-flex justify-content-end gap-2 p-0">
          <a href="/produtos/editar?id=<?= $product["id"] ?>" class="btn bg-primary"><span><i class="bi bi-pencil-square"></i></span> Editar</a>
          <a class="btn bg-danger" onclick="destroy(<?= $product['id'] ?>)"><span><i class="bi bi-trash"></i></span> Excluir</a>
        </td>
      </tr>
      <?php } ?>
  </tbody>
</table>

<?php if (!$products) { ?>
  <div class="text-center mt-5">
    <h6>Nenhum produto encontrado!</h6>
  </div>
<?php } ?>

</div>