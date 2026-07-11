
// Formate your Message :-----
function sendMessage() {
  let input = document.getElementById("userMessage");
  let msg = input.value.trim();
  if(msg !== "") {
    appendMessage("أنت", msg, "user");
    input.value = "";
    autoReply();
  }
}


// Add Message To Chat :-----
function appendMessage(sender, text, type) {
  let chatBox = document.getElementById("chatMessages");
  let newMsg = document.createElement("div");
  newMsg.classList.add("msg", type);
  newMsg.innerHTML = `<p><strong>${sender}:</strong> ${text}</p>`;
  chatBox.appendChild(newMsg);
  chatBox.scrollTop = chatBox.scrollHeight;
}


// Static Messages  :----- 
function autoReply() {
  setTimeout(() => {
    let replies = [
      "من فضلك أرسل تفاصيل المنتج المطلوب 📦",
      "شكراً لتواصلك معنا 🙏",
      "مدة التوصيل المتاحة من 3 لـ 5 أيام 🚚",
      "هل ترغب في عرض سعر تفصيلي؟ 💰"
    ];
    let reply = replies[Math.floor(Math.random() * replies.length)];
    appendMessage("قسم المشتريات", reply, "bot");
  }, 1000);
}

// Send Message on Click Enter :-----
document.getElementById("userMessage").addEventListener("keypress", function(e) {
  if(e.key === "Enter") {
    sendMessage();
  }
});