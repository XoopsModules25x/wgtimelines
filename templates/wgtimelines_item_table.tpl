<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_table.css">

<{if count($items|default:null) > 0}>
<div class="table-responsive">
    <table class="table table-<{$table_type|default:''}>">
		<tbody>
            <{foreach item=item from=$items}>
                <{if $item.showyear|default:false}>
                    <tr class="tl-table-item-year">
                        <th colspan="2"><{$item.showyear}></th>
                    </tr>
                <{/if}>
                <tr id="item<{$item.id}>">
                    <{if $panel_pos|default:'' == 'right' || $item.alternate|default:0 == 1}>
                        <{if $item.image|default:false}>
                        <td class='col-sm-6'>
                        <{else}>
                        <td class='col-sm-12' colspan='2'>
                        <{/if}>
                            <{if $item.date|default:false || $item.title|default:false}>
                                <div class='col-sm-12 tl-table-item-header'>
                                    <span class='tl-table-item-date'><{$item.date}></span>
                                    <span class='tl-table-item-title'><{$item.title}></span>
									
									<{if $isAdmin|default:false}>
										<span class='pull-right'>
											<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
												<img src="<{xoModuleIcons16 edit.png}>" alt="items" /></a>
											<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
												<img src="<{xoModuleIcons16 delete.png}>" alt="items" /></a>
										</span>
									<{/if}>
                                </div>
                            <{/if}>
                            <div class='col-sm-12 tl-table-item-content'><{$item.content|default:false}></div>
							<{if $item.readmore|default:false}>
								<div class='col-sm-12 timeline-item-readmore right'>
									<a href="items.php?op=read&amp;item_id=<{$item.id}>&amp;tpltype=table" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
								</div>
							<{/if}>
                        </td>
                        <{if $item.image|default:false}>
                        <td class='col-sm-6'>
                            <span class='col-sm-12 right'><img class='img-responsive <{$imgstyle|default:''}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
							<{if $showreads|default:false}>
								<span class='timeline-item-reads pull-right'>
									<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
								</span>
							<{/if}>	
							<{if $rating|default:false}>
								<div class='timeline-item-rating pull-left'><{include file='db:wgtimelines_ratingbar.tpl'}></div>
							<{/if}>
                        </td>
                        <{/if}>
                    <{else}>
                        <{if $item.image|default:false}>
                        <td class='col-sm-6'>
                            <span class='col-sm-12 left'><img class='img-responsive <{$imgstyle|default:''}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        </td>
                        <td class='col-sm-6'>
                        <{else}>
                        <td class='col-sm-12' colspan='2'>
                        <{/if}>
                            <{if $item.date|default:false || $item.title|default:false}>
                                <div class='col-sm-12 tl-table-item-header'>
                                    <span class='tl-table-item-date'><{$item.date}></span>
                                    <span class='tl-table-item-title'><{$item.title}></span>
									<{if $isAdmin|default:false}>
										<span class='pull-right'>
											<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
												<img src="<{xoModuleIcons16 edit.png}>" alt="items" /></a>
											<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
												<img src="<{xoModuleIcons16 delete.png}>" alt="items" /></a>
										</span>
									<{/if}>
                                </div>
                            <{/if}>
                            <div class='col-sm-12 tl-table-item-content'><{$item.content|default:false}></div>
							<{if $item.readmore|default:false}>
								<div class='col-sm-12 timeline-item-readmore right'>
									<a href="items.php?op=read&amp;item_id=<{$item.id}>&amp;tpltype=table" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
								</div>
							<{/if}>
							<{if $showreads|default:false}>
								<span class='timeline-item-reads pull-right'>
									<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
								</span>
							<{/if}>	
							<{if $rating|default:false}>
								<div class='timeline-item-rating pull-left'><{include file='db:wgtimelines_ratingbar.tpl'}></div>
							<{/if}>
                        </td>
                    <{/if}>
                </tr>
				
            <{/foreach}>
		</tbody>
	</table>
</div>
<{/if}>
<{if $error|default:false}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>