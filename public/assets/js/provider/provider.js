

// ------------------------------------------------------ 
// on upload file documents :-
  document.querySelectorAll(".upload_documents input[type='file']").forEach((fileInput) => {
      const uploadBox = fileInput.closest(".upload_documents_box");

      if ( fileInput != null ) {
        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                uploadBox.classList.add("success-border");
            } else {
                uploadBox.classList.remove("success-border");
            }
        });
      }
    });
// ------------------------------------------------------ 





// ------------------------------------------------------ 
// show and hidden daily Button :---
const dotToggle = document.getElementById("dot-toggle");
const dailyBtn = document.getElementById("daily-btn");

if(dotToggle != null){
dotToggle.addEventListener("click", () => {
    dailyBtn.classList.toggle("d-none");
});
}
// ------------------------------------------------------ 



// ------------------------------------------------------ 
// For sidebar Dropdown mune :-
 function toggleDropdown(event) {
    event.preventDefault();
    const parent = event.currentTarget.closest('.drodown');
    const menu = parent.querySelector('.drodown_mune');

    menu.classList.toggle('show');
    parent.classList.toggle('open');
}
// ------------------------------------------------------ 




// ------------------------------------------------------ 
// Dropdown project Fillter :-
        // class ArabicDropdown {
        // constructor() {
        //     this.button = document.getElementById('dropdownButton');
        //     this.menu = document.getElementById('dropdownMenu');
        //    if(this.text != null){

        //     this.text = document.getElementById('selectedText');
        //     this.items = document.querySelectorAll('.dropdown-item');
        //     this.value = this.text.textContent;
        //     this.isOpen = false;
        //     this.init();
        //    }

        // }

        // init() {
        //     this.button.addEventListener('click', (e) => {
        //     e.stopPropagation();
        //     this.toggle();
        //     });

        //     this.items.forEach(item => {
        //     item.addEventListener('click', (e) => {
        //         e.stopPropagation();
        //         this.selectItem(item);
        //     });
        //     });

        //     document.addEventListener('click', () => this.close());
        //     document.addEventListener('keydown', (e) => {
        //     if (e.key === 'Escape') this.close();
        //     });
        // }

        // toggle() {
        //     this.isOpen = !this.isOpen;
        //     this.button.classList.toggle('active', this.isOpen);
        //     this.menu.classList.toggle('show', this.isOpen);
        // }

        // close() {
        //     this.isOpen = false;
        //     this.button.classList.remove('active');
        //     this.menu.classList.remove('show');
        // }

        // selectItem(item) {
        //     this.value = item.getAttribute('data-value');
        //     this.text.textContent = this.value;

        //     this.items.forEach(i => i.classList.remove('selected'));
        //     item.classList.add('selected');
        //     this.close();

        //     const event = new CustomEvent('dropdownChange', {
        //     detail: { value: this.value }
        //     });
        //     this.button.dispatchEvent(event);
        // }

        // getValue() {
        //     return this.value;
        // }

        // setValue(value) {
        //     const item = document.querySelector(`[data-value="${value}"]`);
        //     if (item) this.selectItem(item);
        // }
        // }

        // document.addEventListener('DOMContentLoaded', () => {
        // const dropdown = new ArabicDropdown();
        // dropdown.button.addEventListener('dropdownChange', (e) => {
        //     console.log('Selected:', e.detail.value);
        // });
        // });
// ------------------------------------------------------ 









//  Aside :---------------------------------------
const iconToggleAside = document.getElementById('icon_toggle_aside');
const asideBar = document.getElementById('asideBar');
const mainPage = document.getElementById('main_page');

// Calc.. Sice Devce and Add , Remove class Active
function toggleActiveByScreen() {
    if (window.innerWidth <= 992) {
        asideBar?.classList.add('active');
        mainPage?.classList.add('active');
    } else {
        asideBar?.classList.remove('active');
        mainPage?.classList.remove('active');
    }
}

// onLoad Page :----
toggleActiveByScreen();

// on Change Size Page :------
window.addEventListener('resize', toggleActiveByScreen);

// Button  iconToggleAside :----
if (iconToggleAside != null) {
    iconToggleAside.addEventListener("click", () => {
        asideBar?.classList.toggle('active');
        mainPage?.classList.toggle('active');
    });
}
//  Aside :---------------------------------------









// ------------------------------------------------------ 
// Show and hidden password on click Eye in Login Page :---
const passwordInput = document.getElementById("password");
  const showEye = document.getElementById("showEye");
  const hideEye = document.getElementById("hideEye");
if(showEye != null){

  showEye.addEventListener("click", () => {
    passwordInput.type = "text";
    showEye.classList.add("d-none");
    hideEye.classList.remove("d-none");
  });

  hideEye.addEventListener("click", () => {
    passwordInput.type = "password";
    hideEye.classList.add("d-none");
    showEye.classList.remove("d-none");
  });
}
// ------------------------------------------------------ 
    




