<?php

require_once("config.php");

?><!doctype html>
<html>
<head>
  <title>AWS Deployment Test #1 by IT-Giants</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
  <style type="text/css">
@font-face {
  font-family: 'Syncopate-Regular';
  src:  url('media/Syncopate-Regular.ttf') format('ttf');
}
@font-face {
  font-family: 'Syncopate-Bold';
  src:  url('media/Syncopate-Bold.ttf') format('ttf');
}
  </style>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <style type="text/css">
body { padding-top:60px; }
.navbar-brand img { height:2em; margin:-0.5em 0 0 0; }
article { min-height:10em; font-size:2em; }
footer { font-size:2em; }
  </style>
  <script type="text/javascript">
  </script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img src="images/it-giants-logo-text.png" alt="AWS Deployment Test #1 by IT-Giants">
      </a>
    </div>
  </div>
</nav>
<header class="page-header">
  <div class="container-fluid">
    <h1>AWS Deployment Test #1 by IT-Giants <small></small></h1>
  </div>
</header>
<article>
  <div class="container-fluid">
    <div class="col-sm-12">
      <p><span class="label label-default">Step 1: Initial environment deployment.</span></p>
      <p><span class="label label-default">Step 2: Some minor changes in HTML.</span></p>
      <p><span class="label label-default">Step 3: Getting the JSON data from external server - fails due to incorrect JSON.</span></p>
      <p><span class="label label-primary">Step 4 (current): Getting the JSON data from external server - successful this time</span></p>
    </div>

    <table class="table" style="font-size:0.7em; color:#999;">
<?php

$response = file_get_contents(SERVER_HOST_URL . SERVER_HOST_PATH_HOME);
$data = json_decode($response, TRUE);

if (is_array($data) && !empty($data)) { foreach($data as $post) { ?>
      <tr>
        <th width="5%"><?php echo $post["id"]; ?></th>
        <th width="10%"><?php echo $post["name"]; ?></th>
        <td width="85%"><?php echo $post["body"]; ?></td>
      </tr>
<?php } } else { ?>
      <tr><th>No posts found at the external server</th></tr>
<?php } ?>
    </table>

    <div class="col-sm-12" style="font-size:0.7em; color:#999;">Total posts: <?php echo count($data); ?></div>
  </div>
</article>
<footer>
  <div class="container-fluid">
    <div class="col-sm-12">
      <p>Page generated on <b><?php echo date("Y-m-d"); ?></b> at <b><?php echo date("H:i:s"); ?></b></p>
    </div>
  </div>
</div>
</body>
</html>
