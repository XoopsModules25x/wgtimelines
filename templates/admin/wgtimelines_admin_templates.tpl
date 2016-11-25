<!-- Header -->
<{include file='db:wgtimelines_admin_header.tpl'}>
<{if $templates_list}>
<table class='table table-bordered'>
	<thead>
        <tr class="head">
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_NAME}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_DESC}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_FILE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_OPTIONS}></th>
			<th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_VERSION}></th>
			<th class="center"><{$smarty.const._AM_WGTIMELINES_TEMPLATE_AUTHOR}></th>
            <th class="center width5"><{$smarty.const._AM_WGTIMELINES_FORM_ACTION}></th>
        </tr>
    </thead>
<{if $templates_count}>
	<tbody><{foreach item=template from=$templates_list}>
        <tr class="<{cycle values='odd, even'}>">
            <td class="center"><{$template.name}></td>
            <td class="center"><{$template.desc}></td>
            <td class="center"><{$template.file}></td>
            <td class="left">
                <{foreach item=option from=$template.options}>
                    <{if $option.valid > 0}>
                        <p style="padding:3px;">
                        <{$option.title}>: <{$option.value}>
                        <{if $option.type == 'color'}>
                            &nbsp;<span style="border:1px solid #000;background-color:<{$option.value}>;border-radius:5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <{/if}>
                        </p>
                    <{/if}>
                <{/foreach}>
            </td>
			<td class="center"><{$template.version}></td>
			<td class="center"><{$template.author}></td>
            <td class="center  width10">
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
