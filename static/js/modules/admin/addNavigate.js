import router from "./router";

const addNavigate = (section) => {
  console.log('hello from navigate');

  // меням url
  history.pushState({}, `Панель администратора - ${section}`, `?${section}`);
  router();
}

export default addNavigate;