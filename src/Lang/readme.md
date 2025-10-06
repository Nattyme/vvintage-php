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
Функция __('ключ') возвращает строку, которая подставляется в шаблон:

<h1><?= __('navigation.home') ?></h1>
Если перевод найден — покажется строка "Главная"
Если нет — покажется сам ключ: navigation.home

