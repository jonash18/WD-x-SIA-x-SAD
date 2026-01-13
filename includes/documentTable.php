<div class="container-fluid">
    <h1 class="text-center m-5 text-white">Admin Dashboard</h1>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col">Doc ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Website ID</th>
                    <th scope="col">Category ID</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
  <td><span class='badge bg-secondary'>" . $row['doc_id'] . "</span></td>
  <td class='fw-bold'>" . htmlspecialchars($row['name']) . "</td>
  <td><a href='mailto:" . htmlspecialchars($row['email']) . "' class='text-decoration-none'>" . htmlspecialchars($row['email']) . "</a></td>
  <td>" . htmlspecialchars($row['mobile_number']) . "</td>
  <td><span class='badge bg-success'>" . htmlspecialchars($row['status']) . "</span></td>
  <td>" . htmlspecialchars($row['created_at']) . "</td>
  <td>" . htmlspecialchars($row['website_id']) . "</td>
  <td>" . htmlspecialchars($row['category_name']) . "</td>
  <td class='text-center'>
    <button class='btn btn-sm btn-danger'
            data-bs-toggle='modal'
            data-bs-target='#deleteWarningModal'
            data-id='" . $row['doc_id'] . "'
            data-name='" . htmlspecialchars($row['name']) . "'>
      Delete
    </button>
  </td>
</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center text-muted py-3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteWarningModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const docId = button.getAttribute('data-id');
                const docName = button.getAttribute('data-name');

                // Update modal fields
                document.getElementById('deleteDocId').value = docId;
                document.getElementById('deleteItemName').textContent = docName;
            });
        });
    </script>