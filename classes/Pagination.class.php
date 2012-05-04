<?php
class Pagination
{
    private $pagination;
    private $total;
    private $page;
    private $perPage;
    private $breakPages;
    private $path;
    private $limit;
    private $type;

    public function __construct($total, $page, $perPage, $breakPages, $path)
    {
        $this->pagination = new View("classes/Pagination");
        $this->total = $total;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->breakPages = $breakPages;
        $this->path = $path;

        $start = $this->page * $this->perPage - $this->perPage;
        $this->limit = "$start, ".$perPage;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function generate()
    {
        $offset = (ceil($this->breakPages / 2) / 2);

        $numPages = ceil($this->total / $this->perPage);
        if($numPages == 1)
            return;

        if($this->breakPages < 1+$offset || $this->page > $numPages - $offset*2)
        {
            $startA = 1;
            $endA = ceil($this->breakPages / 2);
        }
        else
        {
            $startA = $this->page - $offset;
            $endA = $this->page + $offset;
        }
        if($startA < 1)
            $startA = 1;
        if($endA > $numPages)
            $endA = $numPages;

        $startB = $numPages - $offset * 2;
        if($startB <= $endA)
            $startB = $endA+1;
        $endB = $numPages;

        $pieces = explode('?', $_SERVER['REQUEST_URI']);
        $queryString = $this->path.basename($pieces[0].'?');
        $phpFile = basename($_SERVER['SCRIPT_FILENAME']).'?';
        if(!empty($pieces[1]))
        {
            $pieces[1] = preg_replace('/([\&\?]?)page=[0-9]+/', '', $pieces[1]);
            if(!empty($pieces[1]))
            {
                $queryString .= $pieces[1].'&amp;';
                $phpFile .= $pieces[1].'&amp;';
            }
        }
        $this->pagination->queryString = $queryString;

        $pages = array();
        $this->pagination->numPages = $numPages;
        $this->pagination->page = $this->page;
        $this->pagination->addTemplate("open.tpl");
        if($this->page > 1)
            $this->pagination->addTemplate("firstPrev.tpl");

        for($i=$startA;$i<=$endA;++$i)
        {
            $pages[] = $i;
            $this->pagination->addTemplate("item.tpl");
        }

        if($endA < $numPages)
        {
            $this->pagination->addTemplate("ellipsis.tpl");

            for($i=$startB;$i<=$endB;++$i)
            {
                $pages[] = $i;
                $this->pagination->addTemplate("item.tpl");
            }
        }
        if($this->page < $numPages)
            $this->pagination->addTemplate("nextLast.tpl");
        $this->pagination->addTemplate("close.tpl");
        $this->pagination->pages = $pages;
    }

    public function render()
    {
        if(is_array($this->pagination->pages))
            reset($this->pagination->pages);
        $this->pagination->render();
    }
}
