
// Switch tabs and Sections
document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll("#menu-tabs li");
  const sections = document.querySelectorAll(".section_tap");

  tabs.forEach(tab => {
    tab.addEventListener("click", function () {

      // Remove active class from all taps :-
      tabs.forEach(t => t.classList.remove("active"));

      // Add class Active for current tap :- 
      this.classList.add("active");

      // Hidden all Sections
      sections.forEach(sec => sec.classList.remove("active"));

      // Show target Section :-
      const targetClass = this.getAttribute("data-target");
      const targetSection = document.querySelector(`.section_tap.${targetClass}`);
      if (targetSection) {
        targetSection.classList.add("active");
      }
    });
  });

  // Show Frist Section :-
//   document.querySelector(".section_tap.offerDetails").classList.add("active");
 if (tabs.length > 0) tabs[0].classList.add("active");
  if (sections.length > 0) sections[0].classList.add("active");
});
