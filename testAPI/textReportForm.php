<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

  <h2 class="mb-4">Submit a Report</h2>
  <form method="POST" action="submit_report.php">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mobile Number</label>
      <input type="text" name="mobile_number" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Body (Content)</label>
      <textarea name="body" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Website Name</label>
      <input type="text" name="website_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_name" class="form-select" required>
        <option value="">Select Category</option>
        <option value="Feedback">Feedback</option>
        <option value="Complaint">Complaint</option>
        <option value="Report">Report</option>
      </select>
    </div>

    <input type="hidden" name="status" value="New">

    <button type="submit" class="btn btn-primary">Submit Report</button>
  </form>

</body>
</html>