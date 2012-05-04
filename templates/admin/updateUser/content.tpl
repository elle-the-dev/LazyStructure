<h2>User</h2>
<p></p>
<form action="<?php echo PATH; ?>do/admin/doUpdateUser.php" method="post" onsubmit="selectAll('allowedGroups'); return formSubmit(this);">
    <p>
        <input type="hidden" name="id" value="<?php echo $this->id; ?>" />
        <input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
    </p>
    <table id="join">
        <tr>
            <td><span class="required">*</span><label for="username">Username:</label></td>
            <td>
                <input type="text" name="username" id="username" maxlength="20" value="<?php echo $this->getElement($this->fields, 'username'); ?>"<?php echo $this->disabled; ?> /><?php echo $this->fieldErrors['username']; ?>
            </td>
        </tr>
        <?php echo $this->changePassword->render(); ?>
        <tr class="passwordRow">
            <td><span class="required">*</span><label for="password">Password:</label></td>
            <td>
                <input type="password" name="password" id="password" /><?php echo $this->fieldErrors['password']; ?>
            </td>
        </tr>
        <tr class="passwordRow">
            <td><span class="required">*</span><label for="passwordConfirm">Confirm Password:</label></td>
            <td>
                <input type="password" name="passwordConfirm" id="passwordConfirm" /><?php echo $this->fieldErrors['passwordConfirm']; ?>
            </td>
        </tr>
        <tr>
            <td><span class="required">*</span><label for="email">Email:</label></td>
            <td>
                <input type="text" name="email" id="email" maxlength="100" value="<?php echo $this->getElement($this->fields, 'email'); ?>" /><?php echo $this->fieldErrors['email']; ?>
            </td>
        </tr>
        <tr>
            <td><label for="name">Name:</label></td>
            <td>
                <input type="text" name="name" id="name" maxlength="30" value="<?php echo $this->getElement($this->fields, 'name'); ?>" /><?php echo $this->fieldErrors['name']; ?>
            </td>
        </tr>
        <tr>
            <td><label for="surname">Surname:</label></td>
            <td>
                <input type="text" name="surname" id="surname" maxlength="30" value="<?php echo $this->getElement($this->fields, 'surname'); ?>" /><?php echo $this->fieldErrors['surname']; ?>
            </td>
        </tr>
        <tr>
            <td><span class="required">*</span><label for="phone">Phone:</label></td>
            <td>
                <input type="text" name="phone" id="phone" value="<?php echo $this->getElement($this->fields, 'phone'); ?>" /><?php echo $this->fieldErrors['phone']; ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2"><label for="address1">Address:</label></td>
            <td>
                <input type="text" name="address1" maxlength="100" value="<?php echo $this->getElement($this->fields, 'address1'); ?>" /><?php echo $this->fieldErrors['address1']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="address2" maxlength="100" value="<?php echo $this->getElement($this->fields, 'address2'); ?>" /><?php echo $this->fieldErrors['address2']; ?>
            </td>
        </tr>
        <tr>
            <td><label for="city">City:</label></td>
            <td>
                <input type="text" name="city" id="city" maxlength="100" value="<?php echo $this->getElement($this->fields, 'city'); ?>" /><?php echo $this->fieldErrors['city']; ?>
            </td>
        </tr>
        <tr>
            <td>Groups:</td>
            <td>
                <table class="permissions">
                    <tr>
                        <th>Disallowed</th>
                        <th />
                        <th>Allowed</th>
                    </tr>
                    <tr>
                        <td><?php $this->disallowedGroups->render(); ?></td>
                        <td>
                            <input type="button" value=" >> " id="addPermission" /><br />
                            <input type="button" value=" << " id="removePermission" />
                        </td>
                        <td><?php $this->allowedGroups->render(); ?></td>
                    </tr>
                </table>
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
<script src="<?php echo PATH; ?>js/permissions.js"></script>
<script src="<?php echo PATH; ?>js/updateUser.js"></script>
