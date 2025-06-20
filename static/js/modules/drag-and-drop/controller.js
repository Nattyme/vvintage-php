import initView from './view.js';
import initModel from "./model.js";

const initDragDropEvents = () => {
  const view = initView();
  const model = initModel();
  // Если нет контейнера dragg-and-drop - дальше код не выполнять
  const container = view.getContainer();
  if(!container) return;

  //Следим за изменением контейнера изображений
  model.createObserver(container, model.onFilesUploaded);
}

export default initDragDropEvents;