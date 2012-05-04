<h2>Action</h2>
<p></p>
<form action="<?php echo PATH; ?>do/admin/doUpdateAction.php" method="post" onsubmit="return formSubmit(this);">
    <p>
        <input type="hidden" name="id" value="<?php echo $this->fields['id']; ?>" />
        <input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
    </p>
    <table>
        <tr>
            <td><span class="required">*</span><label for="key">Key:</label></td>
            <td>
                <input type="text" name="key" id="key" maxlength="20" value="<?php echo $this->fields['key']; ?>"<?php echo $this->disabled; ?> /><?php echo $this->fieldErrors['key']; ?>
            </td>
        </tr>
        <tr>
            <td><span class="required">*</span><label for="name">Name:</label></td>
            <td>
                <input type="text" name="name" id="name" maxlength="100" value="<?php echo $this->fields['name']; ?>" /><?php echo $this->fieldErrors['name']; ?>
            </td>
        </tr>
        <tr>
            <td><label for="description">Description:</label></td>
            <td>
                <textarea name="description" id="description"><?php echo $this->fields['description']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Cancel" name="cancel" onclick="cancelClicked()" />
                <input type="submit" value="Submit" />
            </td>
        </tr>
    </table>
</form>
