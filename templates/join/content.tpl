<form action="<?php echo PATH; ?>do/doJoin.php" method="post" onsubmit="return formSubmit(this);">
    <table id="join">
        <tr>
            <td>Username:</td>
            <td>
                <input type="text" name="username" id="username" maxlength="20" /><?php echo $fieldErrors['username']; ?>
            </td>
        </tr>
        <tr>
            <td>Password:</td>
            <td>
                <input type="password" name="password" id="password" /><?php echo $fieldErrors['password']; ?>
            </td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="passwordConfirm" id="passwordConfirm" /><?php echo $fieldErrors['passwordConfirm']; ?>
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="email" id="email" maxlength="100" /><?php echo $fieldErrors['email']; ?>
            </td>
        </tr>
        <tr>
            <td>Name:</td>
            <td>
                <input type="text" name="name" id="name" maxlength="30" /><?php echo $fieldErrors['name']; ?>
            </td>
        </tr>
        <tr>
            <td>Surname:</td>
            <td>
                <input type="text" name="surname" id="surname" maxlength="30" /><?php echo $fieldErrors['surname']; ?>
            </td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td>
                <input type="text" name="phone" id="phone" /><?php echo $fieldErrors['phone']; ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2">Address:</td>
            <td>
                <input type="text" name="address1" maxlength="100" /><?php echo $fieldErrors['address1']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="address2" maxlength="100" /><?php echo $fieldErrors['address2']; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Submit" />
            </td>
        </tr>
    </table>
</form>
