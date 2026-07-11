
    // active input radio checked 
    const options = document.querySelectorAll(".option");
    options.forEach(option => {
        option.addEventListener("click", () => {
        options.forEach(opt => opt.classList.remove("active"));
        option.classList.add("active");
        option.querySelector('input[type="radio"]').checked = true;
        });
    });




// toggle section and taps :---
  // const paymentSteps = document.querySelectorAll(".payment_steper li");
  // const sections = document.querySelectorAll(".step_section");

  // paymentSteps.forEach((step) => {
  //   step.addEventListener("click", () => {

  //   //   remove class Active from all itms :---
  //     paymentSteps.forEach((s) => s.classList.remove("active"));

  //     //   Active current Item :---
  //     step.classList.add("active");

  //   //   Hidden all Sections :---
  //     sections.forEach((sec) => (sec.style.display = "none"));

  //   //   Show target section  :---
  //     const targetClass = step.getAttribute("data-target");
  //     const targetSection = document.querySelector(`.${targetClass}`);
  //     if (targetSection) {
  //       targetSection.style.display = "block";
  //     }
  //   });
  // });


