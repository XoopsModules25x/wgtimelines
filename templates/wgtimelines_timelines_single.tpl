<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_single.css">
<style>
    .timeline:before {
        background-color: <{$linecolor}>;
    }
    .timeline > li > .timeline-panel {
        border-color: <{$bordercolor|default:'#fff'}>;
        border-radius: <{$borderradius}>;
        background-color: <{$bgcolor}>;
        -webkit-box-shadow: <{$boxshadow}>;
        box-shadow: <{$boxshadow}>;
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
        color: <{$badgefontcolor}>;
        background-color:<{$badgecolor}>;
    }
    .timeline-heading {
        color: <{$fontcolor}>;
    }
</style>

<{if count($items|default:null) > 0}>
    <div class="container-timeline">
        <ul class="timeline <{if $panel_pos_single|default:'' == 'right'}>timeline-inverted<{/if}>">
        <{foreach item=item from=$items|default:null}>
            <li id="item<{$item.id}>" class="<{if $panel_pos_single|default:'' == 'right'}>timeline-inverted<{/if}>">
                <div class="timeline-badge"><{if $item.badgecontent|default:false}><{$item.badgecontent|default:''}><{/if}></div>
                <div class="timeline-panel">
                    <div class="timeline-heading"> 
                        <h4 class="timeline-title">
                            <{$item.title}>
                            <{if $isAdmin|default:false}>
                                <span class="admin-area pull-right">
                                    <a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                                        <img src="<{xoModuleIcons16 'edit.png'}>" alt="items" />
                                    </a>
                                    <a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                                        <img src="<{xoModuleIcons16 'delete.png'}>" alt="items" />
                                    </a>
                                </span>
                            <{/if}>
                            <{if $showreads|default:false}>
                                <span class="timeline-item-reads pull-right">
                                    <i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
                                </span>
                            <{/if}>    
                        </h4>
                    </div>
                    <div class="timeline-body col-sm-12">
                        <{if $item.image|default:false}>
                            <div class="cols-xs-12 col-sm-6">
                                <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                                <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                                <{if $use_magnific|default:false}></a><{/if}>
                            </div>
                            <div class="cols-xs-12 col-sm-6">
                        <{elseif $panel_imgpos|default:'' == 'bottom' && $item.image}>
                            <div class="cols-xs-12 col-sm-6">
                        <{else}>
                            <div class="cols-xs-12 col-sm-12">
                        <{/if}>
                        <p><{$item.content|default:false}></p>
                        <{if $item.readmore|default:false}>
                            <div class="col-sm-12 timeline-item-readmore right">
                                <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                            </div>
                        <{/if}>
                        <{if $rating|default:false}>
                            <div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
                        <{/if}>
                        </div>
                    </div>
                    
                    <{if $item.date|default:false}>
                        <div class="cols-xs-12 col-sm-12 timeline-footer">
                            <p><{$item.date}></p>
                        </div>
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
