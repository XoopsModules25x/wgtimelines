<table class='table table-<{$table_type|default:''}>'>
<{if $block > 0}>
    <tbody><{foreach item=item from=$block}>
        <tr class="<{cycle values="odd, even"}>">
            <td class="center">
                <a href="<{$item.url}>/index.php?op=list&amp;tl_id=<{$item.tl_id}>" title="<{$item.tl_name}>"><{$item.tl_name}></a>
                &nbsp;>&nbsp;
                <a href="<{$item.url}>/items.php?op=list&amp;item_id=<{$item.id}>" title="<{$item.title}>"><{$item.title}></a>
            </td>
        </tr>
    <{/foreach}>
    </tbody>
<{/if}>
</table>