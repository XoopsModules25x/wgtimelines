<!-- Header -->
<{include file='db:wgtimelines_admin_header.tpl'}>
<{if $timelines_list}>
<table class='table table-bordered' id="sortable-timelines">
    <thead>
        <tr class="head">
            <th class="center">&nbsp;</th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TIMELINE_NAME}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TIMELINE_TEMPLATE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TIMELINE_SORTBY}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ONLINE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_SUBMITTER}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_DATE_CREATE}></th>
            <th class="center width5"><{$smarty.const._AM_WGTIMELINES_FORM_ACTION}></th>
        </tr>
    </thead>
    <{if $timelines_count}>
    <tbody id="timelines-list"><{foreach item=timeline from=$timelines_list}>
        <tr class="even" id="torder_<{$timeline.id}>" >
            <td class="center"><img src="<{$wgtimelines_icons_url}>/16/up_down.png" alt="drag&drop" class="icon-sortable"/></td>
            <td class="center"><{$timeline.name}></td>
            <td class="center"><{$timeline.template}></td>
            <td class="center"><{$timeline.sortby_text}></td>
            <td class="center">
                <a href="timelines.php?op=set_onoff&amp;tl_id=<{$timeline.id}>" title="<{$timeline.online}>">
                    <{if $timeline.online == 1}>
                        <img src="<{xoModuleIcons16 on.png}>" alt="<{$smarty.const._YES}>" />
                    <{else}>
                        <img src="<{xoModuleIcons16 off.png}>" alt="<{$smarty.const._NO}>" />
                    <{/if}>
                </a>
            </td>
            <td class="center"><{$timeline.submitter}></td>
            <td class="center"><{$timeline.date_create}></td>
            <td class="center  width5">
            <a href="timelines.php?op=edit&amp;tl_id=<{$timeline.id}>" title="<{$smarty.const._EDIT}>">
                <img src="<{xoModuleIcons16 edit.png}>" alt="timelines" />
            </a>
            <a href="timelines.php?op=delete&amp;tl_id=<{$timeline.id}>" title="<{$smarty.const._DELETE}>">
                <img src="<{xoModuleIcons16 delete.png}>" alt="timelines" />
            </a>
            </td>
        </tr>
    <{/foreach}>
    </tbody>
    <{/if}>
</table>
<div class="clear">&nbsp;</div>
<{if $pagenav}>
	<div class="xo-pagenav floatright"><{$pagenav}></div>
<div class="clear spacer"></div>

<{/if}>

<{/if}>
<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong>
</div>

<{/if}>
<br /></br />
<!-- Footer --><{include file='db:wgtimelines_admin_footer.tpl'}>
