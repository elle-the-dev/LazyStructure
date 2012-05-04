<?php $item = current($this->items); ?>
                                <li class="<?php echo $item['class']; ?>"><a href="<?php echo $item['link']; ?>" rel="address:<?php echo $item['link']; ?>"><span><?php echo $item['title']; ?></span></a></li>
<?php next($this->items); ?>
