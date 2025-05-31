let files = [];
const previewList = document.getElementById('preview-list');
const dropArea = document.getElementById('drop-area');

dropArea.addEventListener('dragover', (e) => {
	e.preventDefault();
	dropArea.classList.add('highlight');
});

dropArea.addEventListener('drop', (e) => {
	e.preventDefault();
	dropArea.classList.remove('highlight');

	const droppedFiles = [...e.dataTransfer.files];

	files.push(...droppedFiles);
	renderPreview();
});

function renderPreview() {
	previewList.innerHTML = '';

	files.forEach((file, index) => {
		const li = document.createElement('li');
		li.setAttribute('draggable', 'true');
		li.dataset.index = index;

		const img = document.createElement('img');
		img.src = URL.createObjectURL(file);
		img.style.maxWidth = '100%';
		img.style.pointerEvents = 'none';

		li.appendChild(img);
		previewList.appendChild(li);
	});
	addDragHandlers();
}

function addDragHandlers() {
	let draggedIndex;

	previewList.querySelectorAll('li').forEach((li) => {
		li.addEventListener('dragstart', (e) => {
			draggedIndex = e.target.dataset.index;
			e.dataTransfer.effectAllowed = 'move';
		});

		li.addEventListener('dragover', (e) => {
			e.preventDefault();
		});

		li.addEventListener('drop', (e) => {
			e.preventDefault();
			const droppedIndex = e.target.closest('li').dataset.index;
			[files[draggedIndex], files[droppedIndex]] = [
				files[droppedIndex],
				files[draggedIndex],
			];

			renderPreview();
		});
	});
}

document.getElementById('upload-form').addEventListener('submit', (e) => {
	e.preventDefault();
	const formData = new FormData();

	files.forEach((file) => {
		formData.append('images[]', file);
	});

	// порядок
	const order = files.map((_, i) => i); // [0, 1, 2, 3]
	formData.append('order', JSON.stringify(order));

	fetch('upload.php', {
		method: 'POST',
		body: formData,
	})
		.then((res) => res.json())
		.then((data) => {
			alert('Загружено!');
		});
});
