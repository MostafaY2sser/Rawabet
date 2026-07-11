``

document.querySelectorAll('.rating').forEach(rating => {
    const stars = rating.querySelectorAll('.fa-star');
    const input = rating.nextElementSibling;

    stars.forEach(star => {
        star.addEventListener('click', () => {
            let value = star.getAttribute('data-value');
            input.value = value;

            stars.forEach((s, index) => {
                s.classList.toggle('active', index < value);
            });
            // console.log(input.name + " = " + input.value);
        });
    });
});
