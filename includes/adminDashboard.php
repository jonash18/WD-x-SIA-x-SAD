<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="icon.png">
    <style>
        body {
            background: url('bgimg.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 20px;
            margin: 40px auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: #fff;
            max-width: 95%;
        }

        table {
            color: #fff;
        }

        th {
            background: rgba(79, 172, 254, 0.6);
        }

        td {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>

    <?php include 'documentTable.php';  ?>
    <?php include 'websiteTable.php';  ?>

    </div>
    <div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title text-warning">⚠️ Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            You are about to change data in the database.<br>
                            Please confirm this action carefully.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="confirmUpdate" type="button" class="btn btn-warning">I Understand</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title">Update Website Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="update.php">
                    <div class="modal-body">
                        <input type="hidden" name="website_id" id="website_id">
                        <div class="mb-3">
                            <label class="form-label">Website Name</label>
                            <input type="text" name="website_name" id="website_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">Update Successful</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5">
                    The website name has been updated successfully.
                </div>
                <button type="button" class="btn border" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">❌ Update Failed</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Unable to update website name. We could not update the database due to a technical issue. Don’t worry — your data is safe and unchanged. Please try updating again. If the issue keeps happening, contact your system administrator for assistance.

                </div>
                <button type="button" class="btn border" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="deleteWarningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="delete.php">
                    <div class="modal-body">
                        <input type="hidden" name="doc_id" id="deleteDocId">
                        <p class="text-danger fw-bold">
                            Are you sure you want to delete <span id="deleteItemName"></span>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content container">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="delete.php">
                    <div class="modal-body">
                        <input type="hidden" name="doc_id" id="delete_doc_id">
                        <p class="text-danger fw-bold">Are you sure you want to delete this document?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">✅ Document Deleted</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5">
                    The document has been deleted successfully.
                </div>
                <button type="button" class="btn border" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">❌ Delete Failed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Unable to delete the document due to a technical issue.
                    Don’t worry — your data is safe and unchanged.
                    Please try again. If the issue persists, contact your system administrator.
                </div>
                <button type="button" class="btn border" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteWarningModalEl = document.getElementById('deleteWarningModal');

        deleteWarningModalEl.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const docId = button.getAttribute('data-id');
            const docName = button.getAttribute('data-name');

            document.getElementById('deleteDocId').value = docId;
            document.getElementById('deleteItemName').textContent = docName;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var warningModal = document.getElementById('warningModal');
        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
        var confirmBtn = document.getElementById('confirmUpdate');

        var websiteId, websiteName;


        warningModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            websiteId = button.getAttribute('data-id');
            websiteName = button.getAttribute('data-name');
        });


        confirmBtn.addEventListener('click', function() {
            warningModal.querySelector('.btn-close').click();
            document.getElementById('website_id').value = websiteId;
            document.getElementById('website_name').value = websiteName;
            updateModal.show();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        } else if (status === 'error') {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    });
    document.addEventListener('DOMContentLoaded', function() {

        var deleteWarningModalEl = document.getElementById('deleteWarningModal');
        var deleteModalEl = document.getElementById('deleteModal');
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        var deleteModal = new bootstrap.Modal(deleteModalEl);

        var docId = null;

        deleteWarningModalEl.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            docId = button.getAttribute('data-id');
        });
        confirmDeleteBtn.addEventListener('click', function() {
            var warningInstance = bootstrap.Modal.getInstance(deleteWarningModalEl);
            warningInstance.hide();
            document.getElementById('delete_doc_id').value = docId;
            deleteModal.show();
        });
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'deleted') {
            var successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
            successModal.show();
        } else if (status === 'error') {
            var errorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
            errorModal.show();
        }
    });
</script>

</html>