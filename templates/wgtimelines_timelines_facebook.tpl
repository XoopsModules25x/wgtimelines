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

        <ul class="timeline">
        <{foreach item=item from=$items}>
            <{if $item.badgecontent}>
                <li class="year"><{$item.year}></li>
            <{/if}>
            <li id="item<{$item.id}>" class="event">
                <{if $item.image}>
                    <{if $panel_imgpos == 'top' && $item.image}>
                        <span class="col-sm-12">
                            <{if $use_magnific}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific}></a><{/if}>
                        </span>
                    <{/if}>
                <{/if}>
                <{if $item.title}>
                    <h3 class="event-heading"><{$item.title}></h3>
                <{/if}>
                <{if $item.date}>
                    <span class="event-month"><{$item.date}></span>
                <{/if}>
                <p class="event-body"><{$item.content}></p>
				<{if $item.readmore}>
					<p class="timeline-item-readmore right">
						<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
					</p>
				<{/if}>
                <{if $panel_imgpos == 'bottom' && $item.image}>
                    <span class="col-sm-12">
                        <{if $use_magnific}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                        <img class="img-timeline img-timeline-<{$panel_imgpos}> img-responsive <{$imgstyle}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                        <{if $use_magnific}></a><{/if}>
                    </span>
                <{/if}>
				<{if $showreads}>
					<span class="col-xs-12 col-sm-6 timeline-item-reads pull-left">
						<i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
					</span>
				<{/if}>	
				<{if $rating}>
					<div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
				<{/if}>
				<{if $isAdmin}>
					<span class="col-xs-12 col-sm-6 admin-area pull-right">
						<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
							<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
						</a>
						<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
							<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
						</a>
					</span>
				<{/if}>
            </li>

        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>