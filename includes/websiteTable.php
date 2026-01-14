<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered align-middle shadow-lg">
        <thead class="table-primary text-center">
            <tr>
                <th scope="col">Website ID</th>
                <th scope="col">Website Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_websites = "SELECT website_id, website_name FROM website";
            $result_websites = $conn->query($sql_websites);

            if ($result_websites->num_rows > 0) {
                while ($row = $result_websites->fetch_assoc()) {
                    echo "<tr>
                    <td><span class='badge bg-secondary'>{$row['website_id']}</span></td>
                    <td class='fw-bold'>{$row['website_name']}</td>
                    <td class='text-center'>
                        <button class='btn btn-sm btn-warning' 
                                data-bs-toggle='modal' 
                                data-bs-target='#warningModal' 
                                data-id='{$row['website_id']}' 
                                data-name='{$row['website_name']}'>
                            Update
                        </button>
                    </td>
                  </tr>";
                }
            } else {
                echo "<tr><td colspan='3' class='text-center text-muted py-3'>No websites found</td></tr>";
            }
            ?>
        </tbody>

    </table>


</div>
</div>