    <div id="newTab">
        <table>
            <tr>
                <td><label for="newTabName">Name:</label></td>
                <td>
                    <input type="text" name="newTabName" id="newTabName" />
                </td>
            </tr>
            <tr>
                <td><label for="newTabPage">Page:</label></td>
                <td>
                    <input type="text" name="newTabUrl" id="newTabUrl" />
                </td>
            </tr>
            <tr>
                <td />
                <td>
                    <?php $this->pages->render(); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Submit" />
                </td>
            </tr>
        </table>
    </div>
