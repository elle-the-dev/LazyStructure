<?php
/* This file is part of LazyTable.
 * LazyTable is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * LazyTable is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with LazyTable.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

class LazyTable
{
    private $rows;
    private $tableSettings;
    private $columnSettings;
    private $tableMarkup;
    private $dynCols;

    public function LazyTable($rows=array(), $tableSettings=array(), $columnSettings=array(), $dynCols=array())
    {
        $this->rows = $rows;
        $this->tableSettings = $tableSettings;
        $this->columnSettings = $columnSettings;
        $this->dynCols = $dynCols;
        if(isset($rows[0]))
            $this->generateTable();
    }

    public function render()
    {
        echo $this->tableMarkup;
    }

    private function getParamsMarkup($params)
    {
    /*
        Goes through the provided parameters and generates hidden fields
        to pass with either edit or delete
    */
        if(is_array($params))
        {
            $markup = "";
            foreach($params AS $key => $param)
            {
                $markup .= <<<TEMPLATE
                <input type="hidden" name="{$key}" value="{$param}" />
TEMPLATE;
            }
            return $markup;
        }
        else
            return "";
    }

    private function formatColumn($row, $col, $key)
    {   
    /*  
        Replaces __columnname__ placeholders with the appropriate row values
        and executes column-specific function calls
    */
        isset($row[$key]) ? $column = $row[$key] : $column = ""; 
        if(isset($col[$key]['formatFunction']))
        {   
            if(isset($col[$key]['formatArgs']))
            {   
                $arg = array();
                $replKey = preg_replace("/(.*)__(.*)__(.*)/", "$2", $col[$key]['formatArgs']);
                $count = 0;
                foreach($replKey as $rkey)
                {   
                    @$arg[] = preg_replace("/__(.*)__/", $row[$rkey], $col[$key]['formatArgs'][$count]);
                    ++$count;
                }   
            }   
            $column = call_user_func_array($col[$key]['formatFunction'], $arg);
        }   
        if(isset($col[$key]['link']))
        {   
            $link = $col[$key]['link'];
            do  
            {   
                $oldLink = $link;
                $replKey = preg_replace("/(.*)?__(.*)?__(.*)?/U", "$2,", $link);
                $replKey = rtrim($replKey, ',');
                $keys = explode(',', $replKey);
                if(!empty($keys))
                {   
                    foreach($keys as $replKey)
                    {   
                        if(isset($row[$replKey]))
                            $link = preg_replace("/__(.*)?__/U", $row[$replKey], $link, 1); 
                    }   
                }   
            }   
            while($link != $oldLink);
            $column = '<a href="'.$link.'">'.$column.'</a>';


            /*  
            $replKey = preg_replace("/(.*)__(.*)__(.*)/", "$2", $col[$key]['link']);
            $link = preg_replace("/__(.*)__/", $row[$replKey], $col[$key]['link']);
            $column = '<a href="'.$link.'">'.$column.'</a>';
            */
        }
        return $column;
    }

    public function generateTable()
    {
        /*
            generateTable does just what it says: generates the table
            The available settings are specified below along with valid options

            In the appropriate columns (currently maximum one per column value)
            a placeholder can be specified to be replaced by the value in the
            related column.  For example, you have columns A and B.  In a setting
            for column B, the value is __A__.  The value in the column A in the
            current row with be substituted.
        */

        /*
           $tableSettings['id']            = "drawTable"  [string];
           Denotes the ID attribute of the HTML table element created

           $tableSettings['class']         = "drawTable"  [string];
           Denotes the CLASS attribute of the HTML table element created

           $tableSettings['key']           = "id"  [string];
           A hidden field value passed to edit/delete to indicate which row

           $tableSettings['keyName']       = "id"  [string];
           The name of the hidden key field specifying which row to edit/delete

           $tableSettings['page']          = 1     [int];
           Specifies which page of the table to display

           $tableSettings['perPage']       = 20    [int];
           Specifies how many rows to display per page

           $tableSettings['sortable']      = true  [bool]
           Denotes whether the table has sortable columns

           $tableSettings['editable']      = false [true];
           Denotes whether rows can be edited

           $tableSettings['deletable']     = false [true];
           Denotes whether rows can be deleted

           $tableSettings['editAction']    = null  [string];
           A string specifying where the edit button should point

           $tableSettings['editMethod']    = null  [POST|GET];
           A string specifying whether to send edits via POST or GET 

           $tableSettings['editParams']    = array [array]
           An associative array of values where the key is the name of the hidden field to be displayed.  The value is passed in a hidden field with the edit form.
           
           $tableSettings['deleteAction']  = null  [string];
           A string specifying where the delete button should point

           $tableSettings['deleteMethod']  = null  [POST|GET];
           A string specifying whether to send deletes via POST or GET 

           $tableSettings['deleteParams']  = array [array]
           An associative array of values where the key is the name of the hidden field to be displayed.  The value is passed in a hidden field with the edit form.


           $columnSettings[column]['heading']  = [column] [string];
           A string specifying what text should be displayed as a heading of the column.  Defaults to the column name.

           $columnSettings[column]['visible']  = true     [false];
           Denotes whether the column should be displayed.

           $columnSettings[column]['sorted']   = null     [ASC|DESC];
           Denotes whether the column should initially be sorted.  If the value is either ASC or DESC, it is sorted as specified.

           $columnSettings[column]['sortable'] = true     [bool]
           Denotes whether the column has the ability to be sorted.

           $columnSettings[column]['formatFunction'] = null [function];
           The private function to be used to format the column value

           $columnSettings[column]['formatArgs']     = null [array]
           The array of arguments to be passed to the function

           $columnSettings[column]['link']           = null [string]
           The URL to which a column value is linked

           $columnSettings[column]['sum']            = false [bool]
           Denotes if the column should be totaled 
         */

        $rows = $this->rows;
        $tableSettings = $this->tableSettings;
        $columnSettings = $this->columnSettings;
        $dynCols = $this->dynCols;

        $tableDefaults = array (
                'id'            => "drawTable",
                'class'         => "drawTable",
                'key'           => "id",
                'keyName'       => "id",
                'page'          => 1,
                'perPage'       => 20,
                'sortable'      => true,
                'editable'      => false,
                'deletable'     => false,
                'editAction'    => "",
                'editMethod'    => "post",
                'editParams'    => array(),
                'deleteAction'  => "",
                'deleteMethod'  => "post",
                'deleteParams'  => array()
                );

        $columnDefaults = array (
                'visible'   => true,
                'sorted'    => null,
                'sortable'  => true,
                'editable'  => false,
                'formatFunction'    => null,
                'formatArgs'        => null,
                'link'      => null,
                'sum'       => false
                );

        //Setting the default table settings
        isset($tableSettings['id'])             ? $id           = $tableSettings['id']              : $id           = $tableDefaults['id'];
        isset($tableSettings['class'])          ? $class        = $tableSettings['class']           : $class        = $tableDefaults['class'];
        isset($tableSettings['key'])            ? $tableKey     = $tableSettings['key']             : $tableKey     = $tableDefaults['key'];
        isset($tableSettings['keyName'])        ? $tableKeyName = $tableSettings['keyName']         : $tableKeyName = $tableDefaults['keyName'];
        isset($tableSettings['page'])           ? $page         = $tableSettings['page']            : $page         = $tableDefaults['page'];
        isset($tableSettings['perPage'])        ? $perPage      = $tableSettings['perPage']         : $perPage      = $tableDefaults['perPage'];
        isset($tableSettings['sortable'])       ? $sortable     = $tableSettings['sortable']        : $sortable     = $tableDefaults['sortable'];
        isset($tableSettings['editable'])       ? $editable     = $tableSettings['editable']        : $editable     = $tableDefaults['editable'];
        isset($tableSettings['editAction'])     ? $editAction   = $tableSettings['editAction']      : $editAction   = $tableDefaults['editAction'];
        isset($tableSettings['editMethod'])     ? $editMethod   = $tableSettings['editMethod']      : $editMethod   = $tableDefaults['editMethod'];
        isset($tableSettings['editParams'])     ? $editParams   = $tableSettings['editParams']      : $editParams   = $tableDefaults['editParams'];
        isset($tableSettings['deletable'])      ? $deletable    = $tableSettings['deletable']       : $deletable    = $tableDefaults['deletable'];
        isset($tableSettings['deleteAction'])   ? $deleteAction = $tableSettings['deleteAction']    : $deleteAction = $tableDefaults['deleteAction'];
        isset($tableSettings['deleteMethod'])   ? $deleteMethod = $tableSettings['deleteMethod']    : $deleteMethod = $tableDefaults['deleteMethod'];
        isset($tableSettings['deleteParams'])   ? $deleteParams = $tableSettings['deleteParams']    : $deleteParams = $tableDefaults['deleteParams'];

        if($editable)
            $editParamsMarkup = self::getParamsMarkup($editParams);
        if($deletable)
            $deleteParamsMarkup = self::getParamsMarkup($deleteParams);

        $output = <<<TEMPLATE
<table id="{$id}" class="{$class}">
TEMPLATE;

        $showSum = false;
        $sortParam = "";
        if(is_array($rows))
        {
            $headCount = 0;
            $output .= '<thead><tr>';
            if($deletable)
            {
                $output .= '<th><input type="checkbox" class="deleteSelectedCheckbox" onchange="applyAll(this)" /></th>';
                $headCount++;
            }

            if($editable)
            {
                $output .= "<th></th>";
                $headCount++;
            }

            $comma = "";
            $firstColSort = "";
            for($i=0;$i<$headCount;++$i)
            {
                $firstColSort .= "{$comma}{$i}: { sorter: false }";
                $comma = ", ";
            }

            $sortList = "sortList: [";
            $comma = "";
            $sums = array();
            foreach($dynCols AS $key => $column)
            {
                $rows[0][$key] = $column;
            }
            foreach($rows[0] AS $key => $column)
            {
                //Setting the default column settings
                isset($columnSettings[$key]) ? $cs = $columnSettings[$key] : $cs = null;
                isset($cs['heading'])   ? $col[$key]['heading']     = $cs['heading'] : $col[$key]['heading'] = $key;
                isset($cs['visible'])   ? $col[$key]['visible']     = $cs['visible'] : $col[$key]['visible'] = $columnDefaults['visible'];
                isset($cs['sorted'])    ? $col[$key]['sorted']      = $cs['sorted'] : $col[$key]['sorted'] = $columnDefaults['sorted'];
                isset($cs['sortable'])  ? $col[$key]['sortable']    = $cs['sortable'] : $col[$key]['sortable'] = $columnDefaults['sortable'];
                isset($cs['formatFunction']) ? $col[$key]['formatFunction'] = $cs['formatFunction'] : $col[$key]['formatFunction'] = $columnDefaults['formatFunction'];
                isset($cs['formatArgs']) ? $col[$key]['formatArgs'] = $cs['formatArgs'] : $col[$key]['formatArgs']  = $columnDefaults['formatArgs'];
                isset($cs['link'])       ? $col[$key]['link']       = $cs['link']       : $col[$key]['link']        = $columnDefaults['link'];
                isset($cs['sum'])        ? $col[$key]['sum']        = $cs['sum']        : $col[$key]['sum']         = $columnDefaults['sum'];

                if($col[$key]['visible'])
                {
                    $output .= <<<TEMPLATE
                        <th>{$col[$key]['heading']}</th>
TEMPLATE;
                    if(!$col[$key]['sortable'])
                        $sortParam .= ", {$headCount}: { sorter: false }";
                    if(!empty($col[$key]['sorted']))
                    {
                        strtolower($col[$key]['sorted']) == "desc" ? $order = 1 : $order = 0;
                        $sortList .= "{$comma}[{$headCount},$order]";
                        $comma = ",";
                    }
                    ++$headCount;
                }
            }
            foreach($dynCols AS $key => $column)
                unset($rows[0][$key]);
            $sortList .= ']';
            $sortParam = "headers: { {$firstColSort}{$sortParam} }, {$sortList}";
            $output .= '</tr></thead>';

            $outputBody = '<tbody>';
            $rowClass = 'even';

            foreach($rows AS $row)
            {
                //$outputBody .= '<tr class="'.$rowClass.'">';

                $outputBody .= '<tr>';

                if($deletable)
                {
                    $outputBody .= <<<TEMPLATE
                    <td class="delete">
                        <input type="checkbox" name="{$tableKeyName}[]" value="{$row[$tableKey]}" class="deleteCheckbox" />
                    </td>
TEMPLATE;
                }

                if($editable || $deletable)
                    $outputBody .= '<td class="editdelete">';
                if($editable)
                {
                    $outputBody .= <<<TEMPLATE
                        <form method="{$editMethod}" action="{$editAction}" class="editForm">
                            <div>
                                <button type="submit" class="editable" title="Edit">EDIT</button>
                                <input type="hidden" name="{$tableKeyName}" value="{$row[$tableKey]}" />
                                {$editParamsMarkup}
                            </div>
                        </form>
TEMPLATE;
                }

                if($deletable)
                {
                    $outputBody .= <<<TEMPLATE
                        <form method="{$deleteMethod}" action="{$deleteAction}" class="deleteForm">
                            <div>
                                <button type="submit" class="deletable" title="Delete">DELETE</button>
                                <input type="hidden" name="{$tableKeyName}[]" value="{$row[$tableKey]}" />
                                {$deleteParamsMarkup}
                            </div>
                        </form>
TEMPLATE;
                }

                if($editable || $deletable)
                    $outputBody .= '</td>';

                foreach($row AS $key => $column)
                {
                    if($col[$key]['visible'])
                    {
                        if($col[$key]['sum'])
                        {
                            $showSum = true;
                            if(!isset($sums[$key]))
                                $sums[$key] = $column;
                            else
                                $sums[$key] += $column;
                        }
                        else
                            $sums[$key] = "";

                        $column = self::formatColumn($row, $col, $key);

                        $outputBody .= <<<TEMPLATE
                            <td>{$column}</td>
TEMPLATE;
                    }
                }

                foreach($dynCols AS $dynKey => $dynCol)
                {
                    if($col[$dynKey]['visible'])
                    {
                        if($col[$dynKey]['sum'])
                        {
                            $showSum = true;
                            if(!isset($sums[$dynKey]))
                                $sums[$dynKey] = $dynCol;
                            else
                                $sums[$dynKey] += $dynCol;
                        }
                        else
                            $sums[$dynKey] = "";

                        $dynCol = self::formatColumn($row, $col, $dynKey);

                        $outputBody .= <<<TEMPLATE
                            <td>{$dynCol}</td>
TEMPLATE;
                    }
                }

                $rowClass == "odd" ? $rowClass = "even" : $rowClass = "odd";
                $outputBody .= '</tr>';
            }
           
            $outputBody .= '</tbody>';

            $tfoot = "";
            if($showSum)
            {
                $tfoot .= '<tr class="sums">'; 
                if($editable || $deletable)
                    $tfoot .= '<th />';
                foreach($sums AS $key => $sum)
                {
                    $sum = self::formatColumn($sums, $col, $key);
                    $tfoot .= <<<TEMPLATE
                    <th>{$sum}</th>
TEMPLATE;
                }
                $tfoot .= '</tr>';
            }

            if($deletable)
            {
                $tfoot .= <<<TEMPLATE
                <tr>
                <td colspan="{$headCount}" class="deleteSelected">
                    <script type="text/javascript">
                        function applyAll(obj)
                        {
                            if(obj.checked)
                                $('.deleteCheckbox').attr('checked', true);
                            else
                                $('.deleteCheckbox').attr('checked', false);
                        }
                        function importCheckboxes(formObj)
                        {
                            var objs = $('.deleteCheckbox').clone().appendTo('.checkboxContainer');
                        }
                    </script>
                    <form method="{$deleteMethod}" action="{$deleteAction}" class="deleteSelectedForm" onsubmit="importCheckboxes(this)">
                        <div class="selectAll">
                            <span class="right">
                                <button type="submit" class="deletableSelect">Delete Selected</button>
                            </span>
                            {$deleteParamsMarkup}
                        </div>
                        <div class="checkboxContainer" style="display:none"></div>
                    </form>
                </td>
                </tr>
TEMPLATE;
            }

        }
        if(!empty($tfoot))
            $tfoot = "<tfoot>$tfoot</tfoot>";
        $output .= $tfoot;
        $output = $output.$outputBody;
        $output .= '</table>';

        if($sortable)
        {
            // jQuery scripting for compatibility with the tablesorter plugin
            // Disabled by setting sortable to false in tableSettings
            $output .= <<<TEMPLATE
            <script type="text/javascript">
            /*
            $(document).ready(function() {
                        $("#{$id}")
                        .tablesorter( { {$sortParam}, widgets: ['zebra'] } )
                        .tablesorterPager( { container: $('#pager') } );
                    }
               );
               */
            </script>
TEMPLATE;
        }

        $this->tableMarkup = $output;
    }

    public function getTableMarkup()
    {
        return $this->tableMarkup;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getTableSettings()
    {
        return $this->tableSettings;
    }

    public function getColumnSettings()
    {
        return $this->columnSettings;
    }

    public function getDynCols()
    {
        return $this->dynCols;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
    }

    public function setTableSettings($tableSettings)
    {
        $this->tableSettings = $tableSettings;
    }

    public function setColumnSettings($columnSettings)
    {
        $this->columnSettings = $columnSettings;
    }

    public function setDynCols($dynCols)
    {
        $this->dynCols = $dynCols;
    }
}
?>
