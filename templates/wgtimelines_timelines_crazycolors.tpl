<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_crazycolors.css">
<style>
.timeline:before {
	background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel-1,
.timeline > li > .timeline-panel-2,
.timeline > li > .timeline-panel-3,
.timeline > li > .timeline-panel-4 {
    border-radius: <{$borderradius}>;
    -webkit-box-shadow: <{$boxshadow}>;
    box-shadow: <{$boxshadow}>;
}
.timeline > li > .timeline-panel-1 {
  background-color: <{$bgcolor}>;
}
.timeline > li > .timeline-panel-2 {
  background-color: <{$bgcolor2}>;
}
.timeline > li > .timeline-panel-3 {
  background-color: <{$bgcolor3}>;
}
.timeline > li > .timeline-panel-4 {
  background-color: <{$bgcolor4}>;
}
.timeline > li > .timeline-panel-1:before,
.timeline > li > .timeline-panel-2:before,
.timeline > li > .timeline-panel-3:before,
.timeline > li > .timeline-panel-4:before {
    border-left-color: <{$bordercolor}>;
    border-right-color: <{$bordercolor}>;
}
.timeline > li > .timeline-panel-1:after {
    border-left-color: <{$bgcolor}>;
    border-right-color: <{$bgcolor}>;
}
.timeline > li > .timeline-panel-2:after {
    border-left-color: <{$bgcolor2}>;
    border-right-color: <{$bgcolor2}>;
}
.timeline > li > .timeline-panel-3:after {
    border-left-color: <{$bgcolor3}>;
    border-right-color: <{$bgcolor3}>;
}
.timeline > li > .timeline-panel-4:after {
    border-left-color: <{$bgcolor4}>;
    border-right-color: <{$bgcolor4}>;
}
.timeline > li > .timeline-panel-1 {
    color: <{$fontcolor}>;
}
.timeline > li > .timeline-panel-2 {
    color: <{$fontcolor2}>;
}
.timeline > li > .timeline-panel-3 {
    color: <{$fontcolor3}>;
}
.timeline > li > .timeline-panel-4 {
    color: <{$fontcolor4}>;
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
</style>
<{if count($items) > 0}>
    <div class="container-timeline">
        <{if $timeline_name || $welcome}>
            <div class="page-header">
                <h2><{$welcome}></h2>
                <h3 id="timeline"><{$timeline_name}></h3>
            </div>
        <{/if}>
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{$item.year}></div>
                <div class="timeline-panel-<{$item.crazycolors}>">
                    <div class="timeline-heading">
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                        <{/if}>
                        <h4 class="timeline-title"><{$item.title}></h4>
                        <p><small class="timeline-date"><{$item.date}></small></p>
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
