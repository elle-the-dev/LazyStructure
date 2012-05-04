<h2>Page</h2>
<p></p>
<form action="<?php echo PATH; ?>do/admin/doUpdatePage.php" method="post" onsubmit="return formSubmit(this);">
    <p>
        <input type="hidden" name="id" value="<?php echo $this->getElement($this->fields, 'id'); ?>" />
        <input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
    </p>
    <table>
        <tr>
            <td><span class="required">*</span><label for="title">Title:</label></td>
            <td>
                <input type="text" name="title" id="title" maxlength="100" value="<?php echo $this->getElement($this->fields, 'title'); ?>"<?php echo $this->disabled; ?> /><?php echo $this->getElement($this->fieldErrors, 'title'); ?>
            </td>
        </tr>
        <tr>
            <td><label for="editable">Editable:</label></td>
            <td>
                <input type="checkbox" name="editable" id="editable"<?php echo $this->editable; ?> />
            </td>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
                <input type="submit" value="Cancel" name="cancel" onclick="cancelClicked()" />
            </td>
        </tr>
    </table>
</form>
