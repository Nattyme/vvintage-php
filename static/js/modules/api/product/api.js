const API_BASE = '/api'; // базовый путь к API

export async function getAllProducts() {
  const res = await fetch(`${API_BASE}/products`);
  if (!res.ok) throw new Error('Ошибка получения продуктов');
  return await res.json();
}

export async function getProduct(id) {
  const res = await fetch(`${API_BASE}/products/${id}`);
  if (!res.ok) throw new Error('Ошибка получения продукта');
  return await res.json();
}

export async function createProduct(formData) {
  const res = await fetch(`${API_BASE}/products`, {

    method: 'POST',
    credentials: 'include',
    body: formData
  });

  let responseData;
  try {
    responseData = await res.json();
  } catch (e) {
    // сервер не вернул JSON — создаём объект с ошибкой
    return {
      success: false,
      errors: {global: 'Сервер вернул некорректный ответ'}
    }

  }
  // Возвращаем ответ даже при ошибке статуса (например, 422)
  return responseData;
}


// export async function createProduct(data, files = []) {

//   let body;
//   let headers = {};

//   if (data instanceof FormData) {
//     // если сразу FormData — просто используем её
//     body = data;
//   } else if (files.length > 0) {
//     body = new FormData();
//     Object.entries(data).forEach(([key, value]) => {
//       body.append(key, value);
//     });
//     files.forEach(file => body.append('cover[]', file));
//   } else {
//     headers['Content-Type'] = 'application/json';
//     body = JSON.stringify(data);
//   }

//   const res = await fetch(`${API_BASE}/products`, {
//     method: 'POST',
//     credentials: 'include',
//     headers,
//     body
//   });

//    let responseData;
//     try {
//       responseData = await res.json(); // читаем тело даже при ошибке
//     } catch (e) {
//       throw new Error('Сервер вернул некорректный ответ');
//     }

//     if (!res.ok) {
//       // бросаем сам JSON с ошибками, чтобы поймать его в catch
//       throw responseData;
//     }

//     return responseData;



//   // if (!res.ok) throw new Error('Ошибка создания продукта');
//   // return await res.json();
// }

export async function updateProduct(id, formData) {
  // formData.append('_method', 'PUT');
  const res = await fetch(`${API_BASE}/products/${id}`, {
    method: 'POST',
    credentials: 'include',
    body: formData
  });

  const responseData = await res.json();
  
  if (!res.ok) throw responseData;
  return responseData;
}

export async function deleteProduct(id) {
  const res = await fetch(`${API_BASE}/products/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Ошибка удаления продукта');
  return await res.json();
}
