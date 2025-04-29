const mobileNav = () => {
  const cats = [
    {
      'id' : '1',
      'name' : 'Для Женщин',
      'subCats' :  [
        {
          'id' : '-1',
          'name' : 'Все категории',
          'icon' : 'category_all',
          'subSubCats' : []
        }, 
        {
          'id' : '7',
          'name' : 'Сумки',
          'icon' : 'bag',
          'subSubCats' : [{'id' : '22', 'name' : 'Рюкзак'}, {'id' : '23', 'name' : 'Клатч'},{'id' : '24', 'name' : 'Портмоне'}]
        },
        {
          'id' : '8',
          'name' : 'Очки',
          'icon' : 'glasses',
          'subSubCats' : [{'id' : '32', 'name' : 'Авиаторы'}, {'id' : '33', 'name' : 'Круглые'},{'id' : '34', 'name' : 'Коллекционные'}]
        },
        {
          'id' : '9',
          'name' : 'Часы',
          'icon' : 'watch',
          'subSubCats' : [{'id' : '42', 'name' : 'На ремешке'}, {'id' : '43', 'name' : 'Металлические'},{'id' : '34', 'name' : 'С драгоценными вставками'}]
        },
        {
          'id' : '10',
          'name' : 'Бижутерия',
          'icon' : 'earrings',
          'subSubCats' : [{'id' : '52', 'name' : 'Кольца'}, {'id' : '53', 'name' : 'Колье'},{'id' : '54', 'name' : 'Серьги'}]
        },
    
        {
          'id' : '11',
          'name' : 'Косметика',
          'icon' : 'cosmetics',
          'subSubCats' : [{'id' : '62', 'name' : 'Крем'}, {'id' : '63', 'name' : 'Тушь'},{'id' : '64', 'name' : 'Помада'}]
        }
    
      ],
    },
    {
      'id' : '2',
      'name' : 'Для Мужчин',
      'subCats' :  [
        {
          'id' : '-1',
          'name' : 'Все категории',
          'icon' : 'category_all',
          'subSubCats' : []
        }, 
      
        {
          'id' : '13',
          'name' : 'Очки',
          'icon' : 'glasses_men',
          'subSubCats' : [{'id' : '92', 'name' : 'Авиаторы'}, {'id' : '93', 'name' : 'Круглые'}, {'id' : '94', 'name' : 'Коллекционные'}]
        },
        {
          'id' : '14',
          'name' : 'Часы',
          'icon' : 'watch_man',
          'subSubCats' : [{'id' : '102', 'name' : 'На ремешке'}, {'id' : '103', 'name' : 'Металлические'}, {'id' : '104', 'name' : 'Карманные'}]
        },
        {
          'id' : '15',
          'name' : 'Ремни',
          'icon' : 'belt',
          'subSubCats' : [{'id' : '112', 'name' : 'Кожанные'}, {'id' : '113', 'name' : 'Классика'},{'id' : '114', 'name' : 'Разные'}]
        },
    
        {
          'id' : '16',
          'name' : 'Галстуки',
          'icon' : 'necktie',
          'subSubCats' : [{'id' : '122', 'name' : 'Классика'}, {'id' : '123', 'name' : 'Шёлковые'}, {'id' : '124', 'name' : 'Бабочка'}]
        },
        {
          'id' : '17',
          'name' : 'Сумки',
          'icon' : 'suitcase',
          'subSubCats' : [{'id' : '132', 'name' : 'Рюкзак'}, {'id' : '133', 'name' : 'На плечо'}, {'id' : '134', 'name' : 'Дипломат'}]
        }
  
      ],
    },
    {
      'id' : '3',
      'name' : 'Для Детей',
      'subCats' :  [
        {
          'id' : '-1',
          'name' : 'Все категории',
          'icon' : 'category_all',
          'subSubCats' : []
        },
        {
          'id' : '18',
          'name' : 'Игрушки',
          'icon' : 'toy',
          'subSubCats' : [{'id' : '71', 'name' : 'Мягкие'}, {'id' : '75', 'name' : 'Пластмассовые'}, {'id' : '76', 'name' : 'Деревянные'}]
        }
      ],
    },
  ];

	// Mobile nav button
	const navBtn = document.querySelector('.mobile-nav-btn');
	const nav = document.querySelector('.mobile-nav');
	const menuIcon = document.querySelector('.nav-icon');
  const mobileNav = document.querySelector('.mobile-nav');
  const mobileNavList = document.querySelector('.mobile-nav__list');
  console.log(mobileNav);
  console.log(mobileNavList);
  

	navBtn.onclick =  () => {
		nav.classList.toggle('mobile-nav--open');
		menuIcon.classList.toggle('nav-icon--active');
		document.body.classList.toggle('no-scroll');
	};


  // Добавляем разметку основных категорий в навигацию

  mobileNavList.innerHTML = cats.map(cat => 

    
    `
      <li
        id="${cat.id}"
        class="mobile-nav__item"
        role="tab"
        area-selected="false"
        tabindex="0"
      >
      <a href="#" class="mobile-nav__link">
        <svg class="mobile-nav__icon icon icon--${cat.subCats[1].icon}">
          <use href="./img/svgsprite/sprite.symbol.svg#${cat.subCats[1].icon}"></use>
        </svg> 
        <span class="mobile-nav__subtitle">${cat.name}</span>
      </a>

    </li>
    `
  ).join(' ');
  

  console.log('');
  
}

export default mobileNav;