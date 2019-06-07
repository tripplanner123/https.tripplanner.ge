<?php

defined('DIR') OR exit;

function sitemap($master = 0)
{
    $sql = "SELECT dd_sitemap.id as dd,dd_sitemap.* FROM dd_sitemap,dd_languages,dd_menulist WHERE dd_sitemap.menuid=dd_menulist.id AND dd_sitemap.language=dd_languages.id AND dd_menulist.menutype='main' AND dd_languages.shortname='" . l() . "' AND dd_sitemap.visibility='true' AND dd_sitemap.masterid='{$master}' order by position;";
    $res = db_fetch_all($sql);
    if (empty($res))
    {
        return NULL;
    }
    $out = NULL;
    foreach ($res as $r)
    {
        if ($r['level'] == 1)
            $out .= '<br />';
        $out .= '<a href="' . href($r['id']) . '" style="line-height: 1.5em; margin-left: ' . ($r['level'] * 15) . 'px;' . ($r['level'] == 1 ? 'font-weight: bold' : NULL) . '">&bull; ' . $r['title'] . '</a><br />';
        $out .= sitemap($r['idx']);
    }
    return $out;
}

echo sitemap();