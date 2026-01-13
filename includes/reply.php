<!-- Reply box -->
<div class="mb-3">
  <label for="replyField_<?= htmlspecialchars($doc['doc_id']); ?>" class="form-label">Reply</label>
  <textarea id="replyField_<?= htmlspecialchars($doc['doc_id']); ?>"
    class="form-control"
    rows="1"
    style="overflow:hidden;resize:none;"></textarea>

</div>

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
    alert("Message cannot be empty.");
    return;
  }

  // Immediately mark as Processing
  fetch("updateStatus.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ doc_id: docId, status: "Processing" })
  })
  .then(res => res.text())
  .then(text => console.log("Processing update:", text));

  // Prepare form data for SMS
  const formData = new FormData();
  formData.append("message", message);
  formData.append("phone_number", number);
  formData.append("doc_id", docId);

  fetch("sendSMS.php", { method: "POST", body: formData })
    .then(response => response.text())
    .then(data => {
      alert("Response: " + data);

      // Update to Completed
      fetch("updateStatus.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ doc_id: docId, status: "Processing" })
      })
      .then(res => res.text())
      .then(text => console.log("Completed update:", text));
    })
    .catch(error => {
      console.error("Error:", error);
      alert("Failed to send SMS.");

      // Update to Failed
      fetch("updateStatus.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ doc_id: docId, status: "Failed" })
      })
      .then(res => res.text())
      .then(text => console.log("Failed update:", text));
    });
}
</script>