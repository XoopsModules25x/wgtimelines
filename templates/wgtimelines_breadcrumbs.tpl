<{if $xoBreadcrumbs|default:false}>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href='<{xoAppUrl 'index.php'}>' title='home'><i class="glyphicon glyphicon-home"></i></a></li>
        <{foreach item=itm from=$xoBreadcrumbs|default:null name=bcloop}>
            <li class="breadcrumb-item">
                <{if $itm.link|default:false}>
                    <a href='<{$itm.link}>' title='<{$itm.title}>'><{$itm.title}></a>
                <{else}>
                    <{$itm.title}>
                <{/if}>
            </li>
        <{/foreach}>
    </ol>
<{/if}>
