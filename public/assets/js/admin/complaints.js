
  const form = document.getElementById("complaintForm");
  const ticketsTable = document.getElementById("ticketsTable");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const subject = document.getElementById("sub_complaints").value.trim();
    const complaintText = document.getElementById("complaintText").value.trim();

    if (subject === "" || complaintText === "") return;

    // Data Send :-----
    const formData = new FormData();
    formData.append("sub_complaints", subject);
    formData.append("complaintText", complaintText);

    try {
      const response = await fetch("", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}", 
        },
        body: formData,
      });

      if (!response.ok) throw new Error("Network error");

      const data = await response.json();

    //  Updata Table by Return Data from response :---------
      const index = ticketsTable.rows.length + 1;
      const newRow = document.createElement("tr");
      newRow.innerHTML = `
        <td>${index}</td>
        <td>${data.sub_complaints}</td>
        <td>${data.complaintText}</td>
        <td><span class="status status-open">مفتوحة</span></td>
        <td><a href="#"><i class="fa-regular fa-eye"></i></a></td>
      `;
      ticketsTable.appendChild(newRow);

      // reset form + close modal
      form.reset();
      const modal = bootstrap.Modal.getInstance(document.getElementById("addComplaintModal"));
      modal.hide();
    } catch (error) {
      alert("حدث خطأ أثناء إرسال الشكوى");
    }
  });

