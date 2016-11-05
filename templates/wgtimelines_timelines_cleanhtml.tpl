<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_cleanhtml.css">
<style>
.timeline:before {
	background-color: <{$bgcolor}>;
}
.timeline-header, .timeline li {
    background-color: <{$bgcolor}>;
    color: <{$fontcolor}>;
}
.timeline li:before {
    border-top: 1em solid <{$bgcolor}>;
}
@media screen and (min-width: 40em) {
  .timeline li:nth-child(odd):before {
    border-top: 1em solid <{$bgcolor}>;
  }
}
</style>
<{if count($items) > 0}>
    <div class="timeline">
        <h2 class="timeline-header"><{$timeline_name}></h2>
        <ul>
        <{foreach item=item from=$items}>
            <li>
                <{if $panel_imgpos == 'top' && $item.image}>
                    <span class='col-sm-12 cont-img-timeline'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                <{/if}>
                <{if $item.title}>
                    <h3 class="timeline-title"><{$item.title}></h3>
                <{/if}>
                <p class="timeline-content"><{$item.content}></p>
                <{if $item.date}>
                    <time><{$item.date}></time>
                <{/if}>
                <{if $panel_imgpos == 'bottom' && $item.image}>
                    <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                <{/if}>
            </li>
        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
