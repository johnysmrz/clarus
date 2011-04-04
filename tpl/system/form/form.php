<form action="{$action}" method="{$method}">
    <table>
        <?php foreach ($this->items as $name => $item): ?>
            <tr>
                <td><?php echo $item->getLabel() ?></td>
                <td><?php $item->display() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>