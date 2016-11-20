<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_facebook.css">
<style>
.timeline {
    background-color: <{$linecolor}>;
}
.timeline li.event:nth-child(odd)::after {
    background:<{$linecolor}>;
}
li.event:nth-child(even)::before{
	background:<{$linecolor}>;
}
.timeline li.year{
    background-color: <{$badgecolor}>;
    color:<{$badgefontcolor}>;
    border-color:<{$bordercolor}>;
}
.timeline li.event{
    background-color: <{$bgcolor}>;
    color: <{$fontcolor}>;
    border-radius: <{$borderradius}>;
	-moz-border-radius: <{$borderradius}>;
	-webkit-border-radius: <{$borderradius}>;
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
    -webkit-box-shadow: <{$boxshadow}>;
    box-shadow: <{$boxshadow}>;
}
</style>
<{if count($items) > 0}>
    <div class="container">
        <{if $timeline_name || $welcome}>
            <div class="page-header">
                <h2><{$welcome}></h2>
                <h3 id="timeline"><{$timeline_name}></h3>
            </div>
        <{/if}>
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <{if $item.badgecontent}>
                <li class="year"><{$item.year}></li>
            <{/if}>
            <li class="event">
                <{if $item.image}>
                    <{if $panel_imgpos == 'top' && $item.image}>
                        <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='items' /></span>
                    <{/if}>
                <{/if}>
                <{if $item.title}>
                    <h3 class="event-heading"><{$item.title}></h3>
                <{/if}>
                <{if $item.date}>
                    <span class="event-month"><{$item.date}></span>
                <{/if}>
                <p class="event-body"><{$item.content}></p>
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
