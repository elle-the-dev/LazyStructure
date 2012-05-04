<h2>Change Password</h2>
<p></p>
<form action="<?php echo PATH; ?>do/admin/doChangePassword.php" method="post" onsubmit="return formSubmit(this);">
    <p>
        <input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
    </p>
    <table>
        <tr class="passwordRow">
            <td><span class="required">*</span><label for="passwordOld">Old Password:</label></td>
            <td>
                <input type="password" name="passwordOld" id="passwordOld" /><?php echo $this->fieldErrors['passwordOld']; ?>
            </td>
        </tr>
        <tr class="passwordRow">
            <td><span class="required">*</span><label for="passwordNew">New Password:</label></td>
            <td>
                <input type="password" name="passwordNew" id="passwordNew" /><?php echo $this->fieldErrors['passwordNew']; ?>
            </td>
        </tr>
        <tr class="passwordRow">
            <td><span class="required">*</span><label for="passwordConfirm">Confirm Password:</label></td>
            <td>
                <input type="password" name="passwordConfirm" id="passwordConfirm" /><?php echo $this->fieldErrors['passwordConfirm']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
                <input type="submit" value="Cancel" name="cancel" onclick="cancelClicked()" />
            </td>
        </tr>
    </table>
</form>
