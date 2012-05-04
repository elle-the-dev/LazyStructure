<?php
/**
 * Confirm deletion pages
 *
 * Wrapper template for pages that confirm deletion of items
 * @package LazyStructure
 */
class ConfirmDeleteTemplate extends AdminTemplate
{
    private $pageName;
    private $key;

    public function __construct($action, $key, $name, $template=false, $root=false)
    {
        $this->pageName = $name;
        $this->key = $key;
        parent::__construct($action, "confirmDelete".ucwords($name), $template, $root);
    }

    public function render()
    {
        if(empty($_POST['id']))
        {
            Reporting::setError("No {$this->pageName} selected");
            Reporting::setRedirect(PATH."admin/{$this->pageName}.php");
            Reporting::endDo();
            die;
        }
        
        $ids = array_map("intval", $_POST['id']);
        $db = new Model("admin/confirmDelete".ucwords($this->pageName));
        $db->placeholders = $db->getPlaceholders($ids);
        $this->body->content->list = new HtmlList($db->queryKeyRow($this->key, "select.sql", $ids));
        $this->body->content->list->generate();
        $this->body->content->ids = json_encode($ids);
        $this->body->content->addTemplate("content.tpl");

        parent::render();
    }
}
?>
