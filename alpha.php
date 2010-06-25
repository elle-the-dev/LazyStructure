<?php
require_once('classloader.php');

$out = new PageTemplate();

$out->title = "Alpha";
$out->tab = "alpha";
$out->addSidebarItem("Add New", "alphaAdd.php");

$out->body .= <<<TEMPLATE
<h2>Alpha</h2>

<p>
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam dolor sapien, faucibus ut tempor quis, dapibus a risus. Nam fermentum sapien quis nunc semper vulputate pharetra in purus. Maecenas accumsan iaculis dolor, quis ultrices erat viverra quis. Pellentesque sollicitudin posuere semper. Duis tincidunt eros non nunc euismod consequat. Cras cursus ante eu odio congue sollicitudin. Vivamus at ipsum eu lacus gravida auctor sit amet suscipit elit. Quisque luctus semper felis in euismod. Quisque dolor odio, interdum vel placerat lacinia, pellentesque quis nulla. Curabitur volutpat pellentesque nisi, eget consequat ligula tempus in. Sed nunc urna, gravida et pellentesque ut, sollicitudin non lectus. Aliquam erat volutpat. Nullam eleifend auctor metus, eget dignissim tellus varius nec. Etiam urna ipsum, mattis vitae ultrices vel, molestie quis neque. Morbi nulla nisl, tincidunt a aliquam eu, sodales sed neque. Sed quis felis nec enim sodales tempor. 
</p>

<p>
Duis dui orci, ullamcorper in fermentum sit amet, imperdiet eu odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur leo nunc, semper eget consequat ac, eleifend egestas ligula. Sed adipiscing, est ut egestas cursus, mauris est bibendum nunc, sit amet interdum velit justo eget dui. Integer ornare, neque non commodo hendrerit, purus est pulvinar orci, sit amet euismod leo leo eget velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam leo lectus, fermentum eget euismod sit amet, tempor non tortor. Nullam vestibulum lobortis convallis. Nulla facilisi. Phasellus pellentesque leo posuere ante rutrum quis imperdiet neque volutpat. Fusce posuere, sapien ac tempor fermentum, felis orci volutpat metus, eu fringilla ipsum leo vel velit. Suspendisse augue quam, auctor eu ultrices sit amet, molestie et nisi. Suspendisse potenti. 
</p>

<p>
Proin ut elit ac massa imperdiet congue. Maecenas bibendum quam sit amet lorem aliquam elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce metus nunc, pellentesque ut luctus quis, elementum quis metus. Vivamus luctus nisl aliquam sapien porta vestibulum. Nullam fringilla sagittis elit ac varius. Quisque ut sem libero. Donec tristique purus vitae purus semper nec sodales lacus vestibulum. Sed sit amet lorem sapien. Etiam adipiscing ultrices purus consequat hendrerit. Fusce vehicula posuere vestibulum. Maecenas placerat massa massa, eget commodo tortor. Nullam tortor nibh, lacinia quis ultrices quis, cursus sit amet lectus. Vivamus sodales elit in ligula rutrum aliquam. Sed mattis pellentesque leo non imperdiet. Mauris gravida risus id dolor vestibulum lobortis. Donec velit tortor, porttitor in dictum ut, euismod non eros. Quisque sagittis, libero sit amet venenatis pulvinar, dui purus blandit massa, at placerat enim lorem ut eros. Morbi accumsan lacinia blandit. Proin in lorem at dolor sollicitudin auctor.
</p>
TEMPLATE;

$out->render();
?>
