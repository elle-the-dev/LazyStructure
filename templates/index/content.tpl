<script type="text/javascript" src="<?php echo PATH; ?>nicedit/nicEdit.php"></script>
<?php echo $this->adminPanel->render(); ?>
<div id="<?php echo $this->divId; ?>">
    <?php echo $this->pageContent; ?>
</div>
<input type="hidden" id="pageId" value="<?php echo $this->pageId; ?>" />
<input type="hidden" id="xsrfToken" value="<?php echo $this->xsrfToken; ?>" />
<input type="hidden" id="path" value="<?php echo PATH; ?>" />
