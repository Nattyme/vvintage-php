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
    throw new Error('Сервер вернул не-JSON (возможно HTML-ошибка или редирект)');
  }

  if (!res.ok) throw responseData;
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


// export async function updateProduct(id, data, files = []) {
//   let body;

//   if (data instanceof FormData) {
//     body = data;
//   } else {
//     body = new FormData();
//     Object.entries(data).forEach(([key, value]) => body.append(key, value));
//   }

//   // добавляем файлы, если есть
//   if (files.length > 0) {
//     files.forEach(file => body.append('cover[]', file));
//   }

//   // обязательно поле _method для PHP
//   body.append('_method', 'PUT');

//   console.log("Отправляем body:");
//   for (let [key, value] of body.entries()) {
//     console.log(key, value);
//   }

//   const res = await fetch(`${API_BASE}/products/${id}`, {
//     method: 'POST', // отправляем POST, сервер увидит _method=PUT
//     credentials: 'include',
//     body, // FormData — без headers
//   });

//   let responseData;
//   try {
//     responseData = await res.json();
//   } catch (e) {
//     throw new Error('Сервер вернул некорректный ответ');
//   }

//   if (!res.ok) throw responseData;
//   return responseData;
// }


// export async function updateProduct(id, data) {
//   const body = new FormData();

//   // добавляем все поля из объекта data
//   Object.entries(data).forEach(([key, value]) => body.append(key, value));

//   // обязательно поле _method для PUT
//   body.append('_method', 'PUT');

//   // если есть файлы внутри data, например data.files — добавь их
//   if (data.files) {
//     data.files.forEach(file => body.append('cover[]', file));
//   }

//   console.log("Отправляем body:");
//   for (let [key, value] of body.entries()) {
//     console.log(key, value);
//   }

//   const res = await fetch(`${API_BASE}/products/${id}`, {
//     method: 'POST', // отправляем POST, PHP увидит _method=PUT
//     credentials: 'include',
//     body, // без headers
//   });

//   let responseData;
//   try {
//     responseData = await res.json();
//   } catch (e) {
//     throw new Error('Сервер вернул некорректный ответ');
//   }

//   if (!res.ok) throw responseData;
//   return responseData;
// }


// export async function updateProduct(id, data) {
//   let body;
//   let headers = {};

//   if (data instanceof FormData) {
//     body = data;
//     // добавляем _method=PUT, чтобы сервер понял
//     body.append('_method', 'PUT');
//   } else {
//     // если просто объект без файлов
//     body = new FormData();
//     Object.entries(data).forEach(([key, value]) => body.append(key, value));
//     body.append('_method', 'PUT');
//     // headers['Content-Type'] = 'application/json';
//     // body = JSON.stringify(data);
//   }
// console.log("Отправляем body:");
// if (body instanceof FormData) {
//   for (let [key, value] of body.entries()) {
//     console.log(key, value);
//   }
// } else {
//   console.log(body);
// }
//   const res = await fetch(`${API_BASE}/products/${id}`, {
//     method: 'POST', // выжноЖ отправить POST
//     credentials: 'include',
//     headers,
//     body,
//   });

//   let responseData;
//   try {
//     responseData = await res.json();
//   } catch (e) {
//     throw new Error('Сервер вернул некорректный ответ');
//   }

//   if (!res.ok) throw responseData;
//   return responseData;
// }



// export async function updateProduct(id, data) {
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
//   console.log("Отправляем данные:", data);
//   for (let pair of data.entries()) {
//     console.log(pair[0], pair[1]);
//   }

//   const res = await fetch(`${API_BASE}/products/${id}`, {
//     method: 'PUT',
//     credentials: 'include', // сессия
//     body: JSON.stringify(data),
//   });
//   if (!res.ok) throw new Error('Ошибка обновления продукта');
//   return await res.json();
// }

export async function deleteProduct(id) {
  const res = await fetch(`${API_BASE}/products/${id}`, {
    method: 'DELETE',
  });
  if (!res.ok) throw new Error('Ошибка удаления продукта');
  return await res.json();
}
