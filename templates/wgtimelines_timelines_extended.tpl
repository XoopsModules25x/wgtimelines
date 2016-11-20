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
        <{if $timeline_name || $welcome}>
            <div class="page-header">
                <h2><{$welcome}></h2>
                <h3 id="timeline"><{$timeline_name}></h3>
            </div>
        <{/if}>
        <div style="display:inline-block;width:100%;overflow-y:auto;">
            <ul class="timeline timeline-<{$orientation}>"> 
            <{foreach item=item from=$items}>
                <li class="timeline-item">
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
                        </div>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <div class='col-sm-12 img-cont'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></div>
                        <{/if}>
                    </div>
                </li>
            <{/foreach}>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
