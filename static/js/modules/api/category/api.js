const API_BASE = '/api'; // базовый путь к API

// Получение всех категорий
export async function getAllCategory() {
  const res = await fetch(`${API_BASE}/categories`);
  if (!res.ok) throw new Error('Ошибка получения списка категорий');
  return await res.json();
}
// Получить список подкатегорий
export async function getCategory(id) {
  const res = await fetch(`${API_BASE}/categories/${id}/subcategories`);
  if (!res.ok) throw new Error('Ошибка получения списка подкатегорий');
  return await res.json();
}
// Получить одну категорию
export async function getCategory(id) {
  const res = await fetch(`${API_BASE}/categories/${id}`);
  if (!res.ok) throw new Error('Ошибка получения категории');
  return await res.json();
}

// Создать категорию (указать parent_id для подкатегории)
export async function createCategory(data) {
  const res = await fetch(`${API_BASE}/categories`, {
    method: 'POST',
    credentials: 'include', // сессия
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error('Ошибка создания категории');
  return await res.json();
}
// Обновить категорию
export async function updateCategory(id, data) {
  const res = await fetch(`${API_BASE}/categories/${id}`, {
    method: 'PUT',
    credentials: 'include', // сессия
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error('Ошибка обновления категории');
  return await res.json();
}

export async function deleteCategory(id) {
  const res = await fetch(`${API_BASE}/categories/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Ошибка удаления продукта');
  return await res.json();
}
