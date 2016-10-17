<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_table.css">
<{if count($items) > 0}>
<div class="table-responsive">
    <h2><{$timeline_name}></h2>
    <table class="table table-<{$table_type}>">
		<tbody>  
            <{foreach item=item from=$items}>
                <{if $item.year_display}>
                    <tr class="tl-table-item-year">
                        <th colspan="2"><{$item.year_display}></th>
                    </tr>
                <{/if}>
                <tr>
                    <{if $imgposition=='right' || $item.alternate == 1}>
                        <{if $item.image}>
                        <td class='col-sm-6'>
                        <{else}>
                        <td class='col-sm-12' colspan='2'>
                        <{/if}>
                            <{if $item.date || $item.title}>
                                <div class='col-sm-12 tl-table-item-header'>
                                    <span class='tl-table-item-date'><{$item.date}></span>
                                    <span class='tl-table-item-title'><{$item.title}></span>
                                </div>
                            <{/if}>
                            <div class='col-sm-12 tl-table-item-content'><{$item.content}></div>
                        </td>
                        <{if $item.image}>
                        <td class='col-sm-6'>
                            <span class='col-sm-12 right'><img class='img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        </td>
                        <{/if}>
                    <{else}>
                        <{if $item.image}>
                        <td class='col-sm-6'>
                            <span class='col-sm-12 left'><img class='img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        </td>
                        <td class='col-sm-6'>
                        <{else}>
                        <td class='col-sm-12' colspan='2'>
                        <{/if}>
                            <{if $item.date || $item.title}>
                                <div class='col-sm-12 tl-table-item-header'>
                                    <span class='tl-table-item-date'><{$item.date}></span>
                                    <span class='tl-table-item-title'><{$item.title}></span>
                                </div>
                            <{/if}>
                            <div class='col-sm-12 tl-table-item-content'><{$item.content}></div>
                        </td>
                    <{/if}>
                </tr>
            <{/foreach}>
		</tbody>
	</table>
</div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
