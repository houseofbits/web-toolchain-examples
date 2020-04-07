<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="/site"><?=$title?></a>
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="/site">Home</a>
    </li>
    <li class="nav-item active">
        <a class="nav-link" href="/site/add">Add product</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="/site/logs">Event log</a>
    </li>
  </ul>
</nav>

<?php
    if($page == Site::MAIN_PAGE){
        $this->load->view('partials/view', compact('products'));
    } else if($page == Site::FORM_PAGE){
        $this->load->view('partials/add');
    } else if($page == Site::LOGS_PAGE){
        $this->load->view('partials/logs');
    }
?>

<script src="/node_modules/jquery/dist/jquery.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>