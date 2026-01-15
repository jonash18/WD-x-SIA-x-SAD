<?php
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
    <h1 class="main-content my-1 text-white"><?php echo htmlspecialchars($header); ?></h1>
    <form class="d-flex main-content p-5" method="GET" action="">
        <input class="form-control me-2" type="search" name="search" placeholder="Search documents..." aria-label="Search">
        <button class="btn btn-outline-secondary mx-2" type="submit">Search</button>
        <button class="btn btn-outline-secondary" type="button"
            onclick="window.location.href='dashboard.php'">
            X
        </button>

    </form>
    <div class="doc-col d-flex flex-column gap-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="main-content" style="max-width:100%;">
                <div class="card  doc-card h-100 border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #ffffffe0; backdrop-filter: blur(20px);">

                    <?php
                    $category = strtolower($row['category_name']);
                    $headerClass = 'bg-secondary text-dark';

                    if ($category === 'complaint') {
                        $headerClass = 'text-danger';
                    } elseif ($category === 'report') {
                        $headerClass = 'text-dark';
                    } elseif ($category === 'feedback') {
                        $headerClass = 'text-success';
                    }
                    ?>

                    <div class="card-header d-flex justify-content-between align-items-center border-0 <?= $headerClass ?>">
                        <span class="fw-bold">
                            <?php echo htmlspecialchars($row['category_name']); ?>
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <span id="status_<?php echo $row['doc_id']; ?>"
                                class="badge <?= strtolower($row['status']) === 'open' ? 'bg-success' : 'bg-white'; ?> 
             px-3 py-2 rounded-pill shadow-sm text-dark border">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>

                            <?php if (strtolower($row['status']) === 'processing'): ?>
                                <button id="completeBtn_<?php echo $row['doc_id']; ?>"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="markComplete('<?php echo $row['doc_id']; ?>')">
                                    Mark as Complete
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="text-white p-3">

                        <h4 class="card-title mb-1 fw-semibold text-dark">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </h4>
                        <h6 class="card-subtitle mb-3 text-muted pb-3">
                            <i class="fas fa-envelope "></i><?php echo htmlspecialchars($row['email']); ?>
                        </h6>

                        <p class="card-text text-dark lh-lg" style="font-family: 'Georgia', serif;">
                            <?php echo nl2br(htmlspecialchars($row['body'])); ?>
                        </p>
                    </div>


                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">

                        <button type="button"
                            class="btn btn-outline-secondary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#infoModal<?php echo $row['doc_id']; ?>">
                            <i class="fas fa-info-circle "></i> More Info
                        </button>

                        <?php
                        $category = strtolower(trim($row['category_name']));
                        $status   = strtolower(trim($row['status']));

                        if ($status === 'completed') { ?>

                            <button type="button"
                                class="btn btn-outline-success donationBtn px-4 py-2"
                                data-name="<?= htmlspecialchars($row['name']); ?>"
                                data-email="<?= htmlspecialchars($row['email']); ?>">
                                <i class="fas fa-hand-holding-heart"></i> Ask For Donation
                            </button>
                        <?php } elseif ($category === 'complaint' || $category === 'report') { ?>

                            <a href="docViewer.php?doc_id=<?= urlencode($row['doc_id']); ?>"
                                class="btn btn-dark contactBtn px-3 py-2 shadow-sm">
                                <i class="fas fa-paper-plane"></i> Contact Now
                            </a>
                        <?php } elseif ($category === 'feedback') { ?>

                            <button type="button"
                                class="btn btn-outline-success donationBtn px-4 py-2"
                                data-name="<?= htmlspecialchars($row['name']); ?>"
                                data-email="<?= htmlspecialchars($row['email']); ?>">
                                <i class="fas fa-hand-holding-heart"></i> Ask For Donation
                            </button>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="infoModal<?php echo $row['doc_id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-3">

                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title fw-bold">
                                <i class="fas fa-file-alt me-2"></i> Document Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body bg-light">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-hashtag me-2"></i>Document ID:</strong>
                                        <nbsp><?php echo htmlspecialchars($row['doc_id']); ?></nbsp>
                                    </p>
                                    <p><strong><i class="fas fa-user me-2"></i>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                    <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-phone me-2"></i>Mobile Number:</strong> <?php echo htmlspecialchars($row['mobile_number']); ?></p>
                                    <p><strong><i class="fas fa-info-circle me-2"></i>Status:</strong>
                                        <span class="badge <?= strtolower($row['status']) === 'open' ? 'bg-success' : 'bg-secondary'; ?> rounded-pill px-3 py-2">
                                            <?php echo htmlspecialchars($row['status']); ?>
                                        </span>
                                    </p>
                                    <p><strong><i class="fas fa-globe me-2"></i>Website:</strong> <?php echo htmlspecialchars($row['website_name']); ?></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <p><strong><i class="fas fa-calendar-alt me-2"></i>Date Created:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark btn-sm" data-bs-dismiss="modal">
                                <i class="fas fa-times "></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function markComplete(docId) {
        fetch("updateStatus.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams({
                    doc_id: docId,
                    status: "Completed"
                })
            })
            .then(res => res.text())
            .then(text => {
                console.log("Status update:", text);

                const badge = document.getElementById("status_" + docId);
                if (badge) {
                    badge.textContent = "Completed";
                    badge.className = "badge bg-success px-3 py-2 rounded-pill shadow-sm text-light border";
                }
                const btn = document.querySelector(`#completeBtn_${docId}`);
                if (btn) {
                    btn.remove();


                }
                location.reload();
            })
            .catch(err => console.error("Error updating status:", err));
    }
</script>