document.addEventListener("DOMContentLoaded", function () {
 
    // Action Elment  :----------
    const editBtn = document.getElementById("editInspectionBtn");
    const requestChangeBtn = document.getElementById("requestChangeBtn");
    const requestInspection = document.querySelector(".request_inspection");
    const closeBtn = document.querySelector(".close_request_inspection");

    // Element Show old data  :----------
    const dateSpan = document.querySelector(".date_time span:nth-of-type(1)").innerText.trim(); 
    const timeSpan = document.querySelector(".date_time span:nth-of-type(2)").innerText.trim();
    const consultantSpan = document.querySelector(".consultant span").innerText.trim();

    // Request Change Data
    const requestDateSelector = document.querySelector(".request_date span:nth-of-type(1)");
    const  requestTimeSelector = document.querySelector(".request_date span:nth-of-type(2)");
    if(requestDateSelector){
    var requestDateSpan = document.querySelector(".request_date span:nth-of-type(1)").innerText.trim();

    }
    
    if(requestTimeSelector){
    var requestTimeSpan = document.querySelector(".request_date span:nth-of-type(2)").innerText.trim();
    }
    // Element to Select New date :------------
    const dateInput = document.getElementById("inlineCalendar");
    const timeInput = document.getElementById("time");
    const consultantSelect = document.getElementById("consultant_id");

    //  Refactor Date :------------- 
    function formatDate(dateStr) {
        let parts = dateStr.split(" ")[0].split("/");
        let day = parts[0].padStart(2, "0");
        let month = parts[1].padStart(2, "0");
        let year = parts[2];
        return `${year}-${month}-${day}`;
    }

    // Convert 12h → 24h time
    function convertTo24Hour(timeStr) {
        if (!timeStr.includes("am") && !timeStr.includes("pm")) {
            return timeStr; 
        }
        let [time, modifier] = timeStr.split(" ");
        let [hours, minutes] = time.split(":");
        hours = parseInt(hours, 10);

        if (modifier.toLowerCase() === "pm" && hours < 12) {
            hours += 12;
        }
        if (modifier.toLowerCase() === "am" && hours === 12) {
            hours = 0;
        }

        return `${hours.toString().padStart(2, "0")}:${minutes}`;
    }

    // Show Request Inspection Popup :-------------- 
    editBtn.addEventListener("click", function () {
        requestInspection.style.display = "flex"; 

        dateInput.value = formatDate(dateSpan);
        flatpickr("#inlineCalendar", {
            inline: true,
            dateFormat: "Y-m-d",
            defaultDate: formatDate(dateSpan),
            minDate: "today"
        });

        timeInput.value = timeSpan ? convertTo24Hour(timeSpan) : "";

        // Select Consultant
        for (let option of consultantSelect.options) {
            if (consultantSpan.includes(option.text.trim())) {
                option.selected = true;
            }
        }
    });

    // Show Request Inspection Popup :-------------- 
    requestChangeBtn.addEventListener("click", function (e) {
        e.preventDefault();

        requestInspection.style.display = "flex"; 

        dateInput.value = formatDate(requestDateSpan);
        flatpickr("#inlineCalendar", {
            inline: true,
            dateFormat: "Y-m-d",
            defaultDate: formatDate(requestDateSpan),
            minDate: "today"
        });

        timeInput.value = requestTimeSpan ? convertTo24Hour(requestTimeSpan) : "";
    });

    // Close  Request Inspection Popup :---------
    closeBtn.addEventListener("click", function () {
        requestInspection.style.display = "none";
    });
});

// flatpickr Lib :---------
flatpickr("#inlineCalendar", {
    inline: true,
    dateFormat: "Y-m-d",
    minDate: "today"
});