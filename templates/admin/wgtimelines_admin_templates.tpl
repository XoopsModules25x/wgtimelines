<!-- Header -->
<{include file='db:wgtimelines_admin_header.tpl'}>
<{if $templates_list|default:false}>
<table class='table table-bordered'>
	<thead>
        <tr class="head">
			<th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_NAME}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_DESC}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_FILE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_OPTIONS}></th>
			<th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_VERSION}></th>
			<th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_AUTHOR}></th>
			<th class="center"><{$smarty.const._AM_WGTIMELINES_DATE_CREATE}></th>
            <th class="center width5"><{$smarty.const._AM_WGTIMELINES_FORM_ACTION}></th>
        </tr>
    </thead>
<{if $templates_count|default:false}>
	<tbody><{foreach item=template from=$templates_list}>
        <tr class="<{cycle values='odd, even'}>">
			<td class="center">
				<{if $template.notsupported|default:false}><img src="<{$wgtimelines_icons_url}>/32/notsupported.png" alt="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NOTSUPPORTED}>" title="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NOTSUPPORTED}>"/>&nbsp;<{/if}>
				<{if $template.newversion|default:false}><a href="templates.php?op=update&amp;tpl_id=<{$template.id}>" title="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWVERSION}>"><img src="<{$wgtimelines_icons_url}>/32/newversion.png" alt="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWVERSION}>" /></a>&nbsp;<{/if}>
				<{if $template.newtemplate|default:false}><img src="<{$wgtimelines_icons_url}>/32/newtemplate.png" width="32px" alt="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWTEMPLATE}>" title="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWTEMPLATE}>"/>&nbsp;<{/if}>
				<br><{$template.name}>
				<{if $template.notsupported|default:false}>
					<br><span class="notsupported"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_NOTSUPPORTED}></span>
				<{/if}>
			</td>
            <td class="center"><{$template.desc}></td>
            <td class="center"><{$template.file}></td>
            <td class="left">
                <{foreach item=option from=$template.options}>
                    <{if $option.valid|default:0 > 0}>
                        <p style="padding:3px;">
                        <{$option.title}>: <{$option.value}>
                        <{if $option.type|default:'' == 'color'}>
                            &nbsp;<span style="border:1px solid #000;background-color:<{$option.value}>;border-radius:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <{/if}>
                        </p>
                    <{/if}>
                <{/foreach}>
            </td>
			<td class="center"><{$template.version}></td>
			<td class="center"><{$template.author}></td>
			<td class="center"><{$template.date_create_formatted}></td>
            <td class="center  width10">
                <a href="templates.php?op=edit&amp;tpl_id=<{$template.id}>" title="<{$smarty.const._EDIT}>">
                    <img src="<{xoModuleIcons16 edit.png}>" alt="templates" /></a>
				<a href="templates.php?op=reset&amp;tpl_id=<{$template.id}>" title="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_RESETVERSION}>">
					<img src="<{$wgtimelines_icons_url}>/16/reset.png" alt="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_RESETVERSION}>" /></a>
                <{if $template.newversion|default:false}><a href="templates.php?op=update&amp;tpl_id=<{$template.id}>" title="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWVERSION}>"><img src="<{$wgtimelines_icons_url}>/16/newversion.png" alt="<{$smarty.const._AM_WGTIMELINES_TEMPLATE_NEWVERSION}>" /></a><{/if}>
            </td>
        </tr>

<{/foreach}>
</tbody>

<{/if}>

</table>
<div class="clear">&nbsp;</div>
<{if $pagenav|default:false}>
	<div class="xo-pagenav floatright"><{$pagenav}></div><div class="clear spacer"></div>
<{/if}>

<{/if}>
<{if $form|default:false}>
	<{$form}>
<{/if}>
<{if $error|default:false}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<br></br />
<!-- Footer --><{include file='db:wgtimelines_admin_footer.tpl'}>
