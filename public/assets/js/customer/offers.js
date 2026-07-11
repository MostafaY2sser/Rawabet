document.addEventListener('DOMContentLoaded', function () {
    const allCards = document.querySelectorAll('.offer-card');
    const offerButtons = document.querySelectorAll('.choose-offer-btn');
    const selectOffer = document.querySelector('.select_offer');
    const selectedCompany = document.querySelector('.selected-company');
    const selectedPrice = document.querySelector('.selected-price');
    const selectedTax = document.querySelector('.selected-tax');
    const continuePay = document.querySelector('.continue-pay');
    const cancelBtn = document.querySelector('.cancel');

    const offerForm = document.getElementById('offer-selection-form');
    const offerIdInput = document.getElementById('selected-offer-id');
    const selectedServicesContainer = document.getElementById('selected-services');

    const allServicesSections = document.querySelectorAll('.additional-services');
    let basePrice = 0;
    let currentOfferId = null;

    function formatPrice(amount) {
        return Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotalPrice() {
        if (!currentOfferId) {
            return;
        }

        let subtotal = basePrice;
        const checkedBoxes = document.querySelectorAll(`.custom-checkbox[data-offer-id="${currentOfferId}"]:checked`);
        checkedBoxes.forEach(cb => {
            const priceElement = cb.closest('div').querySelector('b');
            if (priceElement) {
                const priceText = priceElement.textContent.replace(/[^\d.]/g, '').replace(/\./g, '');
                const price = parseFloat(priceText);
                if (!isNaN(price)) {
                    subtotal += price;
                }
            }
        });

        const selectedCard = document.querySelector(`.offer-card[data-offer-card="${currentOfferId}"]`);
        const taxRate = selectedCard ? parseFloat(selectedCard.dataset.taxRate) || 0 : 0;
        const tax = subtotal * (taxRate / 100);
        const totalWithTax = subtotal + tax;

        if (selectedCard) {
            const subtotalElement = selectedCard.querySelector('.offer-subtotal');
            const taxElement = selectedCard.querySelector('.offer-tax');
            const totalWithTaxElement = selectedCard.querySelector('.offer-total-with-tax');

            if (subtotalElement) {
                subtotalElement.textContent = `${formatPrice(subtotal)} ريال`;
            }
            if (taxElement) {
                taxElement.textContent = formatPrice(tax);
            }
            if (totalWithTaxElement) {
                totalWithTaxElement.textContent = formatPrice(totalWithTax);
            }
        }

        if (selectedPrice) {
            selectedPrice.textContent = formatPrice(totalWithTax);
        }
        if (selectedTax) {
            selectedTax.textContent = formatPrice(tax);
        }
    }

    offerButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.dataset.signingInProgress === '1' && this.dataset.signUrl) {
                window.location.href = this.dataset.signUrl;
                return;
            }

            const id = this.dataset.id;
            const company = this.dataset.company;
            const priceRaw = parseFloat(this.dataset.priceRaw.replace(/,/g, ''));
            basePrice = priceRaw;
            currentOfferId = id;
            allCards.forEach(card => card.classList.remove('active'));

            const selectedCard = document.querySelector(`.offer-card[data-offer-card="${id}"]`);
            if (selectedCard) {
                selectedCard.classList.add('active');
            }

            allServicesSections.forEach(section => {
                section.style.display = 'none';
            });

            const selectedSection = document.querySelector(`.additional-services[data-offer-id="${id}"]`);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }

            document.querySelectorAll('.custom-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });

            selectedCompany.textContent = company;
            offerIdInput.value = id;
            offerForm.action = `/customer/contract/sign/${id}`;
            updateTotalPrice();
            selectOffer.style.display = 'flex';
        });
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('custom-checkbox')) {
            updateTotalPrice();
        }
    });

    continuePay.addEventListener('click', function (e) {
        e.preventDefault();

        if (!currentOfferId) {
            return;
        }

        selectedServicesContainer.innerHTML = '';

        const checked = document.querySelectorAll(`.custom-checkbox[data-offer-id="${currentOfferId}"]:checked`);
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'services[]';
            input.value = cb.value;
            selectedServicesContainer.appendChild(input);
        });

        offerForm.submit();
    });

    cancelBtn.addEventListener('click', function () {
        selectOffer.style.display = 'none';
        selectedCompany.textContent = '---';
        selectedPrice.textContent = '---';
        if (selectedTax) {
            selectedTax.textContent = '---';
        }
        currentOfferId = null;

        allServicesSections.forEach(section => {
            section.style.display = 'none';
        });

        document.querySelectorAll('.custom-checkbox').forEach(cb => {
            cb.checked = false;
        });

        allCards.forEach(card => card.classList.remove('active'));
    });
});
