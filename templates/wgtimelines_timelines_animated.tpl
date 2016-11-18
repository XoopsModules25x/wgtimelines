<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_animated.css">
<script src="<{$wgtimelines_url}>/templates/js/modernizr.js"></script>
<style>
#cd-timeline::before {
	background-color: <{$bgcolor}>;
}
.cd-timeline-badge {
    background-color:<{$badgecolor}>;
}
.timeline-year {
    color: <{$fontcolor}>;
}
</style>

<{if count($items) > 0}>
    <{if $timeline_name || $welcome}>
        <div class="page-header">
            <h2><{$welcome}></h2>
            <h3 id="timeline"><{$timeline_name}></h3>
        </div>
    <{/if}>
	<section id="cd-timeline" class="cd-container">
        <{foreach item=item from=$items}>
            <div class="cd-timeline-block">
                <div class="cd-timeline-badge">
                    <{if $item.year_display}>
                        <p class="timeline-year"><{$item.year_display}></p>
                    <{/if}>
                </div> <!-- cd-timeline-badge -->
                <div class="cd-timeline-content">
                    <{if $panel_imgpos == 'top' && $item.image}>
                        <div class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></div>
                    <{/if}>
                    <div class=''>
                        <{if $item.title}><h3><{$item.title}></h3><{/if}>
                        <p><{$item.content}></p>
                    </div>
                    <{if $panel_imgpos == 'bottom' && $item.image}>
                        <div class=''><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></div>
                    <{/if}>
                    <span class="cd-date"><{$item.date}></span>
                </div> <!-- cd-timeline-content -->
            </div> <!-- cd-timeline-block -->
        <{/foreach}>
	</section> <!-- cd-timeline -->
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated.js"></script> <!-- Resource jQuery -->
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
