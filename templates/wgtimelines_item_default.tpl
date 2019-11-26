<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/item_default.css">
<style>
    .timeline:before {
        background-color: <{$linecolor}>;
    }
    .timeline > li > .timeline-panel {
        border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
        border-radius: <{$borderradius}>;
        background-color: <{$bgcolor}>;
        -webkit-box-shadow: <{$boxshadow}>;
        box-shadow: <{$boxshadow}>;
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
        color: <{$badgefontcolor}>;
        background-color:<{$badgecolor}>;
    }
    .timeline-heading {
        color: <{$fontcolor}>;
    }
</style>

<{if count($items) > 0}>
    <div class="container-timeline">
        <ul class="timeline <{if $panel_pos_single == 'right'}>timeline-inverted<{/if}>">
        <{foreach item=item from=$items}>
            <li class="<{if $panel_pos_single == 'right'}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{if $item.badgecontent}><{$item.badgecontent}><{/if}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading"> 
                        <h4 class="timeline-title">
							<{$item.title}>						
							<{if $isAdmin}>
								<span class='admin-area pull-right'>
									<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
										<img src="<{xoModuleIcons16 edit.png}>" alt="items" /></a>
									<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
										<img src="<{xoModuleIcons16 delete.png}>" alt="items" /></a>
								</span>
							<{/if}>
							<{if $showreads}>
								<span class='timeline-item-reads pull-right'>
									<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
								</span>
							<{/if}>	
						</h4>
                    </div>
                    <div class="timeline-body col-sm-12">
                        <{if $item.image}>
                            <div class='cols-xs-12 col-sm-6'>
                                <img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' />
                            </div>
                            <div class='cols-xs-12 col-sm-6'>
                        <{elseif $panel_imgpos == 'bottom' && $item.image}>
                            <div class='cols-xs-12 col-sm-6'>
                        <{else}>
                            <div class='cols-xs-12 col-sm-12'>
                        <{/if}>
                        <p><{$item.content}></p>
                        </div>
						
                    </div>
                    <{if $item.date}>
                        <div class="cols-xs-12 col-sm-12 timeline-footer">
                            <p><{$item.date}></p>
                        </div>
                    <{/if}>
					<{if $rating}>
						<div class='timeline-item-rating pull-left'><{include file='db:wgtimelines_ratingbar.tpl'}></div>
					<{/if}>	
                </div>
				<div class="timeline-back col-sm-12 right">
					<a href="index.php?op=list&amp;tl_id=<{$item.tl_id}>#item<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_GOBACK}>"><img src="<{$wgtimelines_icons_url}>/32/back.png" alt="<{$smarty.const._MA_WGTIMELINES_GOBACK}>" /></a>
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