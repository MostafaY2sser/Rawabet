
    // next and back Step :-
    const steps = [
        document.querySelector('.step_one'),
        document.querySelector('.step_two'),
        document.querySelector('.step_three'),
        document.querySelector('.setp_four'),
        document.querySelector('.step_five'),
        document.querySelector('.step_six'),
    ];
    let currentStep = 0;

    // Next Step :-
    document.querySelectorAll('.next_step').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                steps[currentStep].classList.add('d-none'); 
                currentStep++;
                steps[currentStep].classList.remove('d-none'); 
            }
        });
    });

    // Back Step :-
    document.querySelectorAll('.back_cancel').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                steps[currentStep].classList.add('d-none');
                currentStep--;
                steps[currentStep].classList.remove('d-none');
            }
        });
    });




    //  on upload file documents :-
    document.querySelectorAll(".upload_documents input[type='file']").forEach((fileInput) => {
        const uploadBox = fileInput.closest(".upload_documents_box");

        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                uploadBox.classList.add("success-border");
            } else {
                uploadBox.classList.remove("success-border");
            }
        });
    });






    // Dropdown project Fillter :-
        class ArabicDropdown {
        constructor() {
            this.button = document.getElementById('dropdownButton');
            this.menu = document.getElementById('dropdownMenu');
            this.text = document.getElementById('selectedText');
            this.items = document.querySelectorAll('.dropdown-item');
            this.value = this.text.textContent;
            this.isOpen = false;
            this.init();
        }

        init() {
            this.button.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggle();
            });

            this.items.forEach(item => {
            item.addEventListener('click', (e) => {
                e.stopPropagation();
                this.selectItem(item);
            });
            });

            document.addEventListener('click', () => this.close());
            document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.close();
            });
        }

        toggle() {
            this.isOpen = !this.isOpen;
            this.button.classList.toggle('active', this.isOpen);
            this.menu.classList.toggle('show', this.isOpen);
        }

        close() {
            this.isOpen = false;
            this.button.classList.remove('active');
            this.menu.classList.remove('show');
        }

        selectItem(item) {
            this.value = item.getAttribute('data-value');
            this.text.textContent = this.value;

            this.items.forEach(i => i.classList.remove('selected'));
            item.classList.add('selected');
            this.close();

            const event = new CustomEvent('dropdownChange', {
            detail: { value: this.value }
            });
            this.button.dispatchEvent(event);
        }

        getValue() {
            return this.value;
        }

        setValue(value) {
            const item = document.querySelector(`[data-value="${value}"]`);
            if (item) this.selectItem(item);
        }
        }

        document.addEventListener('DOMContentLoaded', () => {
        const dropdown = new ArabicDropdown();
        dropdown.button.addEventListener('dropdownChange', (e) => {
            console.log('Selected:', e.detail.value);
        });
        });


        