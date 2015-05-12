<h1>{_ Articles overview}</h1>
<table class="basic-overview round-table10" cellspacing="0">
    <tr>
        <th>{_ title}</th>
        <th>{_ perex}</th>
        <th>{_ edit}</th>
    </tr>
    {foreach from=$articles key=$key value=$value}
        <tr>
            <td>{$value>name}</td>
            <td>{$value>perex}</td>
            <td><a href="/admin/article/edit/{$value>id}">{_ edit}</a></td>
        </tr>
    {/foreach}
</table>