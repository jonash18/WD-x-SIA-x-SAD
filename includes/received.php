<?php
$tabName = $tabName ?? 'Received Reports';
$header = $tabName;
?>
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
<div class="container-fluid mt-4 px-lg-5 pb-5">
    <h1 class="main-content mb-4 text-white">
        <?= htmlspecialchars($tabName); ?>
    </h1>

    <div class="doc-col d-flex flex-column gap-4" id="openReportsContainer">
        <?php if (!empty($openReports)) { ?>
            <?php foreach ($openReports as $report) { ?>
                <div class="main-content" style="max-width:100%;">
                    <div class="card doc-card h-100 border-0 shadow-lg rounded-3 overflow-hidden">

                        <?php
                        // Category color logic
                        $category = strtolower($report['category_name']);
                        $categoryClass = 'text-primary';
                        if ($category === 'complaint') {
                            $categoryClass = 'text-danger';
                        } elseif ($category === 'report') {
                            $categoryClass = 'text-dark';
                        } elseif ($category === 'feedback') {
                            $categoryClass = 'text-success';
                        }

                        // Badge logic
                        $status = strtolower($report['status']);
                        $badgeClass = $status === 'open'
                            ? 'bg-warning text-dark'
                            : 'bg-white text-dark border';
                        $badgeText = $status === 'open'
                            ? 'New'
                            : htmlspecialchars($report['status']);
                        ?>

                        <!-- Card Header -->
                        <div class="card-header bg-light d-flex justify-content-between align-items-center border-0">
                            <span class="fw-bold <?= $categoryClass ?>">
                                <?= htmlspecialchars($report['category_name']); ?>
                            </span>
                            <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill shadow-sm">
                                <?= $badgeText; ?>
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h4 class="card-title mb-1 fw-semibold text-dark">
                                <?= htmlspecialchars($report['name']); ?>
                            </h4>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <i class="fas fa-envelope"></i> <?= htmlspecialchars($report['email']); ?>
                            </h6>
                            <p class="card-text text-secondary lh-lg" style="font-family: 'Georgia', serif;">
                                <?= nl2br(htmlspecialchars($report['body'])); ?>
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 text-end">

                            <!-- Spam Form -->
                            <form class="spam-form d-inline"
                                data-id="<?= htmlspecialchars($report['feedback_id']); ?>"
                                data-source="<?= htmlspecialchars($report['source']); ?>">
                                <button type="submit" class="btn btn-dark px-4 py-2 shadow-sm fw-semibold">
                                    <i class="fas fa-ban"></i> Mark as Spam
                                </button>
                            </form>

                            <!-- Accept Form -->
                            <form method="POST" action="create.php" class="accept-form d-inline"
                                data-id="<?= htmlspecialchars($report['feedback_id']); ?>"
                                data-source="<?= htmlspecialchars($report['source']); ?>">
                                <input type="hidden" name="feedback_id" value="<?= htmlspecialchars($report['feedback_id']); ?>">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($report['user_id']); ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($report['name']); ?>">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($report['email']); ?>">
                                <input type="hidden" name="mobile_number" value="<?= htmlspecialchars($report['mobile_number']); ?>">
                                <input type="hidden" name="body" value="<?= htmlspecialchars($report['body']); ?>">
                                <input type="hidden" name="website_name" value="<?= htmlspecialchars($report['website_name']); ?>">
                                <input type="hidden" name="category_name" value="<?= htmlspecialchars($report['category_name']); ?>">
                                <input type="hidden" name="status" value="<?= htmlspecialchars($report['status']); ?>">
                                <input type="hidden" name="created_at" value="<?= htmlspecialchars($report['created_at']); ?>">
                                <input type="hidden" name="source" value="<?= htmlspecialchars($report['source']); ?>">
                                <button type="submit" class="btn btn-dark px-4 py-2 shadow-sm fw-semibold">
                                    <i class="fas fa-check"></i> Accept
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-secondary text-center main-content bg-white" role="alert">
                No more to show
            </div>
        <?php } ?>
    </div>
</div>

<script>
    // Function to render a report card (JS template)
    function renderReportCard(report) {
        let categoryClass = 'text-primary';
        const category = (report.category_name || '').toLowerCase();
        if (category === 'complaint') categoryClass = 'text-danger';
        else if (category === 'report') categoryClass = 'text-dark';
        else if (category === 'feedback') categoryClass = 'text-success';

        const status = (report.status || '').toLowerCase();
        const badgeClass = status === 'open' ? 'bg-warning text-dark' : 'bg-white text-dark border';
        const badgeText = status === 'open' ? 'New' : report.status;

        return `
      <div class="main-content" style="max-width:100%;">
        <div class="card doc-card h-100 border-0 shadow-lg rounded-3 overflow-hidden">
          <div class="card-header bg-light d-flex justify-content-between align-items-center border-0">
            <span class="fw-bold ${categoryClass}">
              ${escapeHtml(report.category_name)}
            </span>
            <span class="badge ${badgeClass} px-3 py-2 rounded-pill shadow-sm">
              ${escapeHtml(badgeText)}
            </span>
          </div>
          <div class="card-body">
            <h4 class="card-title mb-1 fw-semibold text-dark">
              ${escapeHtml(report.name)}
            </h4>
            <h6 class="card-subtitle mb-3 text-muted">
              <i class="fas fa-envelope"></i> ${escapeHtml(report.email)}
            </h6>
            <p class="card-text text-secondary lh-lg" style="font-family: 'Georgia', serif;">
              ${escapeHtml(report.body)}
            </p>
          </div>
          <div class="card-footer bg-transparent border-0 text-end">
            <!-- Spam Form -->
            <form class="spam-form d-inline"
                  data-id="${escapeHtml(report.feedback_id)}"
                  data-source="${escapeHtml(report.source)}">
              <button type="submit" class="btn btn-dark px-4 py-2 shadow-sm fw-semibold">
                <i class="fas fa-ban"></i> Mark as Spam
              </button>
            </form>

            <!-- Accept Form -->
            <form method="POST" action="create.php" class="accept-form d-inline">
              <input type="hidden" name="feedback_id" value="${escapeHtml(report.feedback_id)}">
              <input type="hidden" name="user_id" value="${escapeHtml(report.user_id)}">
              <input type="hidden" name="name" value="${escapeHtml(report.name)}">
              <input type="hidden" name="email" value="${escapeHtml(report.email)}">
              <input type="hidden" name="mobile_number" value="${escapeHtml(report.mobile_number)}">
              <input type="hidden" name="body" value="${escapeHtml(report.body)}">
              <input type="hidden" name="website_name" value="${escapeHtml(report.website_name)}">
              <input type="hidden" name="category_name" value="${escapeHtml(report.category_name)}">
              <input type="hidden" name="status" value="${escapeHtml(report.status)}">
              <input type="hidden" name="created_at" value="${escapeHtml(report.created_at)}">
              <input type="hidden" name="source" value="${escapeHtml(report.source)}">
              <button type="submit" class="btn btn-dark px-4 py-2 shadow-sm fw-semibold">
                <i class="fas fa-check"></i> Accept
              </button>
            </form>
          </div>
        </div>
      </div>
    `;
    }


    // Escape HTML utility
    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    // Example: Accept button handler


    // Poll and update open reports without reload
    async function updateOpenReports() {
        try {
            // 🔹 Fetch both APIs in parallel
            const [resp1, resp2] = await Promise.all([
                fetch("https://unsatirical-sharda-calorimetric.ngrok-free.dev/ISC-Student-Organization-System/api-connections/sharedFeedbacks-api.php"),
                fetch("https://coletta-parecious-improperly.ngrok-free.dev/CampusWear/api/shared/feedback.php")
            ]);

            const [data1, data2] = await Promise.all([resp1.json(), resp2.json()]);

            // 🔹 Normalize ISC API fields
            const mapped1 = Array.isArray(data1) ? data1.map(r => ({
                feedback_id: r.fbID ?? '',
                user_id: r.mbID ?? '0',
                name: r.fbName ?? '',
                email: r.mbEmail ?? '',
                mobile_number: r.mbMobileNo ?? '',
                body: r.fbContent ?? '',
                website_name: r.fbWebsiteName ?? '',
                category_name: r.fbCategory ?? '',
                status: r.fbStatus ?? '',
                created_at: r.fbCreatedAt ?? ''
            })) : [];

            // 🔹 Normalize CampusWear API fields
            const mapped2 = Array.isArray(data2) ? data2.map(r => ({
                feedback_id: r.feedback_id ?? '',
                user_id: r.user_id ?? '0',
                name: r.name ?? '',
                email: r.email ?? '',
                mobile_number: r.mobile_number ?? '',
                body: r.body ?? '',
                website_name: r.website_name ?? 'CampusWear',
                category_name: r.category_name ?? '',
                status: r.status ?? '',
                created_at: r.created_at ?? ''
            })) : [];

            const allReports = [...mapped1, ...mapped2];

            const openReports = allReports.filter(r => r.status && r.status.toLowerCase() === 'open');

            const container = document.getElementById('openReportsContainer');
            if (openReports.length > 0) {
                container.innerHTML = openReports.map(renderReportCard).join('');
            } else {
                container.innerHTML = `<div class="alert alert-secondary text-center main-content bg-white" role="alert">No more to show</div>`;
            }

        } catch (err) {
            console.error("API fetch failed:", err);
        }
    }

    // 🔄 Initial load + auto-refresh every 10s
    updateOpenReports();
    setInterval(updateOpenReports, 10000);
</script>

<script>
    document.addEventListener("submit", async function(e) {
        if (e.target.classList.contains("spam-form")) {
            e.preventDefault();
            const id = e.target.dataset.id; // normalized feedback_id
            const source = e.target.dataset.source; // "ISC" or "CampusWear"

            try {
                let apiUrl = "";
                let bodyData = {};

                if (source === "ISC") {
                    apiUrl = "https://unsatirical-sharda-calorimetric.ngrok-free.dev/ISC-Student-Organization-System/api-connections/sharedFeedbacks-api.php";
                    bodyData = {
                        fbID: id,
                        fbStatus: "spam"
                    };
                } else if (source === "CampusWear") {
                    apiUrl = "https://coletta-parecious-improperly.ngrok-free.dev/CampusWear/api/shared/feedback.php";
                    bodyData = {
                        feedback_id: id,
                        status: "spam"
                    };
                }

                const response = await fetch(apiUrl, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(bodyData)
                });

                const result = await response.json();

                // ✅ Use your notification modal
                const notificationMessage = document.getElementById("notificationMessage");
                const notificationModal = new bootstrap.Modal(document.getElementById("notificationModal"));

                if (result.success) {
                    notificationMessage.textContent = "Marked as spam.";
                    notificationModal.show();

                    // Remove card only if success
                    e.target.closest(".card").remove();
                } else {
                    notificationMessage.textContent = "Failed to mark spam: " + result.message;
                    notificationModal.show();
                    // 🚫 Do NOT remove card on failure
                }
            } catch (err) {
                console.error("Error marking spam:", err);

                const notificationMessage = document.getElementById("notificationMessage");
                const notificationModal = new bootstrap.Modal(document.getElementById("notificationModal"));
                notificationMessage.textContent = "An error occurred while marking spam.";
                notificationModal.show();
            }
        }
    });

    document.addEventListener("submit", async function(e) {
        if (e.target.classList.contains("accept-form")) {
            e.preventDefault();
            const id = e.target.dataset.id;
            const source = e.target.dataset.source;

            try {
                // Step 1: Insert into DB
                const formData = new FormData(e.target);
                const dbResponse = await fetch("create.php", {
                    method: "POST",
                    body: formData
                });
                const dbResult = await dbResponse.json();

                if (!dbResult.success) {
                    // 🚫 Show modal, do not call API
                    const notificationMessage = document.getElementById("notificationMessage");
                    const notificationModal = new bootstrap.Modal(document.getElementById("notificationModal"));
                    notificationMessage.textContent = dbResult.message;
                    notificationModal.show();
                    return;
                }

                // Step 2: Only update API if DB insert succeeded
                let apiUrl = "";
                let bodyData = {};

                if (source === "ISC") {
                    apiUrl = "https://unsatirical-sharda-calorimetric.ngrok-free.dev/ISC-Student-Organization-System/api-connections/sharedFeedbacks-api.php";
                    bodyData = {
                        fbID: id,
                        fbStatus: "received"
                    };
                } else if (source === "CampusWear") {
                    apiUrl = "https://coletta-parecious-improperly.ngrok-free.dev/CampusWear/api/shared/feedback.php";
                    bodyData = {
                        feedback_id: id,
                        status: "received"
                    };
                }

                const response = await fetch(apiUrl, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(bodyData)
                });

                const result = await response.json();

                const notificationMessage = document.getElementById("notificationMessage");
                const notificationModal = new bootstrap.Modal(document.getElementById("notificationModal"));

                if (result.success) {
                    notificationMessage.textContent = "<?php echo htmlspecialchars($report['category_name']); ?> accepted successfully!";
                    notificationModal.show();
                    e.target.closest(".card").remove();
                } else {
                    notificationMessage.textContent = "Failed to update API: " + result.message;
                    notificationModal.show();
                }
            } catch (err) {
                console.error("Error accepting report:", err);
            }
        }
    });
</script>
</div>