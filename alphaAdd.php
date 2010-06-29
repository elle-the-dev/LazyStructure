<?php
require_once('classloader.php');

$out = new PageTemplate();

$out->title = "Add an Alpha";

$form = drawFormTable("do/doAlphaAdd.php", array("name"));
$out->body .= <<<TEMPLATE
<h2>Alphas</h2>

{$form}
TEMPLATE;

$out->render();

function drawFormTable($action, $items)
{
    isset($fieldErrors) ? $fieldErrors = $_SESSION['fieldErrors'] : $fieldErrors = array();
    unset($_SESSION['fieldErrors']);
    $output = <<<TEMPLATE
    <form method="post" action="{$action}" onsubmit="return formSubmit(this);">
        <table class="formTable">
TEMPLATE;
    foreach($items AS $item)
    {
        $label = $item;
        $label{0} = strtoupper($item{0});
        $output .= <<<TEMPLATE
            <tr>
                <td>{$label}:</td>
                <td>
                    <input type="text" id="{$item}" name="{$item}" />{$fieldErrors[$item]}
                </td>
            </tr>
TEMPLATE;
    }
    $output .= <<<TEMPLATE
            <tr>
                <td colspan="2">
                    <input type="submit" id="submit" name="submit" value="Submit" />
                </td>
            </tr>
        </table>
    </form>
TEMPLATE;
    return $output;
}
?>
