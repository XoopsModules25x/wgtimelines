<{include file='db:wgtimelines_header.tpl'}>

<{foreach item=timeline from=$timelines}>
	<div class="col-xs-12 cols-sm-12 timeline-list">
		<{if $timeline.image}>
			<div class='col-sm-4'><img src="<{$wgtimelines_upload_url}>/images/timelines/<{$timeline.image}>" class="img-responsive" alt="<{$timeline.name}>" /></div>
			<div class='col-sm-8'>
		<{else}>
			<div class="col-xs-12 cols-sm-12">
		<{/if}>
		<p class="timeline-list-link"><a href="<{$wgtimelines_url}>/index.php?op=list&amp;tl_id=<{$timeline.id}>" title="<{$timeline.name}>"><{$timeline.name}></a></p>
		<{if $timeline.timeline_desc}><p><{$timeline.timeline_desc}></p><{/if}>
		</div>
	</div>
<{/foreach}>
<{if $error}>
	<h3><strong><{$error}></h3>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
