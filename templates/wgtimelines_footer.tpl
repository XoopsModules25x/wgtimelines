<{if $bookmarks|default:false != 0}>
<{include file="db:system_bookmarks.tpl"}>
<{/if}>

<{if $fbcomments|default:false != 0}>
<{include file="db:system_fbcomments.tpl"}>
<{/if}>

<{if $copyright|default:false}>
<div class="pull-left"><{$copyright}></div>
<{/if}>

<{if $pagenav|default:false != ''}>
    <div class="pull-right"><{$pagenav}></div>
<{/if}>
<br>
<{if !empty($xoops_isadmin)}>
   <div class="text-center bold"><a href="<{$admin|default:''}>"><{$smarty.const._CO_WGTIMELINES_ADMIN}></a></div><br>
<{/if}>

<{if $jsexpander|default:false}>
    <script>
        $(document).ready(function() {
            var opts = {
                slicePoint: <{$user_maxchar|default:100}>,
                    expandText:'<{$smarty.const._MA_WGTIMELINES_READMORE}>',
                        moreLinkClass:'btn btn-success btn-sm pull-right',
                        expandSpeed: 500,
                        userCollapseText:'<{$smarty.const._MA_WGTIMELINES_READLESS}>',
                            lessLinkClass:'btn btn-success btn-sm pull-right',
                            expandEffect: 'slideDown',
                            collapseEffect: 'slideUp',
                            collapseSpeed: 500,
                            };

                            $('div.expander').expander(opts);
                            });
    </script>
<{/if}>
