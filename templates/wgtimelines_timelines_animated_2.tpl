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

<{if $timeline_name || $welcome}>
	<div class="page-header">
		<h2><{$welcome}></h2>
		<h3><{$timeline_name}></h3>
	</div>
<{/if}>
<{if count($items) > 0}>
	<section class="timeline">
        <ul>
            <{foreach name=items_loop item=item from=$items}>
                <li id="item<{$item.id}>" <{if ($smarty.foreach.items_loop.iteration == 1)}>class="in-view "<{/if}>>
                    <div>
                        <{if $panel_imgpos == 'top' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></span>
                        <{/if}>
                        <{if $item.title}><h3><{$item.title}></h3><{/if}>
                        <time><{$item.date}></time>
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class='timeline-item-readmore right'>
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
                        <{if $panel_imgpos == 'bottom' && $item.image}>
                            <span class='col-sm-12'><img class='img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}>' src='<{$wgtimelines_upload_url}>/images/items/<{$item.image}>' alt='<{$item.image}>' /></span>
                        <{/if}>
						<{if $showreads}>
							<span class='col-xs-12 col-sm-6 timeline-item-reads pull-left'>
								<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
							</span><br>
						<{/if}>	
						<{if $isAdmin}>
							<span class='col-xs-12 col-sm-6 admin-area pull-right'>
								<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
									<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
								</a>
								<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
									<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
								</a>
							</span><br>
						<{/if}>
                    </div>
                </li>
            <{/foreach}>
        </ul>
    </section>
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated_2.js"></script> <!-- Resource jQuery -->
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>