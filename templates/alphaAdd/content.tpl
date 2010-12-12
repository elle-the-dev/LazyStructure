<h2>Alphas</h2>
<form method="post" action="<?php echo PATH; ?>do/doAlphaAdd.php" onsubmit="return formSubmit(this);">
    <table class="formTable">
        <tr>
            <td>Name:</td>
            <td>
                <input type="text" id="name" name="name" /><?php echo $this->fieldErrors['name']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" id="submit" name="submit" value="Submit" />
            </td>
        </tr>
    </table>
</form>

