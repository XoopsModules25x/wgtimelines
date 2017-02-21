<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_bigpicture.css">
<style>
.timeline::before {
	background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel {
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
    -webkit-box-shadow: <{$boxshadow}>;
    box-shadow: <{$boxshadow}>;
}
.timeline > li > .timeline-panel:before {
  border-left-color: <{$bordercolor}>;
  border-right-color: <{$bordercolor}>;
}
.timeline-badge-icon {
    color:<{$badgecolor}>;
}
.timeline-title {
    color:<{$fontcolor}>;
}
</style>

<{if count($items) > 0}>
    <div class="container-timeline">
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li id="item<{$item.id}>" class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><i class="glyphicon glyphicon-record timeline-badge-icon" title="<{$item.badgecontent}>" id=""></i></div>
                <div class="timeline-panel">
                    <{if $panel_imgpos == 'bottom' && $item.date}>
                        <div class="timeline-footer">
                            <{$item.date}>
                        </div>
                    <{/if}>
                    <div class="timeline-heading"> 
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <{if $use_magnific}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific}></a><{/if}>
                        <{/if}>
                        <{if $item.title}>
                            <h4 class="timeline-title"><{$item.title}></h4>
                        <{/if}>
                    </div>
                    <div class="timeline-body">
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class="timeline-item-readmore right">
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <{if $use_magnific}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific}></a><{/if}>
                        <{/if}>
                    </div>
					<{if $showreads}>
						<div class="col-xs-12 col-sm-6 timeline-item-reads pull-left timeline-footer">
							<i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
						</div>
					<{/if}>	
                    <{if $panel_imgpos == 'top' && $item.date}>
                        <div class="col-xs-12 col-sm-6 pull-right timeline-footer timeline-date">
                            <{$item.date}>
                        </div>
                    <{/if}>
					<{if $rating}>
						<div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
					<{/if}>
					<{if $isAdmin}>
						<div class="col-xs-12 col-sm-12 admin-area pull-right">
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