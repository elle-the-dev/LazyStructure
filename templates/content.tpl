<h2>You forgot to provide PageTemplate with the name parameter.  This is the wrong content.tpl file.</h2>
<p>
<pre>
    $out = new PageTemplate(); // BAD
    $out = new PageTemplate("index"); // GOOD
</pre>
</p>
