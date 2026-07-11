
const fileInput = document.getElementById('fileInput');
const saveBtn = document.getElementById('saveBtn');

fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        saveBtn.style.display = 'inline-block'; 
    } else {
        saveBtn.style.display = 'none'; 
    }
});
