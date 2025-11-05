import model from "./brands.model.js";
import view from "./brands.view.js";

const initBrandsEvents = async () => {
  if (!model || !view) return;
  const brands = await model.setBrands();

  if (!brands) return;
  const brandsBlock = view.getBrandsBlock();

  if (!brandsBlock) return;

  // Заполним опции для селекта брендов.
  view.setBrandsOptions(brands, brandsBlock);
};

export default initBrandsEvents;
