<{include file='db:wgtimelines_header.tpl'}>
<link rel="stylesheet" href="<{$wgtimelines_url}>/templates/css/timelines_animated_2.css">

<style>
.timeline ul li {
  background-color: <{$linecolor}>;
}
.timeline ul li div {
  background: <{$bgcolor}>;
  color: <{$fontcolor}>;
  border: <{$borderwidth}> <{$borderstyle}> <{$bordercolor|default:'#fff'}>;
  border-radius: <{$borderradius}>;
  -webkit-box-shadow: <{$boxshadow}>;
  box-shadow: <{$boxshadow}>;
}
.timeline ul li:nth-child(odd) div::before {
  border-color: transparent <{$bordercolor|default:'#fff'}> transparent transparent;
}
.timeline ul li:nth-child(even) div::before {
  border-color: transparent transparent transparent <{$bordercolor|default:'#fff'}>;
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

<{if count($items|default:null) > 0}>
    <section class="timeline">
        <ul>
            <{foreach name=items_loop item=item from=$items}>
                <li id="item<{$item.id}>" <{if ($smarty.foreach.items_loop.iteration == 1)}>class="in-view "<{/if}>>
                    <div>
                        <{if $panel_imgpos|default:'' == 'top' && $item.image|default:false}>
                            <span class="col-sm-12">
                                <{if $use_magnific|default:false}><a class="image-popup-no-margins" href="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"><{/if}>
                                <img class="img-timeline img-timeline-<{$panel_imgpos|default:''}> img-responsive <{$imgstyle|default:''}> " src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>"  alt="<{$item.title}>" />
                                <{if $use_magnific|default:false}></a><{/if}>
                            </span>
                        <{/if}>
                        <{if $item.title|default:false}><h3><{$item.title}></h3><{/if}>
                        <time><{$item.date}></time>
                        <p><{$item.content|default:false}></p>
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
                            </span><br>
                        <{/if}>    
                        <{if $isAdmin|default:false}>
                            <span class="col-xs-12 col-sm-6 admin-area pull-right">
                                <a href="admin/items.php?op=edit&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                                    <img src="<{xoModuleIcons16 'edit.png'}>" alt="items" />
                                </a>
                                <a href="admin/items.php?op=delete&amp;ui=user&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                                    <img src="<{xoModuleIcons16 'delete.png'}>" alt="items" />
                                </a>
                            </span><br>
                        <{/if}>
                        <{if $rating|default:false}>
                            <!-- wgtimelines_ratingbar.tpl can't be used, divs destroy layout for this template -->
                            <small>
                                <{if $item.rating.voted|default:false == 0}>
                                    <span class="timelines_ratingblock col-xs-12 col-sm-12 rating-left">
                                        <span id="unit_long<{$item.id}>" class="col-xs-12 col-sm-12 rating-left">
                                            <span id="unit_ul<{$item.id}>" class="timelines_unit-rating col-xs-12 col-sm-12 rating-left">
                                                <span class="wgtimelines_current-rating col-xs-12 col-sm-12" style="width:<{$item.rating.size}>;"></span>
                                                <span>
                                                    <a class="timelines_r1-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=1&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING1}>" rel="nofollow">1</a>
                                                </span>
                                                <span>
                                                    <a class="timelines_r2-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=2&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING2}>" rel="nofollow">2</a>
                                                </span>
                                                <span>
                                                    <a class="timelines_r3-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=3&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING3}>" rel="nofollow">3</a>
                                                </span>
                                                <span>
                                                    <a class="timelines_r4-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=4&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING4}>" rel="nofollow">4</a>
                                                </span>
                                                <span>
                                                    <a class="timelines_r5-unit rater" href="rate.php?op=<{$save}>&item_id=<{$item.id}>&rating=5&tl_id=<{$item.tl_id}>" title="<{$smarty.const._MA_WGTIMELINES_RATING5}>" rel="nofollow">5</a>
                                                </span>
                                            </span>
                                            <span class="col-xs-12 col-sm-12 rating-left">
                                                <{$item.rating.text}>
                                            </span>
                                        </span>
                                    </span>
                                <{else}>
                                    <span class="timelines_ratingblock col-xs-12 col-sm-12 rating-left">
                                        <span id="unit_long<{$item.id}> col-xs-12 col-sm-12 rating-left">
                                            <span id="unit_ul<{$item.id}>" class="timelines_unit-rating col-xs-12 col-sm-12 rating-left" style="width:<{$item.rating.maxsize}>;">
                                                <span class="wgtimelines_current-rating" style="width:<{$item.rating.size}>;"><{$item.rating.text}></span>
                                            </span>
                                            <span class="wgtimelines_voted col-xs-12 col-sm-12 rating-left">
                                                <{$item.rating.text}>
                                            </span>
                                        </span>
                                    </span>
                                <{/if}>
                            </small><br><br><br>
                        <{/if}>    
                    </div>
                </li>
            <{/foreach}>
        </ul>
    </section>
<script src="<{$wgtimelines_url}>/templates/js/timelines_animated_2.js"></script> <!-- Resource jQuery -->
<{/if}>
<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>