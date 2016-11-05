<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_extended.css">
<style>
.timeline:before {
	background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel {
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
    border-radius: <{$borderradius}>;
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
<{if $badgestyle == 'full'}>
    .timeline > li > .timeline-badge {
        color: <{$badgefontcolor}>;
        background-color:<{$badgecolor}>;
    }
<{else}>
    .timeline > li > .timeline-badge {
        color: <{$badgefontcolor}>;
        background-color:#ffffff;
        border: 3px solid <{$badgecolor}>;
    }
<{/if}>
.timeline > li > .timeline-panel {
  -webkit-box-shadow: <{$boxshadow}>;
  box-shadow: <{$boxshadow}>;
  background-color: <{$bgcolor}>;
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
                <div class="timeline-badge"><{$item.year}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
                        <h4 class="timeline-title"><{$item.title}></h4>
                        <p><small class="text-muted"><{$item.date}></small></p>
                    </div>
                    <div class="timeline-body">
                        <p><{$item.content}></p>
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
