
// Show and hidden password  :---------
document.addEventListener("DOMContentLoaded", function () {
    const passwordWrappers = document.querySelectorAll(".password_wrapper");

    passwordWrappers.forEach(wrapper => {
        const input = wrapper.querySelector("input");
        const eyeOpen = wrapper.querySelector(".eyeOpen");
        const eyeClosed = wrapper.querySelector(".eyeClosed");

        if(input && eyeOpen && eyeClosed){
            eyeOpen.addEventListener("click", () => {
                input.type = "text";
                eyeOpen.classList.add("d-none");
                eyeClosed.classList.remove("d-none");
            });

            eyeClosed.addEventListener("click", () => {
                input.type = "password";
                eyeClosed.classList.add("d-none");
                eyeOpen.classList.remove("d-none");
            });
        }
    });
});
// Show and hidden password  :---------




// On Upload profile iamge in Registeration :---------
document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.getElementById('fileInput');
    const uploadBox = document.querySelector('.upload-box');

    fileInput.addEventListener('change', function() {
        if (fileInput.files && fileInput.files.length > 0) {
            uploadBox.classList.add('uploaded'); 
        } else {
            uploadBox.classList.remove('uploaded'); 
        }
    });
});
// On Upload profile iamge in Registeration :---------