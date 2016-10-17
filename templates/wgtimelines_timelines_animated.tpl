<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_animated.css">
<script src="<{$wgtimelines_url}>/templates/js/modernizr.js"></script>
<{if count($items) > 0}>
	<div class="page-header">
        <h2 id="timeline"><{$timeline_name}></h2>
    </div>

	<section id="cd-timeline" class="cd-container">
        <{foreach item=item from=$items}>
            <div class="cd-timeline-block">
                <div class="cd-timeline-img cd-picture">
                    <{if $item.year_display}>
                        <span class="timeline-year" style="background-color:<{$bgcolor}>;color:<{$fontcolor}>;"><{$item.year_display}></span>
                    <{/if}>
                </div> <!-- cd-timeline-img -->
                <div class="cd-timeline-content">
                    <h3><{$item.title}></h3>
                    <p><{$item.content}></p>
                    <span class="cd-date"><{$item.date}></span>
                </div> <!-- cd-timeline-content -->
            </div> <!-- cd-timeline-block -->
        <{/foreach}>
	</section> <!-- cd-timeline -->
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated.js"></script> <!-- Resource jQuery -->
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
