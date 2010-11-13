<?php
require_once('../classloader.php');

$out = new PageTemplate();
$out->title .= "Page cannot be found";
$out->body .= <<<OUT
<h2>Error 404</h2>
<p>
    Page cannot be found.
</p>
OUT;

$out->render();
?>
