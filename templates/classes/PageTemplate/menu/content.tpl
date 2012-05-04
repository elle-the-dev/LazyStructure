                <div id="tabs">
                    <ul id="<?php echo $this->tab; ?>Header">
                        <li class="home">
                            <a href="<?php echo PATH; ?>1/home" rel="address:1/home">Home</a>
                            <ul>
                                <li><a href="#">Lorem</a></li>
                                <li><a href="#">Ipsum</a></li>
                                <li><a href="#">Dolor</a></li>
                                <li><a href="#">Sit Amet</a></li>
                            </ul>
                        </li>
                        <li class="browse">
                            <a href="<?php echo PATH; ?>2/alpha" rel="address:2/alpha">Alpha</a>
                            <ul>
                                <li>
                                    <a href="#">Lorem</a>
                                    <ul>
                                        <li><a href="#">Lorem</a></li>
                                        <li><a href="#">Ipsum</a></li>
                                        <li><a href="#">Dolor</a></li>
                                        <li><a href="#">Sit Amet</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Ipsum</a></li>
                                <li>
                                    <a href="#">Dolor</a>
                                    <ul>
                                        <li><a href="#">Lorem</a></li>
                                        <li><a href="#">Ipsum</a></li>
                                        <li><a href="#">Dolor</a></li>
                                        <li><a href="#">Sit Amet</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Sit Amet</a></li>
                            </ul>
                        </li>
                        <li class="stats">
                            <a href="<?php echo PATH; ?>login.php" rel="address:login.php">Members</a>
                            <ul>
                                <li>
                                    <a href="<?php echo PATH; ?>3/join" rel="address:3/join">Join</a>
                                </li>
                                <li>
                                    <a href="<?php echo PATH; ?>login.php" rel="address:login.php">Login</a>
                                </li>
                                <li>
                                    <a href="do/doLogout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                        <?php $this->admin->render(); ?>
                    </ul>
                </div>

