<select name="<?php echo $this->getHtmlName() ?>" id="<?php echo $this->getHtmlId() ?>">
<?php foreach($this->selectOptions as $key => $value): ?>
    <?php if($this->value == $key): ?>
        <option selected="selected" value="<?php echo $key ?>"><?php echo $value ?></option>
    <?php else: ?>
        <option value="<?php echo $key ?>"><?php echo $value ?></option>
    <?php endif; ?>
<?php endforeach; ?>
</select>