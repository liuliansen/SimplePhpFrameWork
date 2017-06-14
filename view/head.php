<?php
use includes\App;
$httpRoot = App::getConf('httpRoot');
$rq = App::getConf('routeParam');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <link href="<?=$httpRoot?>/resource/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$httpRoot?>/resource/css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="<?=$httpRoot?>/resource/js/jquery-1.9.1.min.js"></script>
    <script src="<?=$httpRoot?>/resource/js/bootstrap.min.js"></script>
    <script src="<?=$httpRoot?>/resource/js/sha1.js"></script>
    <script>
        var host = '<?=$httpRoot?>';
        var rq =   '<?=$rq?>';
    </script>
</head>
<body>