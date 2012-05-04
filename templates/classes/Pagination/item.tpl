<span class="page<?php echo current($this->pages) == $this->page ? ' current' : ''; ?>"><a href="<?php echo PATH.$this->queryString; ?>page=<?php echo current($this->pages); ?>" rel="address:<?php echo $this->queryString; ?>page=<?php echo current($this->pages); ?>"><?php echo current($this->pages); ?></a></span>
<?php
next($this->pages);
?>
