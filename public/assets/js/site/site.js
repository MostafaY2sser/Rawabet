
// -----------------------------------------------------------------
// Show and CLose MoileNav :---
const mobileNav = document.querySelector(".mobile_nav");
const iconBar = document.querySelector(".icon_bar");
const closeBar = document.querySelector(".close_bar");

// Show and CLose MoileNav :---
iconBar.addEventListener("click", function () {
    mobileNav.classList.toggle("show");
});

// on click mobile_nav 
mobileNav.addEventListener("click", function (e) {
    if (!e.target.closest(".wrapper")) {
        mobileNav.classList.remove("show");
    }
});
// on click Close Icon colose mobileNav
closeBar.addEventListener("click", function (e) {
    mobileNav.classList.remove("show");
});
// -----------------------------------------------------------------





// -----------------------------------------------------------------
//onclick on a question icon :---
// its answer toggles open while closing all other answers.
document.addEventListener("DOMContentLoaded", function () {
    const questions = document.querySelectorAll(".question");

    questions.forEach((question) => {
        const icon = question.querySelector(".icon");
        const answer = question.querySelector(".anwsser");

        icon.addEventListener("click", function () {
            
            questions.forEach((q) => {
                const a = q.querySelector(".anwsser");
                if (a !== answer) {
                    a.classList.remove("active");
                }
            });
            answer.classList.toggle("active");
        });
    });
});
// -----------------------------------------------------------------




// -----------------------------------------------------------------
// Slider of Projecct List in Home page :---
 document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("projectsSlider");
    const rightArrow = document.querySelector("#rightArrowProject");
    const leftArrow = document.querySelector("#leftArrowProject");
    
    // Calc frist item to move space the same it :---
    const card = slider.querySelector(".project"); 
    // width  item  + gap
    const cardWidth = card ? card.offsetWidth + 15 : 380;   

    rightArrow.addEventListener("click", () => {
        slider.scrollBy({ left: cardWidth, behavior: "smooth" });
    });

    leftArrow.addEventListener("click", () => {
        slider.scrollBy({ left: -cardWidth, behavior: "smooth" });
    });
});
// -----------------------------------------------------------------




// -----------------------------------------------------------------
// Slider of Providers List in Home page :---
 document.addEventListener("DOMContentLoaded", function () {
    const slider = document.getElementById("providersSlider");
    const rightArrow = document.querySelector("#rightArrowProvider");
    const leftArrow = document.querySelector("#leftArrowProvider");
    
    // Calc frist item to move space the same it :---
    const card = slider.querySelector(".provider"); 
    // width  item  + gap
    const cardWidth = card ? card.offsetWidth + 15 : 380;   

    rightArrow.addEventListener("click", () => {
        slider.scrollBy({ left: cardWidth, behavior: "smooth" });
    });

    leftArrow.addEventListener("click", () => {
        slider.scrollBy({ left: -cardWidth, behavior: "smooth" });
    });
});
// -----------------------------------------------------------------



