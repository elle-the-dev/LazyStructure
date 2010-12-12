                        <?php $this->sidebar->render(); ?>

                        <div id="mainContent">
                            <h2 id="pageHeading"><?php echo $this->heading; ?></h2>

        <!-- ************************************ PAGE CONTENT BEGINS ************************************ -->

                            <?php $this->messages->render(); ?>
                            <?php $this->content->render(); ?>

        <!-- ************************************* PAGE CONTENT ENDS ************************************ -->
                        </div> <!-- mainContent -->

