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

<{if count($items|default:null) > 0}>
    <div class="timeline">
        <ul>
        <{foreach item=item from=$items}>
            <li id="item<{$item.id}>">
                <{if $panel_imgpos|default:'' == 'top' && $item.image|default:false}>
                    <span class="col-sm-12 cont-img-timeline">
                        <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                        <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                        <{if $use_magnific|default:false}></a><{/if}>
                    </span>
                <{/if}>
                <{if $item.title|default:false}>
                    <h3 class="timeline-title"><{$item.title}></h3>
                <{/if}>
                <p class="timeline-content"><{$item.content|default:false}></p>
                <{if $item.date|default:false}>
                    <time><{$item.date}></time>
                <{/if}>
                <{if $panel_imgpos|default:'' == 'bottom' && $item.image|default:false}>
                    <span class="col-sm-12 cont-img-timeline">
                        <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                        <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                        <{if $use_magnific|default:false}></a><{/if}>
                    </span>
                <{/if}>
				<{if $item.readmore|default:false}>
					<div class="col-sm-12 timeline-item-readmore right">
						<a href="items.php?op=read&amp;item_id=<{$item.id}>&amp;tpltype=table" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
					</div>
				<{/if}>
				<{if $isAdmin|default:false}>
					<div class="pull-right">
						<a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
							<img src="<{xoModuleIcons16 edit.png}>" alt="items" />
						</a>
						<a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
							<img src="<{xoModuleIcons16 delete.png}>" alt="items" />
						</a>
					</div>
				<{/if}>
				<{if $showreads|default:false}>
					<div class="timeline-item-reads pull-left">
						<i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
					</div>
				<{/if}>
				<{if $rating|default:false}>
					<div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
				<{/if}>				
            </li>
        <{/foreach}>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error|default:false}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>