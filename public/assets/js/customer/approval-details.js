
// Calendar to select new date for change Inspection 
//  Open popup for change Inspection  :--- 
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll('.request_inspection_btn').forEach(function (btn) {
          btn.addEventListener("click", function (e) {
              e.preventDefault();
              document.querySelector('.request_inspection').classList.add("show");
          });
      });
    });


    // Close popup for contact with consultant :---  
    document.addEventListener("DOMContentLoaded", function () {
        const consultantPopup = document.querySelector('.request_inspection');

        document.querySelectorAll('.close_request_inspection, .request_inspection .cancel').forEach(button => {
            button.addEventListener("click", function (e) {
            e.preventDefault();
            consultantPopup.classList.remove("show");
            });
        });
    });

  flatpickr("#inlineCalendar", {
    inline: true,
    dateFormat: "Y-m-d",
    minDate: "today"
  });


