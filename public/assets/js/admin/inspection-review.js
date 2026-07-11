


// Add  Inspection Features  :-------------------
let index = 1; 
document.getElementById('add-field').addEventListener('click', function() {
    let container = document.createElement('div');
    container.classList.add('row');

    container.innerHTML = `
        <div class="col-md-5 mb-3">
            <input type="text" class="form-control" name="properties[${index}][name]" placeholder="اسم الخاصية (مثال: المرافق العامة)">
        </div>
        <div class="col-md-6 mb-3">
            <input type="text" class="form-control" name="properties[${index}][value]" placeholder="القيمة (مثال: متوفر بالكامل)">
        </div>
        <div class="col-md-1 mb-3">
            <button type="button" class="btn btn-danger remove-field">حذف</button>
        </div>
    `;

    document.getElementById('dynamic-fields').appendChild(container);

    container.querySelector('.remove-field').addEventListener('click', function() {
        container.remove();
    });

    index++;
});
// Add  Inspection Features  :-------------------







// Add point in  insoection Details :-------------------
let pointIndex = 1;

document.getElementById('add-point').addEventListener('click', function() {
    let container = document.createElement('div');
    container.classList.add('d-flex', 'align-items-center', 'mb-2', 'point-item');

    container.innerHTML = `
        <input type="text" class="form-control me-2" name="points[${pointIndex}]" placeholder="أدخل نقطة جديدة">
        <button type="button" class="btn btn-danger remove-point">حذف</button>
    `;

    document.getElementById('inspection-points').appendChild(container);

    container.querySelector('.remove-point').addEventListener('click', function() {
        container.remove();
    });

    pointIndex++;
});
// Add point in  insoection Details :-------------------





// Add  recommendation  :-------------------
let recommendationIndex = 1;

document.getElementById('add-recommendation').addEventListener('click', function() {
    let container = document.createElement('div');
    container.classList.add('d-flex', 'align-items-center', 'mb-2', 'recommendation-item');

    container.innerHTML = `
        <input type="text" class="form-control me-2" name="recommendations[${recommendationIndex}]" placeholder="أدخل توصية جديدة">
        <button type="button" class="btn btn-danger remove-recommendation">حذف</button>
    `;

    document.getElementById('recommendations-list').appendChild(container);

    container.querySelector('.remove-recommendation').addEventListener('click', function() {
        container.remove();
    });

    recommendationIndex++;
});
// Add  recommendation  :-------------------
