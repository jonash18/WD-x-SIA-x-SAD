<!-- Reply box -->

<div class="mb-3">
  <label for="replyField_<?= htmlspecialchars($doc['doc_id']); ?>" class="form-label">Reply</label>
  <textarea id="replyField_<?= htmlspecialchars($doc['doc_id']); ?>"
    class="form-control"
    rows="1"
    style="overflow:hidden;resize:none;"></textarea>

</div>
<?php include 'includes/modalNotif.html' ?>

<!-- Hidden field with recipient mobile number -->
<input type="hidden" id="recipient_<?= htmlspecialchars($doc['doc_id']); ?>"
  value="<?= htmlspecialchars($doc['mobile_number']); ?>">

<button class="btn btn-primary" onclick="sendReply('<?= htmlspecialchars($doc['doc_id']); ?>')">
  Send Reply
</button>


<script>
  const textarea = document.getElementById("replyField_<?= htmlspecialchars($doc['doc_id']); ?>");

  textarea.addEventListener("input", function() {
    this.style.height = "auto"; // reset height
    this.style.height = this.scrollHeight + "px"; // set to content height
  });

  function sendReply(docId) {
    const message = document.getElementById("replyField_" + docId).value;
    const number = document.getElementById("recipient_" + docId).value;

    if (!message.trim()) {
      showModal("Message cannot be empty."); // ✅ modal instead of alert
      return;
    }

    // Immediately mark as Processing


    // Prepare form data for SMS
    const formData = new FormData();
    formData.append("message", message);
    formData.append("phone_number", number);
    formData.append("doc_id", docId);

    fetch("sendSMS.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // parse JSON
      .then(result => {
        if (result.success) {
          showModal("Message sent!"); // ✅ success modal

          fetch("updateStatus.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded"
              },
              body: new URLSearchParams({
                doc_id: docId,
                status: "Processing"
              })
            })
            .then(res => res.text())
            .then(text => console.log("Processing update:", text));

        } else {
          showModal("Message Failed"); // ❌ failure modal


        }
      })
  }

  // 🔗 Bootstrap modal helper
  function showModal(message) {
    const modalMessage = document.getElementById("notificationMessage");
    modalMessage.textContent = message;

    const notificationModal = new bootstrap.Modal(document.getElementById("notificationModal"));
    notificationModal.show();
  }
</script>