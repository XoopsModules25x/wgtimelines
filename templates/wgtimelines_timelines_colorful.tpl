<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_colorful.css">
<style>
.timeline:before {
    background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel {
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor|default:'#fff'}>;
    border-radius: <{$borderradius}>;
    background-color:<{$badgecolor}>;
}
.timeline > li > .timeline-panel span {
    background-color:#ffffff;
}
.timeline > li > .timeline-panel:before {
    border-left-color: <{$bordercolor|default:'#fff'}>;
    border-right-color: <{$bordercolor|default:'#fff'}>;
}
.timeline > li > .timeline-panel:after {
    border-left-color: <{$bordercolor|default:'#fff'}>;
    border-right-color: <{$bordercolor|default:'#fff'}>;
}
.timeline-title {
    color: <{$fontcolor}>;
}
.timeline > li > .timeline-badge {
    color: <{$fontcolor}>;
    background-color:<{$badgecolor}>;
}
.timeline-heading {
    color: <{$fontcolor}>;
}
</style>

<{if count($items|default:null) > 0}>
    <div class="container-timeline">
        <ul class="timeline">
        <{foreach item=item from=$items}>
            <li id="item<{$item.id}>" class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{$item.badgecontent|default:''}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading"> 
                        <h4 class="timeline-title"><{$item.title}></h4>
                    </div>
                    <div class="timeline-body">
                        <{if $panel_imgpos|default:'' == 'top' && $item.image|default:false}>
                            <span class="col-sm-12">
                                <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                                <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                                <{if $use_magnific|default:false}></a><{/if}>
                            </span>
                        <{/if}>
                        <span class="col-sm-12">
                        <p><{$item.content|default:false}></p>
                        <{if $item.readmore|default:false}>
                            <p class="timeline-item-readmore right">
                                <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                            </p>
                        <{/if}>
                        </span>
                        <{if $panel_imgpos|default:'' == 'bottom' && $item.image|default:false}>
                            <span class="col-sm-12">
                                <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                                <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                                <{if $use_magnific|default:false}></a><{/if}>
                            </span>
                        <{/if}>
                    </div>
                    <{if $rating|default:false}>
                        <span class="col-xs-12 col-sm-12 timeline-item-reads"><{include file='db:wgtimelines_ratingbar.tpl'}></span>
                    <{/if}>
                    <{if $showreads|default:false}>
                        <span class="col-xs-12 col-sm-6 timeline-item-reads timeline-footer-left">
                            <i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
                        </span>
                    <{/if}>    
                    
                    <{if $item.date|default:false}>
                        <span class="ol-xs-12 col-sm-6 timeline-footer-right">
                            <{$item.date}>
                        </span>
                    <{/if}>
                    <{if $isAdmin|default:false}>
                        <p class="admin-area right">
                            <a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                                <img src="<{xoModuleIcons16 'edit.png'}>" alt="items" />
                            </a>
                            <a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                                <img src="<{xoModuleIcons16 'delete.png'}>" alt="items" />
                            </a>
                        </p>
                    <{/if}>
                </div>
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