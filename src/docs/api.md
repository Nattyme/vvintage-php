GET	/categories	список всех категорий
GET	/categories/{id}	получить одну категорию
GET	/categories/{id}/subcategories	список подкатегорий категории
POST	/categories	создать категорию (указать parent_id для подкатегории)
PUT	/categories/{id}	обновить категорию
DELETE	/categories/{id}	удалить категорию

GET	/brands	список всех брендов
GET	/brands/{id}	получить один бренд

GET	/products	список всех продуктов
GET	/products/{id}	получить один продукт
POST	/products	создать продукт
PUT	/products/{id}	обновить продукт
DELETE	/products/{id}	удалить продукт