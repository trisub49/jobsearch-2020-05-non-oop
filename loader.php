<?php
    $page = @$_GET['pg'];
    if (!empty($page) && $page != "news") include($page.'.php');
    else include('news.php');
?>