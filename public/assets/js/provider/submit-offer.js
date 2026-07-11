let itemIndex = 0;

function getProjectStart() {
    const el = document.getElementById('projectStart');
    return (el && el.value) ? el.value : new Date().toISOString().split('T')[0];
}

function toDate(str) {
    return new Date(str + 'T00:00:00');
}

function ymd(d) {
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

function addDaysStr(dateStr, days) {
    const d = toDate(dateStr);
    d.setDate(d.getDate() + days);
    return ymd(d);
}

function syncInpust(id, element) {
    const renderItem = document.getElementById(id);
    if (renderItem) renderItem.textContent = element.value;
}

function handlePaymentInput(element, index) {
    syncInpust('paymentItemvValue' + index, element);
    updateTotals();
}

function addItem() {
    const container = document.getElementById("itemsContainer");
    const paymentContainer = document.getElementById('payment_schedule');

    let defaultStartDate = getProjectStart();
    if (itemIndex > 0) {
        const lastItem = container.querySelector(".item:last-of-type");
        const prevEnd = lastItem?.querySelector('input[name$="[end_date]"]')?.value;
        if (prevEnd) defaultStartDate = addDaysStr(prevEnd, 1);
    }

    const item = document.createElement("div");
    item.className = "item";
    item.innerHTML = `
        <div class="item_box">
            <h6 class="item-title">البند ${itemIndex + 1}</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="input_group">
                        <label>عنوان البند</label>
                        <input type="text" name="items[${itemIndex}][title]"
                               oninput="syncInpust('paymentItemTitle${itemIndex + 1}', this)"
                               placeholder="كمثال أعمال الحفر والأساسات" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input_group">
                        <label>الوصف</label>
                        <input type="text" name="items[${itemIndex}][description]"
                               oninput="syncInpust('paymentItemDescription${itemIndex + 1}', this)"
                               placeholder="وصف البند..." required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 col-lg-3">
                    <div class="input_group">
                        <label>تاريخ البداية</label>
                        <input type="date" name="items[${itemIndex}][start_date]"
                               value="${defaultStartDate}"
                               min="${getProjectStart()}" required>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="input_group">
                        <label>تاريخ النهاية</label>
                        <input type="date" name="items[${itemIndex}][end_date]" required>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="input_group">
                        <label>قيمة الدفعة</label>
                        <input type="number" name="items[${itemIndex}][amount]"
                               oninput="handlePaymentInput(this, ${itemIndex + 1});"
                               placeholder="0" min="0" required>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="input_group">
                        <label>مدة التنفيذ بالايام</label>
                        <input type="number" name="items[${itemIndex}][duration]" placeholder="0" readonly required>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="input_group">
                        <label>الإجمالي</label>
                        <input type="number" name="items[${itemIndex}][total]" id="total${itemIndex + 1}" placeholder="0" disabled>
                    </div>
                </div>
            </div>
            <div class="input_group">
                <label>المواصفات</label>
                <textarea name="items[${itemIndex}][specifications]" placeholder="المواصفات الفنية والمتطلبات..."></textarea>
            </div>
            <button type="button" class="remove-btn" onclick="removeItem(this ,${itemIndex + 1})">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </div>
    `;

    const paymentItem = document.createElement("div");
    paymentItem.innerHTML = `
        <div class="box" id="paymentItem${itemIndex + 1}">
            <div class="top">
                <p id="paymentItemPercent${itemIndex + 1}">0%</p>
                <p id='paymentItemTitle${itemIndex + 1}'>الدفعة الأولى</p>
            </div>
            <div class="bottom">
                <span id='paymentItemvValue${itemIndex + 1}'></span>
                <span id='paymentItemDescription${itemIndex + 1}'>عند توقيع العقد</span>
            </div>
        </div>
    `;

    container.appendChild(item);
    paymentContainer.appendChild(paymentItem);
    itemIndex++;

    attachDateValidation(item);
    updateTotals();
}

function removeItem(button, index) {
    const item = button.closest(".item");
    const paymentItem = document.getElementById('paymentItem' + index);
    item.remove();
    if (paymentItem) paymentItem.remove();
    renumberItems();
    updateTotals();
}

function renumberItems() {
    const allItems = document.querySelectorAll("#itemsContainer .item");
    allItems.forEach((item, index) => {
        const title = item.querySelector(".item-title");
        if (title) title.textContent = `بند ${index + 1}`;
    });
    itemIndex = allItems.length;
}

function validateDates(item) {
    const startInput = item.querySelector('input[name$="[start_date]"]');
    const endInput = item.querySelector('input[name$="[end_date]"]');
    const durationInput = item.querySelector('input[name$="[duration]"]');
    const minStart = getProjectStart();
    startInput.min = minStart;

    if (startInput.value && startInput.value < minStart) {
        startInput.value = minStart;
    }

    if (startInput.value) endInput.min = startInput.value;

    if (startInput.value && endInput.value) {
        const start = toDate(startInput.value);
        const end = toDate(endInput.value);

        if (end < start) {
            endInput.value = "";
            durationInput.value = "";
            return;
        }

        const diff = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
        durationInput.value = diff;
    } else {
        durationInput.value = "";
    }

     const firstItem = document.querySelector("#itemsContainer .item:first-of-type");
    if (firstItem && firstItem === item) {
        const projectStartInput = document.getElementById("projectStart");
        if (projectStartInput && startInput.value) {
            projectStartInput.value = startInput.value;
        }
    }
}

function attachDateValidation(item) {
    const startInput = item.querySelector('input[name$="[start_date]"]');
    const endInput = item.querySelector('input[name$="[end_date]"]');

    [startInput, endInput].forEach(input => {
        input.addEventListener('change', () => {
            validateDates(item);
            updateTotals();
        });
        input.addEventListener('input', () => {
            validateDates(item);
            updateTotals();
        });
    });

    validateDates(item);
}

function updateTotals() {

    const items = document.querySelectorAll("#itemsContainer .item");
    let projectTotal = 0;
    let lastFinishDate = null;
    let runningTotal = 0;
items.forEach((item, idx) => {
    const amount = parseFloat(item.querySelector('input[name$="[amount]"]').value) || 0;
    runningTotal += amount;

    const totalInput = item.querySelector('input[name$="[total]"]');
    if(totalInput) totalInput.value = runningTotal;


    const percentEl = document.getElementById("paymentItemPercent" + (idx + 1));
    if (percentEl) {
        if (projectTotal > 0) {
            const percent = ((amount / projectTotal) * 100).toFixed(2);
            percentEl.textContent = percent + "%";
        } else {
            percentEl.textContent = "0%";
        }
    }
});


    items.forEach(item => {
        const paymentValue = parseFloat(item.querySelector('input[name$="[amount]"]').value) || 0;
        const finishDate = item.querySelector('input[name$="[end_date]"]').value;

        projectTotal += paymentValue;
        if (finishDate) {
            const d = toDate(finishDate);
            if (!lastFinishDate || d > lastFinishDate) lastFinishDate = d;
        }
    });

    const totalSpan = document.getElementById('projectTotal');
    if (totalSpan) totalSpan.textContent = `ريال ${projectTotal.toLocaleString()}`;

    if (totalSpan) totalSpan.textContent = `ريال ${projectTotal.toLocaleString()}`;

    const durationEl = document.getElementById("duration");
    const expectedFinishEl = document.getElementById("expectedFinish");
    const projectStartStr = getProjectStart();

    if (lastFinishDate && projectStartStr) {
        const startDate = toDate(projectStartStr);
        const diffDays = Math.floor((lastFinishDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        durationEl.value = diffDays;
        expectedFinishEl.value = ymd(lastFinishDate);
    } else {
        durationEl.value = 0;
        expectedFinishEl.value = projectStartStr || "";
    }

    items.forEach((item, idx) => {
        const paymentValue = parseFloat(item.querySelector('input[name$="[amount]"]').value) || 0;
        const percentEl = document.getElementById("paymentItemPercent" + (idx + 1));
        if (percentEl) {
            if (projectTotal > 0) {
                const percent = ((paymentValue / projectTotal) * 100).toFixed(2);
                percentEl.textContent = percent + "%";
            } else {
                percentEl.textContent = "0%";
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    addItem();

    const projectStartInput = document.getElementById('projectStart');
    if (projectStartInput) {
        if (!projectStartInput.min) projectStartInput.min = getProjectStart();

        const onProjectStartChange = () => {
            document.querySelectorAll('#itemsContainer .item').forEach((item, i) => {
                const startInput = item.querySelector('input[name$="[start_date]"]');
                if (!startInput) return;
                startInput.min = getProjectStart();


                // if (i === 0) startInput.value = getProjectStart();

                // if (startInput.value && startInput.value < startInput.min) {
                //     startInput.value = startInput.min;
                //     const endInput = item.querySelector('input[name$="[end_date]"]');
                //     if (endInput && endInput.value && endInput.value < startInput.value) {
                //         endInput.value = "";
                //     }
                // }
                validateDates(item);
            });
            updateTotals();
        };

        projectStartInput.addEventListener('change', onProjectStartChange);
        projectStartInput.addEventListener('input', onProjectStartChange);
    }

    updateTotals();
});
