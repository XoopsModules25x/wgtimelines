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
    border-color:<{$bordercolor|default:'#fff'}>;
}
.timeline li.event{
    background-color: <{$bgcolor}>;
    color: <{$fontcolor}>;
    border-radius: <{$borderradius}>;
    -moz-border-radius: <{$borderradius}>;
    -webkit-border-radius: <{$borderradius}>;
    border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor|default:'#fff'}>;
    -webkit-box-shadow: <{$boxshadow}>;
    box-shadow: <{$boxshadow}>;
}
</style>

<{if count($items|default:null) > 0}>
    <div class="container">

        <ul class="timeline">
        <{foreach item=item from=$items}>
            <{if $item.badgecontent|default:false}>
                <li class="year"><{$item.year}></li>
            <{/if}>
            <li id="item<{$item.id}>" class="event">
                <{if $item.image|default:false}>
                    <{if $panel_imgpos|default:'' == 'top' && $item.image|default:false}>
                        <span class="col-sm-12">
                            <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                            <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                            <{if $use_magnific|default:false}></a><{/if}>
                        </span>
                    <{/if}>
                <{/if}>
                <{if $item.title|default:false}>
                    <h3 class="event-heading"><{$item.title}></h3>
                <{/if}>
                <{if $item.date|default:false}>
                    <span class="event-month"><{$item.date}></span>
                <{/if}>
                <p class="event-body"><{$item.content|default:false}></p>
                <{if $item.readmore|default:false}>
                    <p class="timeline-item-readmore right">
                        <a href="items.php?op=read&amp;item_id=<{$item.id}>" title="<{$smarty.const._MA_WGTIMELINES_READMORE}>"><{$smarty.const._MA_WGTIMELINES_READMORE}>...</a>
                    </p>
                <{/if}>
                <{if $panel_imgpos|default:'' == 'bottom' && $item.image|default:false}>
                    <span class="col-sm-12">
                        <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                        <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                        <{if $use_magnific|default:false}></a><{/if}>
                    </span>
                <{/if}>
                <{if $showreads|default:false}>
                    <span class="col-xs-12 col-sm-6 timeline-item-reads pull-left">
                        <i class="glyphicon glyphicon-eye-open"> <{$smarty.const._MA_WGTIMELINES_ITEM_READS}>: <{$item.reads}></i>
                    </span>
                <{/if}>    
                <{if $rating|default:false}>
                    <div class="timeline-item-rating pull-left"><{include file='db:wgtimelines_ratingbar.tpl'}></div>
                <{/if}>
                <{if $isAdmin|default:false}>
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
<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>