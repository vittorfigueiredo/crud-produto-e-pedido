<?php $this->layout("template") ?>

<div class="container mt-5">

<h1>Pedidos</h1>

<div class="accordion accordion-flush" id="accordionFlush">
  <div class="d-flex justify-content-end mb-3">
    <a href="/pedidos/novo" class="btn bg-warning"><span><i class="bi bi-plus-square"></i></span> Novo Pedido</a>
  </div>
  <?php foreach ($orders as $order) { ?>
    <div class="accordion-item">
      <h2 class="accordion-header d-flex">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-<?= $order["id"]?>" aria-expanded="false" aria-controls="flush-collapseOne">
          Pedido #<?= $order["id"]?>
        </button>
        <a class="btn bg-danger" onclick="destroyOrder(<?= $order['id']?>)"><span><i class="bi bi-trash"></i></span> Excluir</a>
      </h2>
      <div id="flush-collapseOne-<?= $order["id"]?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlus">
        <h6 class="mt-2">Produtos</h6>
        <div class="accordion-body">
          <table class="table">
            <thead>
              <tr>
                <td scope="col">Imagem</td>
                <td scope="col">ID</td>
                <td scope="col">Quantidade</td>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($order["products"] as $product) { ?>
                <tr>
                  <td scope="row">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="/uploads/<?= $product["images"][0]["url"] ?>" width="100px" height="auto">
                        </div>
                        <?php foreach ($product["images"] as $image) { ?>
                          <div class="carousel-item">
                            <img src="/uploads/<?= $image["url"] ?>" width="100px" height="auto">
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </td>
                  <td scope="row"><?= $product["product_id"] ?></td>
                  <td scope="col"><?= $product["quantity"] ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<?php if (!$orders) { ?>
  <div class="text-center mt-5">
    <h6>Nenhum pedido encontrado!</h6>
  </div>
<?php } ?>

</div>