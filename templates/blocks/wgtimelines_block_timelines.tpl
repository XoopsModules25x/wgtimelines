<table class='table table-<{$table_type|default:''}>'>
	<thead>
        <tr class='head'>
            <th class='center'><{$smarty.const._MB_WGTIMELINES_TL_NAME}></th>
        </tr>
	</thead>
    <{if $block > 0}>
	<tbody>
        <{foreach item=timeline from=$block}>
        <tr class="<{cycle values="odd, even"}>">
            <td class="center">
                <a href="<{$timeline.url}>/index.php?op=list&amp;tl_id=<{$timeline.id}>" title="<{$timeline.name}>"><{$timeline.name}></a>
            </td>
        </tr>
        <{/foreach}>
    </tbody>
    <{/if}>
    <tfoot><tr><td>&nbsp;</td></tr></tfoot>
</table>
