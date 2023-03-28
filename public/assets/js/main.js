const toBase64 = file => new Promise((resolve, reject) => {
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => resolve(reader.result);
  reader.onerror = error => reject(error);
});

async function destroy(productId) {
  if (!confirm('Deseja excluir o produto da base de dados?')) {
    return;
  }

  const response = await fetch (`/api/products/destroy?id=${productId}` , {
    method: 'DELETE'
  })

  const responseJSON = await response.json();

  if (!responseJSON.success) {
    return alert('Ocorreu um erro inesperado ao tentar excluir o produto!');
  }

  alert(responseJSON.success.message);
  return location.reload();
}

async function update(productId) {
  const description = document.getElementById('inputTextDescricao').value;
  const value = document.getElementById('inputValorVenda').value;
  const stock = document.getElementById('inputEstoque').value;

  const file = document.querySelector('#inputFile').files[0];

  let body = {
    id: productId,
    description: description,
    value: value,
    stock: stock,
  };

  if (file) {
    const base64Image = await toBase64(file);
    body.image = base64Image;
  }


  const response = await fetch (`/api/products/update` , {
    method: 'POST',
    body: new URLSearchParams(body),
  })

  const responseJSON = await response.json();

  if (!responseJSON.success) {
    return alert('Ocorreu um erro inesperado ao tentar atualizar o produto!');
  }

  alert(responseJSON.success.message);
  return location.reload();
}

async function store() {
  const description = document.getElementById('inputTextDescricao').value;
  const value = document.getElementById('inputValorVenda').value;
  const stock = document.getElementById('inputEstoque').value;

  const file = document.querySelector('#inputFile').files[0];
  const base64Image = await toBase64(file);

  if (!description) {
    return alert('O campo descricao nao pode ser vazio!');
  }

  if (!value) {
    return alert('O campo valor nao pode ser vazio!');
  }

  if (!stock) {
    return alert('O campo estoque nao pode ser vazio!');
  }

  if (!base64Image) {
    return alert('Selecione uma imagem para o produto!');
  }

  const response = await fetch (`/api/products/store` , {
    method: 'POST',
    body: new URLSearchParams({
      description: description,
      value: value,
      stock: stock,
      image: base64Image,
    })
  })

  const responseJSON = await response.json();

  if (!responseJSON.success) {
    return alert('Ocorreu um erro inesperado ao tentar atualizar o produto!');
  }

  alert(responseJSON.success.message);
  return window.location.replace('/produtos');
}

async function destroyOrder(orderId) {
  if (!confirm('Deseja excluir o pedido da base de dados?')) {
    return;
  }

  const response = await fetch (`/api/orders/destroy?id=${orderId}` , {
    method: 'DELETE'
  })

  const responseJSON = await response.json();

  if (!responseJSON.success) {
    return alert('Ocorreu um erro inesperado ao tentar excluir o pedido!');
  }

  alert(responseJSON.success.message);
  return location.reload();
}

async function storeOrder() {

  const productSelected = [...document.querySelectorAll('.checkbox:checked')].map(e => e.value);

  if (!productSelected.length) {
    return alert('Selecione 1 ou mais itens para prosseguir!');
  }

  const quantity = prompt('Insira a quantidade desejada:');

  const response = await fetch (`/api/orders/store` , {
    method: 'POST',
    body: new URLSearchParams({
      products: productSelected.toString(),
      quantity: quantity
    })
  })

  const responseJSON = await response.json();

  if (!responseJSON.success) {
    return alert('Ocorreu um erro inesperado ao tentar atualizar o produto!');
  }

  alert(responseJSON.success.message);
  return window.location.replace('/pedidos');
}