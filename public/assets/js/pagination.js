document.addEventListener('DOMContentLoaded', function () {

    /**
     * Build a compact page list: 1 … 4 5 6 … 20
     */
    function getVisiblePages(current, total, delta = 1) {
        if (total <= 1) {
            return total === 1 ? [1] : [];
        }

        const pages = new Set([1, total]);

        for (let i = current - delta; i <= current + delta; i++) {
            if (i >= 1 && i <= total) {
                pages.add(i);
            }
        }

        const sorted = Array.from(pages).sort((a, b) => a - b);
        const result = [];
        let previous = null;

        sorted.forEach((page) => {
            if (previous !== null && page - previous > 1) {
                result.push('…');
            }
            result.push(page);
            previous = page;
        });

        return result;
    }

    function setupPagination(cardSelector, prevId, nextId, pagesId, itemsPerPage = 10) {
        let currentPage = 1;

        const cards = Array.from(document.querySelectorAll(cardSelector));
        const totalPages = Math.ceil(cards.length / itemsPerPage);

        const prevBtn = document.getElementById(prevId);
        const nextBtn = document.getElementById(nextId);
        const pageNumbers = document.getElementById(pagesId);

        if (!cards.length || !pageNumbers) {
            return;
        }

        if (totalPages <= 1) {
            pageNumbers.closest('.pagination')?.classList.add('d-none');
            cards.forEach((card) => {
                card.style.display = 'block';
            });
            return;
        }

        function showPage(page) {
            cards.forEach((card, index) => {
                card.style.display =
                    index >= (page - 1) * itemsPerPage && index < page * itemsPerPage
                        ? 'block'
                        : 'none';
            });

            currentPage = page;
            renderPagination();
        }

        function renderPagination() {
            pageNumbers.innerHTML = '';

            getVisiblePages(currentPage, totalPages).forEach((item) => {
                if (item === '…') {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '…';
                    ellipsis.classList.add('page-ellipsis');
                    ellipsis.setAttribute('aria-hidden', 'true');
                    pageNumbers.appendChild(ellipsis);
                    return;
                }

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = item;
                btn.classList.add('page-number');

                if (item === currentPage) {
                    btn.classList.add('active');
                    btn.setAttribute('aria-current', 'page');
                }

                btn.addEventListener('click', () => showPage(item));
                pageNumbers.appendChild(btn);
            });

            if (prevBtn) {
                prevBtn.disabled = currentPage === 1;
            }
            if (nextBtn) {
                nextBtn.disabled = currentPage === totalPages;
            }
        }

        prevBtn?.addEventListener('click', () => {
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        });

        nextBtn?.addEventListener('click', () => {
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        });

        showPage(1);
    }

    setupPagination('.provider-card', 'prevBtnSite', 'nextBtnSite', 'pageNumbersSite');
    setupPagination('.notification-card', 'prevBtnAdmin', 'nextBtnAdmin', 'pageNumbersAdmin');
    setupPagination('.customer-notification-card', 'prevBtnCustomer', 'nextBtnCustomer', 'pageNumbersCustomer');
    setupPagination('.provider-notification-card', 'prevBtnProvider', 'nextBtnProvider', 'pageNumbersProvider');
});
