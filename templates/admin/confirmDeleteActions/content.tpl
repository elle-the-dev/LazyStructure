<p>
Are you sure you want to these actions?
</p>
<p>
<?php $this->list->render(); ?>
</p>
<form method="post" action="<?php echo PATH; ?>do/admin/doDeleteActions.php">
<input type="hidden" name="xsrfToken" value="<?php global $user; echo $user->xsrfToken; ?>" />
<textarea name="ids" style="width:1px;height:1px;visibility:hidden">
<?php echo $this->ids; ?>
</textarea>
<input type="submit" value="Delete" />
<input type="submit" name="cancel" value="Cancel" />
</form>
