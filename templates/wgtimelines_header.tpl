<{if $breadcrumbs|default:false}>
    <{include file='db:wgtimelines_breadcrumbs.tpl'}>
<{/if}>
<{if $welcome|default:false}><h2 class="tl_welcome"><{$welcome}></h2><{/if}>
<{if $timeline_name|default:false}><h3 class="tl_name"><{$timeline_name}></h3><{/if}>
<{if $timeline_desc|default:false}><p class="tl_desc"><{$timeline_desc}></p><{/if}>