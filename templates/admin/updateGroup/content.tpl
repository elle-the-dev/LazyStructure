<h2>Group</h2>
<p></p>
<form action="<?php echo PATH; ?>do/admin/doUpdateGroup.php" method="post" onsubmit="selectAll('allowedPages'); selectAll('allowedActions'); return formSubmit(this);">
    <p>
        <input type="hidden" name="id" value="<?php echo $this->id; ?>" />
        <input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
    </p>
    <table>
        <tr>
            <td><span class="required">*</span>Name:</td>
            <td>
                <input type="text" name="name" id="name" maxlength="20" value="<?php echo $this->fields['name']; ?>" /><?php echo $this->fieldErrors['name']; ?>
            </td>
        </tr>
        <tr>
            <td>Description:</td>
            <td>
                <textarea name="description" name="description" rows="8" cols="40"><?php echo $this->fields['description']; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Pages:</td>
            <td>
                <table class="permissions">
                    <tr>
                        <th>Disallowed</th>
                        <th />
                        <th>Allowed</th>
                    </tr>
                    <tr>
                        <td><?php $this->disallowedPages->render(); ?></td>
                        <td>
                            <input type="button" value=" >> " id="addPermissionPage" /><br />
                            <input type="button" value=" << " id="removePermissionPage" />
                        </td>
                        <td><?php $this->allowedPages->render(); ?></td>
                    </tr>
                </table>
            </td>
        </td>
        <tr>
            <td>Actions:</td>
            <td>
                <table class="permissions">
                    <tr>
                        <th>Disallowed</th>
                        <th />
                        <th>Allowed</th>
                    </tr>
                    <tr>
                        <td><?php $this->disallowedActions->render(); ?></td>
                        <td>
                            <input type="button" value=" >> " id="addPermissionAction" /><br />
                            <input type="button" value=" << " id="removePermissionAction" />
                        </td>
                        <td><?php $this->allowedActions->render(); ?></td>
                    </tr>
                </table>
            </td>
        </td>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
                <input type="submit" value="Cancel" name="cancel" onclick="cancelClicked()" />
            </td>
        </tr>
    </table>
</form>
<script src="<?php echo PATH; ?>js/permissions.js"></script>
<script src="<?php echo PATH; ?>js/updateGroup.js"></script>
