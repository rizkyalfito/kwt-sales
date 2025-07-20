<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= esc($title) ?> - KWT Sales</title>
  <!-- AdminLTE CSS CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/dashboard" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Info -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i> Admin User
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">Profile</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <i class="fas fa-store"></i>
      <span class="brand-text font-weight-light">KWT Sales</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php foreach ($sidebarMenu as $item): ?>
          <li class="nav-item">
            <a href="<?= esc($item['url']) ?>" class="nav-link <?= ($title === $item['title']) ? 'active' : '' ?>">
              <i class="nav-icon <?= esc($item['icon']) ?>"></i>
              <p><?= esc($item['title']) ?></p>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 600px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <h1><?= esc($title) ?></h1>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" id="main-content">
        <?= $this->renderSection('content') ?>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      KWT Sales System
    </div>
    <strong>&copy; 2024 KWT Sales.</strong> All rights reserved.
  </footer>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- AdminLTE JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
  // Intercept sidebar menu clicks
  $('.nav-sidebar a.nav-link').on('click', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    if (url === '#' || !url) return;

    // Load content via AJAX
    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'html',
      success: function(data) {
        // Parse the returned HTML to extract the content section
        var newContent = $('<div>').html(data).find('#main-content').html();
        if (newContent) {
          $('#main-content').html(newContent);

          // Update active menu item
          $('.nav-sidebar a.nav-link').removeClass('active');
          $('.nav-sidebar a.nav-link[href="' + url + '"]').addClass('active');

          // Update page title
          var newTitle = $('<div>').html(data).find('h1').first().text();
          if (newTitle) {
            // Remove existing title suffix if present to avoid duplication
            var cleanTitle = newTitle.replace(/ - KWT Sales$/, '');
            // Also remove duplicate title if present in h1 text
            cleanTitle = cleanTitle.replace(/^(.*) - \1$/, '$1');
            document.title = cleanTitle + ' - KWT Sales';
            $('.content-header h1').text(cleanTitle);
          }

          // Update browser history
          history.pushState(null, newTitle, url);
        }
      },
      error: function() {
        alert('Gagal memuat halaman.');
      }
    });
  });

  // Handle browser back/forward buttons
  window.onpopstate = function() {
    location.reload();
  };
});
</script>

</body>
</html>
