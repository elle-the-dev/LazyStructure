<?php
require_once('../global.php');
$name = $_POST['name'];

if(empty($name))
    Reporting::setFieldError("name", "Cannot be blank");
if(Reporting::hasFieldErrors())
    Reporting::setError("Name cannot be blank");

if(!Reporting::hasErrors())
{
    $db->query("insert.sql", $name);
    Reporting::setSuccess("<em>$name</em> added successfully");
}

Reporting::endDo();
?>
