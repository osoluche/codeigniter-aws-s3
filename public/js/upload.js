document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('fileInput');
    const progressDiv = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const successMessage = document.getElementById('successMessage');
    const errorContainer = document.createElement('div');
    errorContainer.className = 'mt-4 p-4 text-red-600 bg-red-100 rounded-lg hidden';
    form.insertBefore(errorContainer, form.firstChild);

    function showError(message) {
        errorContainer.textContent = message;
        errorContainer.classList.remove('hidden');
        setTimeout(() => {
            errorContainer.classList.add('hidden');
        }, 5000);
    }

    function showSuccess() {
        successMessage.classList.remove('hidden');
        setTimeout(() => {
            window.location.href = '/dashboard';
        }, 2000);
    }

    // Client-side file validation
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file size
            if (file.size > 10485760) { // 10MB in bytes
                showError('File size exceeds maximum limit of 10MB');
                this.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = [
                'text/plain',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/pdf',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ];
            
            if (!allowedTypes.includes(file.type)) {
                showError('Invalid file type. Only txt, doc, pdf, xls, or pptx files are allowed.');
                this.value = '';
                return;
            }
        }
    });

    // Handle form submission and progress
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        progressDiv.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.textContent = '0%';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', this.action, true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressText.textContent = percentComplete + '%';
            }
        };

        xhr.onload = function() {
            const response = JSON.parse(xhr.responseText);
            if (xhr.status === 200 && response.success) {
                showSuccess();
            } else {
                showError(response.error || 'An error occurred during upload');
            }
            progressDiv.classList.add('hidden');
        };

        xhr.onerror = function() {
            showError('An error occurred during upload');
            progressDiv.classList.add('hidden');
        };

        xhr.send(formData);
    });
});