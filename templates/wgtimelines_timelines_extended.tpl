<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_extended.css">
<style>
    .timeline:before {
        background-color: <{$linecolor}>;
    }
    <{if $badgestyle == 'full'}>
        .timeline .timeline-item .timeline-badge {
          color: <{$badgefontcolor}>;
          background-color: <{$badgecolor}>;
        }
    <{else}>
        .timeline .timeline-item .timeline-badge {
            color: <{$badgefontcolor}>;
            background-color:#ffffff;
            border: 3px solid <{$badgecolor}>;
        }
    <{/if}>
    .timeline .timeline-item .timeline-panel {
        border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
        border-radius: <{$borderradius}>;
        background: <{$borderradius}>;
        -webkit-box-shadow: <{$boxshadow}>;
        box-shadow: <{$boxshadow}>;
        background-color: <{$bgcolor}>;
    }
    .timeline-title {
        color: <{$fontcolor}>;
    }
    .timeline .timeline-item .timeline-panel:before {
        border-left-color: <{$bordercolor}>;
        border-right-color: <{$bordercolor}>;
    }
    .timeline-horizontal .timeline-item .timeline-panel:before {
        border-right: 16px solid transparent !important;
        border-top: 16px solid <{$bordercolor}> !important;
        border-bottom: 0 solid <{$bordercolor}> !important;
        border-left: 16px solid transparent !important;
    }
</style>

<{if count($items) > 0}>
    <div class="container-timeline">
        <div style="display:inline-block;width:100%;overflow-y:auto;">
            <ul class="timeline timeline-<{$orientation}>"> 
            <{foreach item=item from=$items}>
                <li id="item<{$item.id}>" class="timeline-item">
                    <div class="timeline-badge"><{$item.badgecontent}></div>
                    <div class="timeline-panel">
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <div class='col-sm-12 img-cont'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></div>
                        <{/if}>
                        <div class="timeline-heading">
                            <{if $item.title}>
                                <h4 class="timeline-title"><{$item.title}></h4>
                            <{/if}>
                            <{if $item.date}>
                                <p><small class="timeline-date"><{$item.date}></small></p>
                            <{/if}>
                        </div>
                        <div class="timeline-body">
                            <p><{$item.content}></p>
							<{if $item.readmore}>
								<p class='timeline-item-readmore right'>
									<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
								</p>
							<{/if}>
                        </div>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <div class='col-sm-12 img-cont'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></div>
                        <{/if}>
						<{if $showreads}>
							<div class='col-xs-12 col-sm-6 timeline-item-reads pull-left'>
								<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
							</div>
						<{/if}>	
						<{if $rating}>
							<div class='timeline-item-rating pull-left'><{include file='db:wgtimelines_ratingbar.tpl'}></div>
						<{/if}>
						<{if $isAdmin}>
							<div class='col-xs-12 col-sm-6 admin-area pull-right'>
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
            </ul>
        </div>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>