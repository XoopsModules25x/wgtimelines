<{include file='db:wgtimelines_header.tpl'}>
<{if $welcome}>
	<div class="error page-header">
		<h2><{$welcome}></h2>
	</div>
<{/if}>
<{foreach item=timeline from=$timelines}>
	<div class="col-xs-12 cols-sm-12 timeline-list">
		<{if $timeline.image}>
			<div class='col-sm-4'><img src="<{$wgtimelines_upload_url}>/images/timelines/<{$timeline.image}>" class="img-responsive" alt="<{$timeline.name}>" /></div>
			<div class='col-sm-8'>
		<{else}>
			<div class="col-xs-12 cols-sm-12">
		<{/if}>
		<p class="timeline-list-link"><a href="<{$wgtimelines_url}>/index.php?op=list&amp;tl_id=<{$timeline.id}>" title="<{$timeline.name}>"><{$timeline.name}></a></p>
		<p><{$timeline.desc}></p>
		</div>
	</div>
<{/foreach}>
<{if $error}>
	<h3><strong><{$error}></h3>
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
