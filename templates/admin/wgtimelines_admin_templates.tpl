<!-- Header -->
<{include file='db:wgtimelines_admin_header.tpl'}>
<{if $templates_list}>
<table class='table table-bordered'>
	<thead>
        <tr class="head">
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_NAME}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_DESC}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_FILE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_IMGPOS}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_IMGSTYLE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_TABLETYPE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_BGCOLOR}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_FONTCOLOR}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_IMGPOS_PANEL}></th>
            <th class="center width5"><{$smarty.const._AM_WGTIMELINES_FORM_ACTION}></th>
        </tr>
    </thead>
<{if $templates_count}>
	<tbody><{foreach item=template from=$templates_list}>
        <tr class="<{cycle values='odd, even'}>">
            <td class="center"><{$template.name}></td>
            <td class="center"><{$template.desc}></td>
            <td class="center"><{$template.file}></td>
            <td class="center">
                <{if $template.imgposition_show}><{$template.imgposition}><{else}>-<{/if}>
            </td>
            <td class="center">
                <{if $template.imgstyle_show}><{$template.imgstyle}><{else}>-<{/if}>
            </td>
            <td class="center">
                <{if $template.tabletype_show}><{$template.tabletype}><{else}>-<{/if}>
            </td>
            <td class="center">
                <{if $template.bgcolor_show}><{$template.bgcolor}><{else}>-<{/if}>
            </td>
            <td class="center">
                <{if $template.fontcolor_show}><{$template.fontcolor}><{else}>-<{/if}>
            </td>
            <td class="center">
                <{if $template.imgposition_p_show}><{$template.imgposition_p}><{else}>-<{/if}>
            </td>
            <td class="center  width5">
                <a href="templates.php?op=edit&amp;tpl_id=<{$template.id}>" title="<{$smarty.const._EDIT}>">
                    <img src="<{xoModuleIcons16 edit.png}>" alt="templates" />
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
