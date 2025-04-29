function yMap() {
  
  initMap();

  async function initMap() {
      // Промис `ymaps3.ready` будет зарезолвлен, когда загрузятся все компоненты основного модуля API
      await ymaps3.ready;
      const {YMap, YMapDefaultSchemeLayer, YMapDefaultFeaturesLayer} = ymaps3;

      // Иницилиазируем карту
      const map = new YMap(
          // Передаём ссылку на HTMLElement контейнера
          document.getElementById('map'),

          // Передаём параметры инициализации карты
          {
              location: {
                  // Координаты центра карты
                  center: [2.406281, 48.866638],
                 
                  controls: ['zoomControl'],
                  zoomRange: { min: 2, max: 16 }, // Допустимые уровни масштабирования

                  // Уровень масштабирования
                  zoom: 16
              }
          }
      );
      

 
      // Добавляем слой для отображения схематической карты
      map.addChild(new YMapDefaultSchemeLayer());
   
  // Добавляем слой объектов
map.addChild(new YMapDefaultFeaturesLayer())

// Подключение модуля меток
  const {YMapDefaultMarker} = (await ymaps3.import('@yandex/ymaps3-markers@0.0.1'));

// Создание метки
const myPlacemark = new YMapDefaultMarker({
  "coordinates": [2.406281, 48.866638],
  "color": "red",
  "title": "Womazing",
  "subtitle": "интернет-магазин"
});

// Добавление метки на карту
map.addChild(myPlacemark);

  }
}

export default yMap;