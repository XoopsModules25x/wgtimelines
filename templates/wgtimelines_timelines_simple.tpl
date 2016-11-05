<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_simple.css">
<style>
.timeline:before {
	background-color: <{$bgcolor}>;
}
.timeline-badge {
	background-color: <{$badgecolor}>;
}
.timeline-heading h4 {
	color: <{$fontcolor}>;
}
</style>
<{if count($items) > 0}>
    <div class="container-timeline">
        <div class="page-header">
            <h2 id="timeline"><{$timeline_name}></h2>
        </div>
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"></div>
                <div class="timeline-panel">
                    <{if $item.title || $item.image}>
                        <div class="timeline-heading">
                            <{if $panel_imgpos == 'top' && $item.image}>
                                <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                            <{/if}>
                            <{if $item.title}>
                                <h4 class="timeline-title"><{$item.title}></h4>
                            <{/if}>
                        </div>
                    <{/if}>
                    <div class="timeline-body">
                        <p><{$item.content}></p>
                        <{if $item.date}>
                            <div class="timeline-footer">
                                <p class="text-right"><{$item.date}></p>
                            </div>
                        <{/if}>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
                    </div>
                </div>
            </li>
        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
