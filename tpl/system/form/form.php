<form action="{$action}" method="{$method}">
    <table>
        <?php foreach ($this->items as $name => $item): ?>
            <tr>
                <td>{$item>getLabel()}</td>
                <td>{$item>display()}</td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>