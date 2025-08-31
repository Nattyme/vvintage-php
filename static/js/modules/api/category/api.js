const API_BASE = '/api'; // базовый путь к API

export async function getAllCategory() {
  const res = await fetch(`${API_BASE}/products`);
  if (!res.ok) throw new Error('Ошибка получения продуктов');
  return await res.json();
}

export async function getCategory(id) {
  const res = await fetch(`${API_BASE}/product/${id}`);
  if (!res.ok) throw new Error('Ошибка получения продукта');
  return await res.json();
}

export async function createCategory(data) {
  const res = await fetch(`${API_BASE}/product-new`, {
    method: 'POST',
    credentials: 'include', // сессия
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error('Ошибка создания продукта');
  return await res.json();
}

export async function updateCategory(id, data) {
  const res = await fetch(`${API_BASE}/product-edit/${id}`, {
    method: 'PUT',
    credentials: 'include', // сессия
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error('Ошибка обновления продукта');
  return await res.json();
}

export async function deleteCategory(id) {
  const res = await fetch(`${API_BASE}/product/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Ошибка удаления продукта');
  return await res.json();
}
