<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_bigpicture.css">
<style>
.timeline::before {
    background-color: <{$linecolor}>;
}
.timeline > li > .timeline-panel {
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor|default:'#fff'}>;
    -webkit-box-shadow: <{$boxshadow}>;
    box-shadow: <{$boxshadow}>;
}
.timeline > li > .timeline-panel:before {
  border-left-color: <{$bordercolor|default:'#fff'}>;
  border-right-color: <{$bordercolor|default:'#fff'}>;
}
.timeline-badge-icon {
    color:<{$badgecolor}>;
}
.timeline-title {
    color:<{$fontcolor}>;
}
</style>

<{if count($items|default:null) > 0}>
    <div class="container-timeline">
        <ul class="timeline">
        <{foreach item=item from=$items|default:null}>
            <li id="item<{$item.id}>" class="<{if $item.inverted > 0}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><i class="glyphicon glyphicon-record timeline-badge-icon" title="<{$item.badgecontent|default:''}>" id=""></i></div>
                <div class="timeline-panel">
                    <{if $panel_imgpos == 'bottom' && $item.date}>
                        <div class="timeline-footer">
                            <{$item.date}>
                        </div>
                    <{/if}>
                    <div class="timeline-heading"> 
                        <{if $panel_imgpos|default:'' == 'top' && $item.image|default:false}>
                            <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific|default:false}></a><{/if}>
                        <{/if}>
                        <{if $item.title|default:false}>
                            <h4 class="timeline-title"><{$item.title}></h4>
                        <{/if}>
                    </div>
                    <div class="timeline-body">
                        <p><{$item.content|default:false}></p>
                        <{if $item.readmore|default:false}>
                            <p class="timeline-item-readmore right">
                                <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                            </p>
                        <{/if}>
                        <{if $panel_imgpos|default:'' == 'bottom' && $item.image|default:false}>
                            <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific|default:false}></a><{/if}>
                        <{/if}>
                    </div>
                    <{if $showreads|default:false}>
                        <div class="col-xs-12 col-sm-6 timeline-item-reads pull-left timeline-footer">
                            <i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
                        </div>
                    <{/if}>    
                    <{if $panel_imgpos|default:'' == 'top' && $item.date|default:false}>
                        <div class="col-xs-12 col-sm-6 pull-right timeline-footer timeline-date">
                            <{$item.date}>
                        </div>
                    <{/if}>
                    <{if $rating|default:false}>
                        <div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
                    <{/if}>
                    <{if $isAdmin|default:false}>
                        <div class="col-xs-12 col-sm-12 admin-area pull-right">
                            <a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                                <img src="<{xoModuleIcons16 'edit.png'}>" alt="items" />
                            </a>
                            <a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                                <img src="<{xoModuleIcons16 'delete.png'}>" alt="items" />
                            </a>
                        </div>
                    <{/if}>
                </div>
            </li>
        <{/foreach}>
        <li class="clearfix" style="float: none;"></li>
        </ul>
    </div>
    <div class="clear"></div>
<{/if}>
<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
