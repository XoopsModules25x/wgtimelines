<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_single.css">
<style>
    .timeline:before {
        background-color: <{$linecolor}>;
    }
    .timeline > li > .timeline-panel {
        border-color: <{$bordercolor}>;
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
        <{if $timeline_name || $welcome}>
            <div class="page-header">
                <h2><{$welcome}></h2>
                <h3 id="timeline"><{$timeline_name}></h3>
            </div>
        <{/if}>
        <ul class="timeline <{if $panel_pos_single == 'right'}>timeline-inverted<{/if}>">
        <{foreach item=item from=$items}>
            <li class="<{if $panel_pos_single == 'right'}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{if $item.badgecontent}><{$item.badgecontent}><{/if}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading"> 
                        <h4 class="timeline-title"><{$item.title}></h4>
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
                </div>
            </li>
        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
