<style>
    .toggle-buttons input[type="radio"] {
        visibility: hidden;
        margin:0 !important;
        padding:0 !important;
        -ms-transform: scale(0); /* IE 9 */
        -webkit-transform: scale(0); /* Chrome, Safari, Opera */
        transform: scale(0);
    }
    .toggle-buttons label {
        border: 1px solid #ddd;
        border-radius:5px;
        padding:10px 8px 8px 8px;
        margin:0 !important;
        line-height:40px;
        
    }
    .toggle-buttons label i.glyphicon {
        padding:0px;
        width:150px;
    }
    .toggle-buttons input:checked + label {
        background: #ddd;
        border: 1px solid #000;
    }
</style>
<{if $form_select|default:false}>
    <div class="form_select"><{$form_select}></div>
<{/if}>
<br>
<!-- Header -->
<{include file='db:wgtimelines_admin_header.tpl'}>
<{if $items_list|default:false}>
    <table class='table table-bordered' id='sortable-items'>
    <thead>
        <tr class="head">
            <th class="center">&nbsp;</th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_TITLE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_CONTENT}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_IMAGE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_DATE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_YEAR}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_ICON}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ITEM_READS}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_ONLINE}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_SUBMITTER}></th>
            <th class="center"><{$smarty.const._AM_WGTIMELINES_DATE_CREATE}></th>
            <th class="center width5"><{$smarty.const._AM_WGTIMELINES_FORM_ACTION}></th>
        </tr>
    </thead>
<{if $items_count}>
    <{foreach item=item from=$items_list}>
    <{if $item.new_timeline > 0}> 
    <tbody>
        <tr class="odd">
        <td id="timeline<{$item.tl_id}>" class="left" colspan="16"><{$item.tl_name}></td>
        </tr>
    <{/if}>
        <tr class="even" id="iorder_<{$item.id}>">
            <td class="center">
                <{if $item.nb_items_tl > 1}>
                    <img src="<{$wgtimelines_icons_url}>/16/up_down.png" alt="drag&drop" class="icon-sortable"/>
                <{else}>
                    &nbsp;
                <{/if}>
            </td>
            <td class="center"><{$item.title}></td>
            <td class=""><{$item.content_admin}></td>
            <td class="center"><img src="<{$wgtimelines_upload_url}>/images/items/<{$item.image}>" alt="<{$item.title}>" style="max-width:100px;" /></td>
            <td class="center"><{$item.date_admin}></td>
            <td class="center"><{$item.year}></td>
            <td class="center"><i class='glyphicon glyphicon-<{$item.icon}>'></i></td>
            <td class="center"><{$item.reads}></td>
            <td class="center">
                <a href="items.php?op=set_onoff&amp;item_id=<{$item.id}>" title="<{$item.online}>">
                    <{if $item.online == 1}>
                        <img src="<{xoModuleIcons16 on.png}>" alt="<{$smarty.const._YES}>" /></a>
                    <{else}>
                        <img src="<{xoModuleIcons16 off.png}>" alt="<{$smarty.const._NO}>" /></a>
                    <{/if}>
            </td>
            <td class="center"><{$item.submitter}></td>
            <td class="center"><{$item.date_create}></td>
            <td class="center">
                <a href="items.php?op=edit&amp;item_id=<{$item.id}>" title="<{$smarty.const._EDIT}>">
                    <img src="<{xoModuleIcons16 edit.png}>" alt="items" /></a>
                <a href="image_editor.php?op=edit_item&amp;item_id=<{$item.id}>" title="<{$smarty.const._AM_WGTIMELINES_IMG_EDITOR}>">
                    <img src="<{$wgtimelines_icons_url}>/16/image_editor.png" alt="<{$smarty.const._AM_WGTIMELINES_IMG_EDITOR}>"></a>
                <a href="items.php?op=editcopy&amp;item_id=<{$item.id}>" title="<{$smarty.const._AM_WGTIMELINES_COPY}>">
                    <img src="<{xoModuleIcons16 editcopy.png}>" alt="items" /></a>
                <a href="items.php?op=delete&amp;item_id=<{$item.id}>" title="<{$smarty.const._DELETE}>">
                    <img src="<{xoModuleIcons16 delete.png}>" alt="items" /></a>
            </td>
        </tr>
    <{/foreach}>
    </tbody>
<{/if}>

</table>
<div class="clear">&nbsp;</div>
<{if $pagenav|default:false}>
    <div class="xo-pagenav floatright"><{$pagenav}></div>
    <div class="clear spacer"></div>
<{/if}>

<{/if}>
<{if $form|default:false}>
    <{$form}>
<{/if}>
<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<br /><br />
<!-- Footer --><{include file='db:wgtimelines_admin_footer.tpl'}>
