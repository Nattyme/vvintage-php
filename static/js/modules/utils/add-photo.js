function addPhoto () {
  const addPhotoBtn = document.querySelector('#btn-add-photo');
  if(!addPhotoBtn) return;
  const fileInput = addPhotoBtn.nextElementSibling;

  addPhotoBtn.addEventListener('click', function(e) {
    e.preventDefault(); 
    fileInput.click();
  });
}

export default addPhoto;

