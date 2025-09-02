const API_BASE = '/api'; // базовый путь к API

export async function getAllProducts() {
  const res = await fetch(`${API_BASE}/products`);
  if (!res.ok) throw new Error('Ошибка получения продуктов');
  return await res.json();
}

export async function getProduct(id) {
  const res = await fetch(`${API_BASE}/product/${id}`);
  if (!res.ok) throw new Error('Ошибка получения продукта');
  return await res.json();
}

export async function createProduct(data, files = []) {
  let body;
  let headers = {};

  if (data instanceof FormData) {
    // если сразу FormData — просто используем её
    body = data;
  } else if (files.length > 0) {
    body = new FormData();
    Object.entries(data).forEach(([key, value]) => {
      body.append(key, value);
    });
    files.forEach(file => body.append('cover[]', file));
  } else {
    headers['Content-Type'] = 'application/json';
    body = JSON.stringify(data);
  }

  const res = await fetch(`${API_BASE}/products`, {
    method: 'POST',
    credentials: 'include',
    headers,
    body
  });

  if (!res.ok) throw new Error('Ошибка создания продукта');
  return await res.json();
}



export async function updateProduct(id, data) {
  let body;
  let headers = {};

  if (data instanceof FormData) {
    // если сразу FormData — просто используем её
    body = data;
  } else if (files.length > 0) {
    body = new FormData();
    Object.entries(data).forEach(([key, value]) => {
      body.append(key, value);
    });
    files.forEach(file => body.append('cover[]', file));
  } else {
    headers['Content-Type'] = 'application/json';
    body = JSON.stringify(data);
  }
  const res = await fetch(`${API_BASE}/products/${id}`, {
    method: 'PUT',
    credentials: 'include', // сессия
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error('Ошибка обновления продукта');
  return await res.json();
}

export async function deleteProduct(id) {
  const res = await fetch(`${API_BASE}/products/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Ошибка удаления продукта');
  return await res.json();
}
