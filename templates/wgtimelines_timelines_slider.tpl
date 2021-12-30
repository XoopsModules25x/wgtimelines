<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_slider_<{$orientation}>.css">
<script src="<{$wgtimelines_url}>/templates/js/jquery.timelinr-0.9.6.js"></script>
<script>
    $(function(){
        $().timelinr({
            orientation:              '<{$orientation}>',
            issuesSpeed:              <{$issuesspeed}>,
            datesSpeed:              <{$datesspeed}>,
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
        
<{if count($items|default:null) > 0}>
    <div id="timeline">
        <ul id="dates">
            <{foreach name=dates item=item from=$items}>
            <li>
            <{if $item.date|default:false}>
                <a href="#<{$item.date}>" class="<{if $smarty.foreach.dates.first}>selected<{/if}>"><{$item.date}></a>
            <{else}>
                <a href="#<{$item.year}>" class="<{if $smarty.foreach.dates.first}>selected<{/if}>"><{$item.year}></a>
            <{/if}>
            </li>
            <{/foreach}>
        </ul>
        
        <ul id="issues">
            <{foreach name=items item=item from=$items}>
            <li id="<{$item.badgecontent|default:''}>" class="selected">
                <{if $orientation|default:'' == 'horizontal'}>
                    <{if $item.image|default:false}>
                        <div class="slider-img-horizontal">
                            <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific|default:false}></a><{/if}>
                        </div>
                        <div class="">
                    <{else}>
                        <div id="item<{$item.id}>" class="slider-content">
                    <{/if}>
                            <h2><{$item.title}></h2>
                            <p><{$item.content|default:false}></p>
                            <{if $item.readmore|default:false}>
                                <p class="timeline-item-readmore right">
                                    <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                                </p>
                            <{/if}>
                        </div>
                <{else}>
                    <{if $item.image|default:false}>
                    <div class="col-xs-12 col-sm-12">
                        <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                        <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                        <{if $use_magnific|default:false}></a><{/if}>
                    </div>
                    <{/if}>
                    <div id="item<{$item.id}>" class="col-xs-12 col-sm-12">
                        <h2><{$item.title}></h2>
                        <p><{$item.content|default:false}></p>
                        <{if $item.readmore|default:false}>
                            <p class="timeline-item-readmore right">
                                <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                            </p>
                        <{/if}>
                    </div>
                <{/if}>
                <{if $showreads|default:false}>
                    <div class="col-xs-12 col-sm-6 timeline-item-reads pull-left">
                        <i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
                    </div><br>
                <{/if}>    
                <{if $isAdmin|default:false}>
                    <div class="col-xs-12 col-sm-6 admin-area pull-right">
                        <a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                            <img src="<{xoModuleIcons16 edit.png}>" alt="items" />
                        </a>
                        <a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                            <img src="<{xoModuleIcons16 delete.png}>" alt="items" />
                        </a>
                    </div><br>
                <{/if}>
                <{if $rating|default:false}>
                    <div class="col-xs-12 col-sm-12 timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
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
<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>