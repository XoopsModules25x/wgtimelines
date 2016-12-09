<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_simple.css">
<style>
.timeline::before {
	background-color: <{$linecolor}>;
}
.timeline-badge {
    background-color:<{$badgecolor}>;
}
.timeline-title {
    color:<{$fontcolor}>;
}
</style>

<{if $timeline_name || $welcome}>
	<div class="page-header  text-center">
		<h2><{$welcome}></h2>
		<h3><{$timeline_name}></h3>
	</div>
<{/if}>
<{if count($items) > 0}>
    <div class="container-timeline">
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li id="item<{$item.id}>" class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge">&nbsp;</div>
                <div class="timeline-panel">
                    <{if $panel_imgpos == 'bottom' && $item.date}>
                        <div class="timeline-footer">
                            <{$item.date}>
                        </div>
                    <{/if}>
                    <div class="timeline-heading"> 
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
                        <{if $item.title}>
                            <h4 class="timeline-title"><{$item.title}></h4>
                        <{/if}>
                    </div>
                    <div class="timeline-body">
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class='timeline-item-readmore right'>
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' />
                        <{/if}>
                    </div>
                    <{if $showreads}>
						<div class='col-xs-12 col-sm-6 timeline-footer timeline-item-reads left'>
							<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
						</div>
					<{/if}>
					<{if $panel_imgpos == 'top' && $item.date}>
                        <div class="col-xs-12 col-sm-6 timeline-footer right">
                            <{$item.date}>
                        </div>
                    <{/if}>
					<{if $isAdmin}>
						<div class="clear"><div>
						<div class='admin-area pull-right'>
							<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
								<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
							</a>
							<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
								<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
							</a>
						</div>
					<{/if}>
                </div>
            </li>
        <{/foreach}>
        <li class="clearfix" style="float: none;"></li>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>