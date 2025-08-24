import Clipboard from 'clipboard';

document.addEventListener('DOMContentLoaded', function(){
    const btns = document.querySelectorAll('.js-share');

    btns.forEach(function(element) {
        let clipboard = new Clipboard(element);

        clipboard.on('success', function(e) {
            e.trigger.classList.add('text-success');

            setTimeout(function() {
                e.trigger.classList.remove('text-success')
            }, 5000)
        });
    });

    if(window.location.href.includes('/admin')) {
        const uploadFile = document.getElementById('uploadFile');
        const previewImage = document.getElementById('previewImage');
        const removeImage = document.getElementById('removeImage');
        const uploadContainer = document.getElementById('uploadContainer');
        const filepath =  document.getElementById('filepath');

        if (uploadFile && previewImage && removeImage) {
            uploadFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        removeImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeImage.addEventListener('click', function() {
                uploadFile.value = '';
                previewImage.src = '';
                filepath.value = '';
                previewImage.style.display = 'none';
                removeImage.style.display = 'none';
            });

            // Обработка перетаскивания файла
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
                this.classList.remove('border-dashed');
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                this.classList.add('border-dashed');
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                this.classList.add('border-dashed');

                if (e.dataTransfer.files.length) {
                    uploadFile.files = e.dataTransfer.files;
                    filepath.value = e.dataTransfer.files;
                    const event = new Event('change');
                    uploadFile.dispatchEvent(event);
                }
            });
        }


        const keyValueContainer = document.getElementById('keyValueContainer');
        const addKeyValueBtn = document.getElementById('addKeyValueBtn');
        const objectField = document.getElementById('objectField');

        function addKeyValuePair(key = '', value = '') {
            const pairId = Date.now() + Math.random().toString(36).substr(2, 5);
            const pairElement = document.createElement('div');
            pairElement.className = 'card mb-2 key-value-pair';
            pairElement.id = `pair-${pairId}`;
            pairElement.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label class="form-label small text-muted">Key</label>
                        <input type="text" class="form-control key-input" placeholder="Key..." value="${key}">
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0">
                        <label class="form-label small text-muted">Value</label>
                        <input type="text" class="form-control value-input" placeholder="Value..." value="${value}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-pair-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
            keyValueContainer.appendChild(pairElement);

            const removeBtn = pairElement.querySelector('.remove-pair-btn');
            removeBtn.addEventListener('click', function() {
                pairElement.remove();
                updateObjectField();
            });

            const keyInput = pairElement.querySelector('.key-input');
            const valueInput = pairElement.querySelector('.value-input');

            keyInput.addEventListener('input', updateObjectField);
            valueInput.addEventListener('input', updateObjectField);
        }

        function updateObjectField() {
            const pairs = document.querySelectorAll('.key-value-pair');
            const data = {};

            pairs.forEach(pair => {
                const keyInput = pair.querySelector('.key-input');
                const valueInput = pair.querySelector('.value-input');

                if (keyInput.value.trim() !== '') {
                    data[keyInput.value] = valueInput.value;
                }
            });

            objectField.value = JSON.stringify(data);
        }

        addKeyValueBtn.addEventListener('click', function() {
            addKeyValuePair();
        });

        // Загрузка существующих данных
        try {
            const existingData = JSON.parse(objectField.value);
            if (existingData && typeof existingData === 'object') {
                Object.keys(existingData).forEach(key => {
                    addKeyValuePair(key, existingData[key]);
                });
            }

            if (Object.keys(existingData).length === 0) {
                addKeyValuePair();
            }
        } catch (e) {
            console.error('error unserialze JSON:', e);
            addKeyValuePair();
        }

        document.getElementById('objectForm').addEventListener('submit', function(e) {
            updateObjectField();

            const pairs = document.querySelectorAll('.key-value-pair');
            let hasErrors = false;

            pairs.forEach(pair => {
                const keyInput = pair.querySelector('.key-input');
                const valueInput = pair.querySelector('.value-input');

                if (keyInput.value.trim() === '' && valueInput.value.trim() !== '') {
                    keyInput.classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    keyInput.classList.remove('is-invalid');
                }
            });

            if (hasErrors) {
                e.preventDefault();
            }
        });
    }

});
