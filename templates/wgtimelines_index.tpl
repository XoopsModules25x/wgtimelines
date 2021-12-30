<{include file='db:wgtimelines_header.tpl'}>

<{foreach item=timeline from=$timelines|default:false}>
    <div class="col-xs-12 cols-sm-12 timeline-list">
        <{if $timeline.image|default:false}>
            <div class='col-sm-4'><img src="<{$wgtimelines_upload_url}>/images/timelines/<{$timeline.image}>" class="img-responsive" alt="<{$timeline.name}>" /></div>
            <div class='col-sm-8'>
        <{else}>
            <div class="col-xs-12 cols-sm-12">
        <{/if}>
        <p class="timeline-list-link"><a href="<{$wgtimelines_url}>/index.php?op=list&amp;tl_id=<{$timeline.id}>" title="<{$timeline.name}>"><{$timeline.name}></a></p>
        <{if $timeline.timeline_desc|default:false}><p><{$timeline.timeline_desc}></p><{/if}>
        </div>
    </div>
<{/foreach}>
<{if $error|default:false}>
    <h3><strong><{$error}></h3>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
