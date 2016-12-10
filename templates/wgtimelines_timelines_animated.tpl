<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_animated.css">
<script src="<{$wgtimelines_url}>/templates/js/modernizr.js"></script>
<style>
#cd-timeline::before {
	background-color: <{$linecolor}>;
}
.cd-timeline-badge {
    background-color:<{$badgecolor}>;
}
.cd-timeline-content {
    background-color:<{$bgcolor}>;
	color:<{$fontcolor}>
}
.timeline-year {
    color: <{$fontcolor}>;
}
</style>

<{if count($items) > 0}>
	<section id="cd-timeline" class="cd-container">
        <{foreach item=item from=$items}>
            <div class="cd-timeline-block">
                <div class="cd-timeline-badge">
                    <{if $item.badgecontent}>
                        <p class="timeline-year"><{$item.badgecontent}></p>
                    <{/if}>
                </div> <!-- cd-timeline-badge -->
                <div id="item<{$item.id}>" class="cd-timeline-content">
                    <{if $panel_imgpos == 'top' && $item.image}>
                        <div class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></div>
                    <{/if}>
                    <div class=''>
                        <{if $item.title}><h3><{$item.title}></h3><{/if}>
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class='timeline-item-readmore right'>
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
                    </div>
                    <{if $panel_imgpos == 'bottom' && $item.image}>
                        <div class=''><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></div>
                    <{/if}>
					<{if $showreads}>
						<div class='col-xs-12 col-sm-6 timeline-item-reads pull-left'>
							<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
						</div><br>
					<{/if}>	
					<{if $isAdmin}>
						<div class='col-xs-12 col-sm-6 admin-area pull-right'>
							<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
								<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
							</a>
							<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
								<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
							</a>
						</div><br>
					<{/if}>
                    <span class="cd-date"><{$item.date}></span>
                </div> <!-- cd-timeline-content -->
            </div> <!-- cd-timeline-block -->
        <{/foreach}>
	</section> <!-- cd-timeline -->
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated.js"></script> <!-- Resource jQuery -->
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>