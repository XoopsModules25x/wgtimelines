<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_colorful.css">
<style>
.timeline:before {
	background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel {
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
    border-radius: <{$borderradius}>;
    background-color:<{$badgecolor}>;
}
.timeline > li > .timeline-panel span {
    background-color:#ffffff;
}
.timeline > li > .timeline-panel:before {
    border-left-color: <{$bordercolor}>;
    border-right-color: <{$bordercolor}>;
}
.timeline > li > .timeline-panel:after {
    border-left-color: <{$bordercolor}>;
    border-right-color: <{$bordercolor}>;
}
.timeline-title {
    color: <{$fontcolor}>;
}
.timeline > li > .timeline-badge {
    color: <{$fontcolor}>;
    background-color:<{$badgecolor}>;
}
.timeline-heading {
    color: <{$fontcolor}>;
}
</style>

<{if count($items) > 0}>
    <div class="container-timeline">
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li id="item<{$item.id}>" class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{$item.badgecontent}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading"> 
                        <h4 class="timeline-title"><{$item.title}></h4>
                    </div>
                    <div class="timeline-body">
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
						<span class='col-sm-12'>
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class='timeline-item-readmore right'>
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
						</span>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
                    </div>
					<{if $rating}>
						<span class='col-xs-12 col-sm-12 timeline-item-reads'><{include file='db:wgtimelines_ratingbar.tpl'}></span>
					<{/if}>
                    <{if $showreads}>
						<span class='col-xs-12 col-sm-6 timeline-item-reads timeline-footer-left'>
							<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
						</span>
					<{/if}>	
					
					<{if $item.date}>
                        <span class="ol-xs-12 col-sm-6 timeline-footer-right">
                            <{$item.date}>
                        </span>
                    <{/if}>
					<{if $isAdmin}>
						<p class='admin-area right'>
							<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
								<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
							</a>
							<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
								<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
							</a>
						</p>
					<{/if}>
                </div>
            </li>
        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>