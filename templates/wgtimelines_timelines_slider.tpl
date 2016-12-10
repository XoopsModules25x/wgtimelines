<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_slider_<{$orientation}>.css">
<script src="<{$wgtimelines_url}>/templates/js/jquery.timelinr-0.9.6.js"></script>
<script>
    $(function(){
        $().timelinr({
            orientation: 	         '<{$orientation}>',
            issuesSpeed: 	         <{$issuesspeed}>,
            datesSpeed: 	         <{$datesspeed}>,
            issuesTransparency:      <{$issuestransparency}>,
			issuesTransparencySpeed: <{$issuestransparencyspeed}>,
			arrowKeys:               '<{$arrowkeys}>',
			startAt:                 <{$startat}>,
			autoPlay:                '<{$autoplay}>',
			autoPlayDirection:       '<{$autoplaydirection}>',
			autoPlayPause:           <{$autoplaypause}>
        })
    });
</script>

<style>
</style>
        
<{if count($items) > 0}>
	<div id="timeline">
		<ul id="dates">
            <{foreach name=dates item=item from=$items}>
			<li>
            <{if $item.date}>
                <a href="#<{$item.date}>" class="<{if $smarty.foreach.dates.first}>selected<{/if}>"><{$item.date}></a>
            <{else}>
                <a href="#<{$item.year}>" class="<{if $smarty.foreach.dates.first}>selected<{/if}>"><{$item.year}></a>
            <{/if}>
            </li>
            <{/foreach}>
		</ul>
        
		<ul id="issues">
			<{foreach name=items item=item from=$items}>
            <li id="<{$item.badgecontent}>" class="selected">
                <{if $orientation == 'horizontal'}>
                    <{if $item.image}>
                        <div class='slider-img-horizontal'>
                            <img class="img-responsive center <{$imgstyle}>" src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>" alt="<{$item.title}>" "/>
                        </div>
                        <div class=''>
                    <{else}>
                        <div id="item<{$item.id}>" class='slider-content'>
                    <{/if}>
                            <h2><{$item.title}></h2>
                            <p><{$item.content}></p>
							<{if $item.readmore}>
								<p class='timeline-item-readmore right'>
									<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
								</p>
							<{/if}>
                        </div>
                <{else}>
                    <{if $item.image}>
                    <div class='col-xs-12 col-sm-12'><img class="img-responsive center <{$imgstyle}>" src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>" alt="<{$item.title}>" "/></div>
                    <{/if}>
                    <div id="item<{$item.id}>" class='col-xs-12 col-sm-12'>
                        <h2><{$item.title}></h2>
                        <p><{$item.content}></p>
						<{if $item.readmore}>
							<p class='timeline-item-readmore right'>
								<a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
							</p>
						<{/if}>
                    </div>
                <{/if}>
				<{if $showreads}>
					<div class='col-xs-12 col-sm-6 timeline-item-reads pull-left'>
						<i class='glyphicon glyphicon-eye-open'> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
					</div><br>
				<{/if}>	
				<{if $isAdmin}>
					<div class='col-xs-12 col-sm-6 admin-area pull-right'>
						<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
							<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
						</a>
						<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
							<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
						</a>
					</div><br>
				<{/if}>
			</li>
            <{/foreach}>
		</ul>
		<div id="grad_top"></div>
		<div id="grad_bottom"></div>
		<a href="#" id="next">+</a>
		<a href="#" id="prev">-</a>
	</div>
    <div class="clear"></div>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>