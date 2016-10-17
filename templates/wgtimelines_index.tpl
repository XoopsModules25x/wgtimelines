<{include file='db:wgtimelines_header.tpl'}>

<{if count($templates) == 0}>
<table class="table table-<{$table_type}>">
    <thead>
        <tr class="center">
            <th><{$smarty.const._MA_WGTIMELINES_TITLE}>  -  <{$smarty.const._MA_WGTIMELINES_DESC}></th>
        </tr>
    </thead>
    <tbody>
        <tr class="center">
            <td class="bold pad5">
                <ul class="menu text-center">
                    <li><a href="<{$wgtimelines_url}>"><{$smarty.const._MA_WGTIMELINES_INDEX}></a></li>
                    <li><a href="<{$wgtimelines_url}>/timelines.php"><{$smarty.const._MA_WGTIMELINES_TIMELINES}></a></li>
                    <li><a href="<{$wgtimelines_url}>/items.php"><{$smarty.const._MA_WGTIMELINES_ITEMS}></a></li>
                    <li><a href="<{$wgtimelines_url}>/templates.php"><{$smarty.const._MA_WGTIMELINES_TEMPLATES}></a></li>
                </ul>
				<div class="justify pad5"><{$smarty.const._MA_WGTIMELINES_INDEX_DESC}></div>
            </td>
        </tr>
    </tbody>
    <tfoot>
    <{if $adv != ''}>
        <tr class="center"><td class="center bold pad5"><{$adv}></td></tr>
    <{else}>
        <tr class="center"><td class="center bold pad5">&nbsp;</td></tr>
    <{/if}>
    </tfoot>
</table>
<{/if}>
<{if count($timelines) > 0}>
<div class="table-responsive">
    <table class="table table-<{$table_type}>">
		<thead>
			<tr>
				<th colspan="<{$numb_col}>"><{$smarty.const._MA_WGTIMELINES_TIMELINES}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=timeline from=$timelines}>
				<td>
					<{include file="db:wgtimelines_timelines_list.tpl" timeline=$timeline}>
				</td>
			<{if $timeline.count is div by $numb_col}>
			</tr><tr>
			<{/if}>
				<{/foreach}>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<{$numb_col}>" class="timeline-thereare"><{$lang_thereare}></td>
			</tr>
		</tfoot>
	</table>
</div>
<{/if}>

<{if count($items) > 0}>
<div class="table-responsive">
    <table class="table table-<{$table_type}>">
		<thead>
			<tr>
				<th colspan="<{$numb_col}>"><{$smarty.const._MA_WGTIMELINES_ITEMS}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=item from=$items}>
				<td>
					<{include file="db:wgtimelines_items_list.tpl" item=$item}>
				</td>
			<{if $item.count is div by $numb_col}>
			</tr><tr>
			<{/if}>
				<{/foreach}>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<{$numb_col}>" class="item-thereare"><{$lang_thereare}></td>
			</tr>
		</tfoot>
	</table>
</div>
<{/if}>

<{if count($items) > 0}>
	<!-- Start Show new items in index -->
	<div class="wgtimelines-linetitle"><{$smarty.const._MA_WGTIMELINES_INDEX_LATEST_LIST}></div>
	<table class="table table-<{$table_type}>">
		<tr>
			<!-- Start new link loop -->
			<{section name=i loop=$items}>
				<td class="col_width<{$numb_col}> top center">
					<{include file="db:wgtimelines_items_list.tpl" item=$items[i]}>
				</td>
	<{if $items[i].count is div by $divideby}>
		</tr><tr>
	<{/if}>
			<{/section}>
	<!-- End new link loop -->
		</tr>
	</table>
<!-- End Show new files in index -->
<{/if}>
<{if count($templates) > 0}>
<div class="table-responsive">
    <table class="table table-<{$table_type}>">
		<thead>
			<tr>
				<th colspan="<{$numb_col}>"><{$smarty.const._MA_WGTIMELINES_TEMPLATES}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=template from=$templates}>
				<td>
					<{include file="db:wgtimelines_templates_list.tpl" template=$template}>
				</td>
			<{if $template.count is div by $numb_col}>
			</tr><tr>
			<{/if}>
				<{/foreach}>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<{$numb_col}>" class="template-thereare"><{$lang_thereare}></td>
			</tr>
		</tfoot>
	</table>
</div>
<{/if}>

<{if count($templates) > 0}>
	<!-- Start Show new templates in index -->
	<div class="wgtimelines-linetitle"><{$smarty.const._MA_WGTIMELINES_INDEX_LATEST_LIST}></div>
	<table class="table table-<{$table_type}>">
		<tr>
			<!-- Start new link loop -->
			<{section name=i loop=$templates}>
				<td class="col_width<{$numb_col}> top center">
					<{include file="db:wgtimelines_templates_list.tpl" template=$templates[i]}>
				</td>
	<{if $templates[i].count is div by $divideby}>
		</tr><tr>
	<{/if}>
			<{/section}>
	<!-- End new link loop -->
		</tr>
	</table>
<!-- End Show new files in index -->
<{/if}>
<{include file='db:wgtimelines_footer.tpl'}>
