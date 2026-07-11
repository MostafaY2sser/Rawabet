


// Show attachment uploaded :------------------------
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('input[type="file"]');

        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const countDiv = document.getElementById(input.id + '_count');
                const previewDiv = document.getElementById(input.id + '_preview');

                if (countDiv) {
                    countDiv.textContent = input.files.length > 0 ? 'عدد الملفات: ' + input.files.length : '';
                }

                if (previewDiv) {
                    previewDiv.innerHTML = '';

                    Array.from(input.files).forEach(file => {
                        const fileExt = file.name.split('.').pop().toLowerCase();
                        const imageExtensions = ['jpg', 'jpeg', 'png'];

                        if (imageExtensions.includes(fileExt)) {
                            // Display image
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.width = '130px';
                                img.style.height = '80px';
                                img.style.objectFit = 'cover';
                                img.style.borderRadius = '6px';
                                img.style.margin = '5px';
                                previewDiv.appendChild(img);
                            }
                            reader.readAsDataURL(file);
                        } else {
                            // Display file icon + name + size
                            const fileWrapper = document.createElement('div');
                            fileWrapper.style.display = 'flex';
                            fileWrapper.style.alignItems = 'center';
                            fileWrapper.style.gap = '5px';
                            fileWrapper.style.marginBottom = '5px';

                            const icon = document.createElement('div');
                            icon.innerHTML = '📄'; 
                            icon.style.fontSize = '20px';

                            const fileInfo = document.createElement('div');
                            fileInfo.textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';
                            fileInfo.style.fontSize = '14px';

                            fileWrapper.appendChild(icon);
                            fileWrapper.appendChild(fileInfo);

                            previewDiv.appendChild(fileWrapper);
                        }
                    });
                }
            });
        });
    });
// Show attachment uploaded :------------------------

    
// Minmum 3 images :------------
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.querySelector('form');
        const currentImgInput = document.getElementById('curent_img');

        form.addEventListener('submit', function (e) {

            // if (currentImgInput.files.length < 3) {
            //     e.preventDefault();
            //     alert('يرجى رفع 3 صور على الأقل للموقع/العقار');
            //     currentImgInput.focus();
            //     return;
            // }

        });

    });
// Minmum 3 images :------------


// ------------------------------------------------------ 
//  Open popup for contact with consultant :--- 
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector('#consultant_message').addEventListener("click", function (e) {
            e.preventDefault();
            document.querySelector('.consultant_message').classList.add("show");
        });
    });

// Close popup for contact with consultant :---  
    document.addEventListener("DOMContentLoaded", function () {
        const consultantPopup = document.querySelector('.consultant_message');

        document.querySelectorAll('.close, .cancel').forEach(button => {
            button.addEventListener("click", function (e) {
            e.preventDefault();
            consultantPopup.classList.remove("show");
            });
        });
    });
// ------------------------------------------------------ 






// ------------------------------------------------------ 
//  Open popup for change Inspection  :--- 
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector('.change_inspection').addEventListener("click", function (e) {
            e.preventDefault();
            document.querySelector('.request_inspection').classList.add("show");
        });
    });

    // Close popup for contact with consultant :---  
    document.addEventListener("DOMContentLoaded", function () {
        const consultantPopup = document.querySelector('.request_inspection');

        document.querySelectorAll('.close_change_popup, .request_inspection .cancel').forEach(button => {
            button.addEventListener("click", function (e) {
            e.preventDefault();
            consultantPopup.classList.remove("show");
            });
        });
    });


  flatpickr("#inlineCalendar", {
    inline: true,
    dateFormat: "Y-m-d",
    minDate: "today"
  });
// ------------------------------------------------------ 




// ------------------------------------------------------ 
    // open
    function previewFile(fileName) {
      window.open(`${fileName}`, '_blank')
    }

    // download
    function downloadFile(fileName) {
      const link = document.createElement('a')
      link.href = `${fileName}`
      link.download = fileName
      link.click()
    }
// ------------------------------------------------------ 








