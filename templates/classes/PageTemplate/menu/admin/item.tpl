<?php
$item = current($this->items);
?>
                                <li class="ignore">
                                    <a href="<?php echo PATH; ?><?php echo $item['url']; ?>" rel="address:<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                                </li>
<?php
next($this->items);
?>
