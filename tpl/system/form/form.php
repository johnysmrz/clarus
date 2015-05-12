<form action="{$action}" method="{$method}">
    <table>
        <?php foreach ($this->items as $name => $item): ?>
            <tr>
                <td>{$item>getLabel()}</td>
                <td>{$item>display()}</td>
            </tr>
            <?php if (sizeof($item->getFailMessages()) > 0): ?>
            <tr>
                <td style="text-align: right"><img src="/img/admin/alert-ico16.png" alt="{_ Alert icon}" /></td>
                <td>
                    <ul class="failMessages">
                    <?php foreach ($item->getFailMessages() as $message): ?>
                        <li><?php echo $message ?></li>
                    <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</form>