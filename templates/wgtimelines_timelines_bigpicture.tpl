<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_bigpicture.css">
<style>
.timeline::before {
	background-color: <{$bgcolor}>;
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
        <div class="page-header text-center">
            <h2 id="timeline"><{$timeline_name}></h2>
        </div>
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><i class="glyphicon glyphicon-record timeline-badge-icon" title="<{$item.year_display}>" id=""></i></div>
                <div class="timeline-panel">
                    <{if $panel_imgpos == 'bottom' && $item.date}>
                        <div class="timeline-footer">
                            <{$item.date}>
                        </div>
                    <{/if}>
                    <div class="timeline-heading"> 
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' />
                        <{else}>
                        <{/if}>
                        <h4 class="timeline-title"><{$item.title}></h4>
                    </div>
                    <div class="timeline-body">
                        <p><{$item.content}></p>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' />
                        <{/if}>
                    </div>
                    <{if $panel_imgpos == 'top' && $item.date}>
                        <div class="timeline-footer">
                            <{$item.date}>
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
<{include file='db:wgtimelines_footer.tpl'}>
