Общая схема перевода:
1. Пользователь выбирает язык (или он подставляется по умолчанию)
→ 2. Устанавливается локаль
→ 3. Загружаются файлы переводов (или данные из БД)
→ 4. Вызывается переводчик
→ 5. Получается строка перевода и показывается на экране

Подробно и с примерами:
✅ Шаг 1: Определение языка
Определяем, какой язык использовать:

$lang = $_GET['lang'] ?? $_SESSION['locale'] ?? 'ru';
➡️ этот язык сохраняется в сессию:

$_SESSION['locale'] = $lang;


✅ Шаг 2: Создание и настройка переводчика
Нужно создать объект Translator из Symfony и установить язык:

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$translator = new Translator($lang); // ← тут подставляется текущий язык
$translator->addLoader('yaml', new YamlFileLoader());

// Добавляем файлы перевода
$translator->addResource('yaml', __DIR__ . '/translations/messages.ru.yaml', 'ru');
$translator->addResource('yaml', __DIR__ . '/translations/messages.en.yaml', 'en');

// Сохраняем глобально для доступа везде
setTranslator($translator);
🔸 Где messages.ru.yaml выглядит так:

navigation:
  home: "Главная"
  cart: "Корзина"



✅ Шаг 3: Использование переводчика
Используем свою helper-функцию __():


echo __('navigation.home'); // ← это вызов  функции

А внутри этой функции:
function __(string $key, array $params = [], string $domain = 'messages'): string {
  return setTranslator()->trans($key, $params, $domain);
}

Это вызывает Symfony Translator, который ищет перевод в нужном домене и нужном языке.

✅ Шаг 4: Показ на экране
Функция __('ключ') возвращает строку, которую ты подставляешь в шаблон:

<h1><?= __('navigation.home') ?></h1>
Если перевод найден — покажется строка "Главная"
Если нет — покажется сам ключ: navigation.home

🧠 Где может быть ошибка?
Вот где часто ломается:

№	Проблема	Что проверить
1	Неправильно выбран язык	var_dump($_SESSION['locale']), echo $translator->getLocale()
2	Не добавлены файлы перевода	Убедись, что addResource(...) вызывается
3	Не тот путь к YAML-файлу	Проверь абсолютный путь: __DIR__ . '/translations/messages.ru.yaml'
4	Нет нужного ключа в YAML	Проверь, есть ли navigation.home в файле
5	Функция setTranslator() не вызывалась	Убедись, что setTranslator($translator) был вызван ДО контроллера
6	Ты вызываешь getTranslator() вместо setTranslator()	У тебя нет getTranslator(), только setTranslator() без аргумента
7	Кэш	Symfony может кэшировать переводы, попробуй удалить var/cache/* (если используешь фреймворк)

📌 Для уверенности — пошаговая проверка:
✅ В index.php или bootstrap.php:

php
Копировать
Редактировать
$lang = $_SESSION['locale'] ?? 'ru';
$translator = new Translator($lang);
$translator->addLoader('yaml', new YamlFileLoader());
$translator->addResource('yaml', __DIR__ . '/../translations/messages.ru.yaml', 'ru');
$translator->addResource('yaml', __DIR__ . '/../translations/messages.en.yaml', 'en');

setTranslator($translator);
✅ Файл helpers.php:

php
Копировать
Редактировать
function setTranslator($t = null) {
    static $translator;
    if ($t !== null) {
        $translator = $t;
    }
    return $translator;
}

function __(string $key, array $params = [], string $domain = 'messages'): string {
  return setTranslator()->trans($key, $params, $domain);
}
✅ В шаблоне:

php
Копировать
Редактировать
<h1><?= __('navigation.home') ?></h1>
✅ Файл translations/messages.ru.yaml:

yaml
Копировать
Редактировать
navigation:
  home: "Главная"
✅ Как быстро проверить, работает ли:
В index.php перед загрузкой страницы:

php
Копировать
Редактировать
echo __('navigation.home'); 
exit;
Если увидишь "Главная" — значит всё работает, и дело в контроллере/порядке вызова.
Если увидишь "navigation.home" — значит перевод не подгрузился.