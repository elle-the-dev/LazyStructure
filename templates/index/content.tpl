<script type="text/javascript" src="<?php echo PATH; ?>nicedit/nicEdit.php"></script>
<div id="adminPanel">
    <div id="userContentPanel"></div>
    <div id="adminErrors" class="errors"></div>
    <div id="adminSuccesses" class="successes"></div>
    <div id="userContentPanelBg">&nbsp;</div>
</div>
<div id="<?php echo $this->divId; ?>">
    <?php echo $this->pageContent; ?>
</div>
<input type="hidden" id="pageId" value="<?php echo $this->pageId; ?>" />
<input type="hidden" id="xsrfToken" value="<?php echo $this->xsrfToken; ?>" />
<input type="hidden" id="path" value="<?php echo PATH; ?>" />
