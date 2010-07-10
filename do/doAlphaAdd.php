<?php
require_once('../classloader.php');
$name = $_POST['name'];

if(empty($name))
    Reporting::setFieldError("name", "Cannot be blank");
if(Reporting::hasFieldErrors())
    Reporting::setError("Name cannot be blank");

if(!Reporting::hasErrors())
{
    $db->query("INSERT INTO alpha (name) VALUES(?)", $name);
    Reporting::setSuccess("<em>$name</em> added successfully");
}

Reporting::endDo();
?>
