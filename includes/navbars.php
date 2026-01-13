<!-- Mobile Navbar -->
<?php $current = basename($_SERVER['PHP_SELF']); ?>


<nav class="navbar navbar-expand-lg navbar-dark  d-lg-none shadow-sm" style="background-color: #023e56c0;backdrop-filter: blur(10px);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">
      <i class="fas fa-bars me-2"></i> Menu
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-white d-lg-none" style="background-color: #023e56c0;backdrop-filter: blur(10px);" id="mobileSidebar">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fw-bold">Menu</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column px-3">
    <a href="dashboard.php" class="nav-link py-2"><i class="fas fa-home me-2"></i> Dashboard</a>
    <a href="repliesTab.php" class="nav-link py-2"><i class="fas fa-home me-2"></i> Replies</a>
    <a href="incoming.php" class="nav-link py-2"><i class="fas fa-inbox me-2"></i> Incoming</a>
    <a href="feedback.php" class="nav-link py-2"><i class="fas fa-comment-dots me-2"></i> Feedback</a>
    <a href="complaints.php" class="nav-link py-2"><i class="fas fa-exclamation-circle me-2"></i> Complaints</a>
    <a href="Reports.php" class="nav-link py-2"><i class="fas fa-file-alt me-2"></i> Reports</a>
    <a href="balanceCheck.php" class="nav-link py-2"><i class="fas fa-file-alt me-2"></i> Donations</a>
    <a href="index.php" class="nav-link text-danger py-2"><i class="fas fa-sign-out-alt me-2"></i> Exit</a>
  </div>
</div>

<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-flex flex-column text-white shadow-lg rounded-4 m-2 py-3" style="background-color: #023e56c0; width: 220px; height: calc(95vh - 2rem); position: fixed; backdrop-filter: blur(10px);">
  <h4 class="fw-bold mb-4 text-center border-bottom pb-3">Dashboard</h4>

  <a href="dashboard.php" class="nav-link px-3 py-2 mb-2 <?= $current == 'dashboard.php' ? 'active' : '' ?>">
    <i class="fas fa-home me-2"></i> All
  </a>

  <a href="repliesTab.php"
    class="nav-link px-3 py-2 mb-2 <?= $current == 'repliesTab.php' ? 'active' : '' ?>">
    <i class="fas fa-inbox me-2"></i> Replies
    <!--<span id="repliesBadge" class="badge bg-secondary">0</span>-->
  </a>

  <a href="incoming.php"
    class="nav-link px-3 py-2 mb-2 <?= $current == 'incoming.php' ? 'active' : '' ?>">
    <i class="fas fa-inbox me-2"></i> Incoming
    <!--<span id="incomingBadge" class="badge bg-secondary">0</span>-->
  </a>

  <a href="feedback.php" class="nav-link px-3 py-2 mb-2 <?= $current == 'feedback.php' ? 'active' : '' ?>">
    <i class="fas fa-comment-dots me-2"></i> Feedback
  </a>

  <a href="complaints.php" class="nav-link px-3 py-2 mb-2 <?= $current == 'complaints.php' ? 'active' : '' ?>">
    <i class="fas fa-exclamation-circle me-2"></i> Complaints
  </a>

  <a href="Reports.php" class="nav-link px-3 py-2 mb-2 <?= $current == 'Reports.php' ? 'active' : '' ?>">
    <i class="fas fa-file-alt me-2"></i> Reports
  </a>
  <a href="balanceCheck.php" class="nav-link px-3 py-2 mb-2 <?= $current == 'balanceCheck.php' ? 'active' : '' ?>">
    <i class="fas fa-file-alt me-2"></i> Donations
  </a>
  <a href="adminLogin.php" class="nav-link px-3 py-2 <?= $current == 'balanceCheck.php' ? 'active' : '' ?>">
    <i class="fas fa-file-alt me-2"></i> <span class="fw-bold text-info">ADMIN</span>
  </a>

  <a href="index.php" class="nav-link px-3 pb-2 mt-auto text-danger <?= $current == 'index.php' ? 'active' : '' ?>">
    <i class="fas fa-sign-out-alt me-2 "></i> Exit
  </a>
</div>