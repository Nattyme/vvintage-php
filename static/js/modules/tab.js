const addTab = () => {
 const tabs = document.querySelectorAll('[data-control="tab"]');
 if (!tabs) return;


 tabs.forEach(function(tab) {
  const tabButtons = document.querySelectorAll('[data-control="tab-button"]');
  const tabBlocks = document.querySelectorAll('[data-control="tab-block"]');

  tabButtons.forEach(function (item, index) {
    item.addEventListener('click', function() {
      const currentButton = item;
      const contentBlocks = document.querySelectorAll('[data-control="tab-block"]');
      const currentBlock = contentBlocks[index];

      if (!currentButton.classList.contains('active')) {
        tabButtons.forEach(function (item) {
          item.classList.remove('active');
        })

        tabBlocks.forEach(function (item) {
          item.classList.remove('active');
        })

        currentButton.classList.add('active');
        currentBlock.classList.add('active');
      }

    });
  })
 })
}

export default addTab;