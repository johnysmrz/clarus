<h1>{_ Articles overview}</h1>
<table class="basic-overview round-table10" cellspacing="0">
    <tr>
        <th>{_ title}</th>
        <th>{_ perex}</th>
        <th>{_ edit}</th>
    </tr>
    {foreach from=$articles key=$key value=$value}
        <tr>
            <td><?php echo $value->getTitle() ?></td>
            <td><?php echo $value->getPerex() ?></td>
            <td>{$value>getTitle()}</td>
            <td><a href="/admin/article/edit/<?php echo $key ?>">{_ edit}</a></td>
        </tr>
    {/foreach}
</table>