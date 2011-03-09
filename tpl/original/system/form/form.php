<table>
    <form action="<?php echo $this->action ?>" method="<?php echo $this->method ?>">
        <?php foreach ($this->items as $name => $item): ?>
            <tr>
                <td><?php echo $item->getLabel() ?></td>
                <td><?php $item->display() ?></td>
            </tr>
        <?php endforeach; ?>
    </form>
</table>