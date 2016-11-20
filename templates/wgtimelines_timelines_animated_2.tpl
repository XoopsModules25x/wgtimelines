<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_animated_2.css">

<style>
.timeline ul li {
  background-color: <{$linecolor}>;
}
.timeline ul li div {
  background: <{$bgcolor}>;
  color: <{$fontcolor}>;
  border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor}>;
  border-radius: <{$borderradius}>;
  -webkit-box-shadow: <{$boxshadow}>;
  box-shadow: <{$boxshadow}>;
}
.timeline ul li:nth-child(odd) div::before {
  border-color: transparent <{$bordercolor}> transparent transparent;
}
.timeline ul li:nth-child(even) div::before {
  border-color: transparent transparent transparent <{$bordercolor}>;
}
.timeline ul li.in-view::after {
  background: <{$badgecolor}>;
}
@media screen and (max-width: 600px) {
  .timeline ul li:nth-child(even) div::before {
    border-color: transparent #F45B69 transparent transparent;
  }
}
<{if $fadein == 'appear'}>
.timeline ul li:nth-child(odd) div {
  transform: none;
}
.timeline ul li:nth-child(even) div {
  transform: none;
}
<{/if}>
</style>

<{if count($items) > 0}>
    <{if $timeline_name || $welcome}>
        <div class="page-header">
            <h2><{$welcome}></h2>
            <h3 id="timeline"><{$timeline_name}></h3>
        </div>
    <{/if}>
	<section class="timeline">
        <ul>
            <{foreach name=items_loop item=item from=$items}>
                <li <{if ($smarty.foreach.items_loop.iteration == 1)}>class="in-view "<{/if}>>
                    <div>
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></span>
                        <{/if}>
                        <{if $item.title}><h3><{$item.title}></h3><{/if}>
                        <time><{$item.date}></time>
                        <p><{$item.content}></p>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></span>
                        <{/if}>
                    </div>
                </li>
            <{/foreach}>
        </ul>
    </section>
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated_2.js"></script> <!-- Resource jQuery -->
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
