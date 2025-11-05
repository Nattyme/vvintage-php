import router from "./router";

const addNavigate = (section) => {
 
  // меням url
  history.pushState({}, `Панель администратора - ${section}`, `?${section}`);
  router();
}

export default addNavigate;