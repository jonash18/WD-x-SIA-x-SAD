<?php
include 'connect.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CAMS - Reply</title>
    <link rel="stylesheet" href="includes/design.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<style>
    .doc-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .doc-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-footer .btn {
        transition: all 0.25s ease-in-out;
    }

    .card-footer .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<?php include 'includes/bgcolor.html'; ?>
<?php include 'includes/navbars.php'; ?>

<main>
    <div class="container-fluid mt-4 px-lg-5 pb-5">
        <div class="doc-col d-flex flex-column gap-4">
            <?php
            $file = __DIR__ . '/includes/replies.json';

            if (file_exists($file)) {
                $replies = json_decode(file_get_contents($file), true);

                if (is_array($replies) && count($replies) > 0) {
                    $replies = array_reverse($replies);
                    foreach ($replies as $index => $reply) {
                        $receivedTime = !empty($reply['received_at']) ? date("M d, Y h:i A", $reply['received_at'] / 1000) : '';

                        // Lookup name in DB
                        $mobile = trim($reply['sender']);
                        $name   = '';
                        $stmt   = $conn->prepare("SELECT name FROM documents WHERE mobile_number = ?");
                        $stmt->bind_param("s", $mobile);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()) {
                            $name = $row['name'];
                        }
                        $stmt->close();
            ?>
                        <div class="main-content" style="max-width:100%;">
                            <div class="card doc-card h-100 border-0 shadow-lg rounded-4 overflow-hidden"
                                style="background-color: #ffffffe0; backdrop-filter: blur(20px);">

                                <!-- Header -->
                                <div class="card-header d-flex justify-content-between align-items-center border-0">
                                    <span class="fw-bold">
                                        <?php echo !empty($name) ? htmlspecialchars($name) : 'Unknown Contact'; ?>
                                    </span>
                                </div>

                                <!-- Body -->
                                <div class="text-white px-3">
                                    <h4 class="card-title my-4 fw-semibold text-dark">
                                        <?php echo htmlspecialchars($reply['message']); ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted">
                                        Received: <?php echo $receivedTime; ?>
                                    </h6>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center mt-3">
                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm reply-card"
                                        data-message="<?= htmlspecialchars($reply['message'], ENT_QUOTES); ?>"
                                        onclick="deleteReply(this.dataset.message)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>

                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="toggleReplyBox('<?= $index; ?>')">
                                        <i class="fas fa-reply"></i> Reply
                                    </button>
                                </div>

                                <!-- Reply box (hidden by default) -->
                                <div id="replyBox_<?= $index; ?>" class="px-3 pb-3" style="display:none;">
                                    <div class="mb-3">
                                        <label for="replyField_<?= $index; ?>" class="form-label">Reply</label>
                                        <textarea id="replyField_<?= $index; ?>" class="form-control"
                                            rows="1" style="overflow:hidden;resize:none;"></textarea>
                                    </div>

                                    <!-- Hidden recipient (sender number) -->
                                    <input type="hidden" id="recipient_<?= $index; ?>"
                                        value="<?= htmlspecialchars($reply['sender']); ?>">

                                    <button class="btn btn-primary" onclick="sendReply('<?= $index; ?>')">
                                        Send Reply
                                    </button>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
</main>

<?php include 'includes/footer.html'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script>
    function toggleReplyBox(id) {
        const box = document.getElementById("replyBox_" + id);
        box.style.display = (box.style.display === "none") ? "block" : "none";
    }

    // Auto-resize textarea
    document.addEventListener("input", function(e) {
        if (e.target && e.target.id.startsWith("replyField_")) {
            e.target.style.height = "auto";
            e.target.style.height = e.target.scrollHeight + "px";
        }
    });

    function sendReply(id) {
        const message = document.getElementById("replyField_" + id).value;
        const number = document.getElementById("recipient_" + id).value;

        if (!message.trim()) {
            alert("Message cannot be empty.");
            return;
        }

        // Send SMS via backend
        const formData = new FormData();
        formData.append("message", message);
        formData.append("phone_number", number);

        fetch("sendSMS.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Response: " + data);
            });
    }

    function deleteReply(messageText) {
        if (!confirm("Are you sure you want to delete this reply?")) return;

        fetch("deleteReply.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({
                    message: messageText
                })
            })
            .then(res => res.text())
            .then(data => {
                alert("Delete response: " + data);

                // Remove the card with matching message
                const cards = document.querySelectorAll(".reply-card");
                cards.forEach(card => {
                    if (card.dataset.message === messageText) {
                        card.closest(".main-content").remove();
                    }
                });

                // Update badge immediately
                const repliesBadge = document.getElementById("repliesBadge");
                if (repliesBadge) {
                    let count = parseInt(repliesBadge.textContent, 10) || 0;
                    count = Math.max(0, count - 1);
                    repliesBadge.textContent = count;
                    repliesBadge.style.display = count > 0 ? "inline" : "none";
                }
            })
            .catch(err => console.error("Delete failed:", err));
    }
</script>

</body>

</html>