<?php

add_action('init', function () {
    add_rewrite_rule('cabinet/action/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=load&method=json&a2=$1', 'top');
    add_rewrite_rule('cabinet/forgot-password/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/cabinet/forgot-password/index.php', 'top');
    add_rewrite_rule('ups/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/ups/$1', 'top');
    add_rewrite_rule('cabinet/assets/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/cabinet/assets/$1', 'top');
    add_rewrite_rule('cabinet/img/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/img/$1', 'top');
    add_rewrite_rule('cabinet/files/((.*)+)$', NA5KU_PLUGIN_URL . '/cabinet/files/$1', 'top');
    add_rewrite_rule('cabinet$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=main', 'top');
    add_rewrite_rule('cabinet/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=main', 'top');
    add_rewrite_rule('cabinet/profile.get?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=profile', 'top');
    add_rewrite_rule('cabinet/profile.do?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=profile&a2=save', 'top');
    add_rewrite_rule('cabinet/pm/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=pm', 'top');
    add_rewrite_rule('cabinet/pm/index.php?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=pm', 'top');
    add_rewrite_rule('cabinet/earn/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=friends', 'top');
    add_rewrite_rule('cabinet/earn/index.php?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=friends', 'top');
    add_rewrite_rule('cabinet/faq/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=faq', 'top');
    add_rewrite_rule('cabinet/faq/index.php?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=faq', 'top');
    add_rewrite_rule('cabinet/examples/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=examples', 'top');
    add_rewrite_rule('cabinet/examples/index.php?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=examples', 'top');
    add_rewrite_rule('cabinet/discount/?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=discount', 'top');
    add_rewrite_rule('cabinet/discount/index.php?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=discount', 'top');
    add_rewrite_rule('cabinet/open/((.*[^/])+)[/.*]?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=open_zakaz&id=$1', 'top');
    add_rewrite_rule('cabinet/read/((.*)+)?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=open_zakaz&id=$1', 'top');
    add_rewrite_rule('cabinet/add-file/((.*)+)?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=open_zakaz&id=$1&a2=file_add', 'top');
    add_rewrite_rule('cabinet/premoder/zakaz-((.*)+)?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=open_pre&id=$1', 'top');
    add_rewrite_rule('cabinet/edit/zakaz-((.*)+).do?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=edit_zakaz&id=$1&a2=edit&a3=do', 'top');
    add_rewrite_rule('cabinet/edit/zakaz-((.*)+)?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=edit_zakaz&id=$1&a2=edit', 'top');
    add_rewrite_rule('cabinet/comment.do?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=zakaz_comm', 'top');
    add_rewrite_rule('cabinet/pm.do?$', NA5KU_PLUGIN_URL . '/cabinet/cabinet/pm_send.php', 'top');
    add_rewrite_rule('cabinet/action.do?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=modal.do', 'top');
    add_rewrite_rule('cabinet/action.get?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=modal', 'top');
    add_rewrite_rule('cabinet/zakaz.write?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=open_new', 'top');
    add_rewrite_rule('cabinet/zakaz.add?$', NA5KU_PLUGIN_URL . '/cabinet/index.php?a=zakaz_add_do', 'top');
    add_rewrite_rule('cabinet/cabinet/zakaz.update?$', NA5KU_PLUGIN_URL . '/cabinet/zakaz_update_do.php', 'top');

    add_rewrite_rule('exit$', NA5KU_PLUGIN_URL . '/cabinet/do_logout.php', 'top');
    add_rewrite_rule('exit/?$', NA5KU_PLUGIN_URL . '/cabinet/do_logout.php', 'top');
});
