<?php

// This file has template helpers

/**
 * HTML Escape
 *
 * @param string $string
 * @return string the escaped string
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get pager list
 *
 * @param int $currentPage
 * @param int $lastPage
 * @param string $urlFormat
 * @param int $size The size of pager
 * @return string The list for pager
 */
function pager($currentPage, $lastPage, $urlFormat, $keyword, $size = 4) {
    $pages = array();
    $pages[] = 1;

    if ($lastPage > 100) {
        $lastPage = 100;
    }

    $first = 2;
    if ($lastPage > $size) {
        if ($currentPage > $size + 2) {
            $first = $currentPage - $size;
        }
    }

    for ($i = $first; $i <= $lastPage && $i <= $currentPage + $size; $i++) {
        $pages[] = $i;
    }

    if ($currentPage + $size < $lastPage) {
        $pages[] = $lastPage;
    }

    $list = array();

    if ($currentPage != 1) {
        $list[] = '<li class="privious">'
            . '<a href="'.sprintf($urlFormat, urlencode($keyword), $currentPage - 1).'">'
            . '&lt;'
            . '</a>'
            . '</li>';
    } else {
        $list[] = '<li class="privious inactive">&lt;</li>';
    }

    $parent = null;
    foreach ($pages as $page) {
        if ($parent !== null && $parent !== $page - 1) {
            $list[] = '<li class="seperator">...</li>';
        }

        $parent = $page;


        if ($currentPage == $page) {
            $list[] = '<li class="current">'.$page.'</li>';
        } else {
            $list[] = '<li>'
                .'<a href="'.sprintf($urlFormat, urlencode($keyword), $page).'">'
                .$page
                .'</a>'
                .'</li>';
        }
    }

    if ($currentPage != $lastPage) {
        $list[] = '<li class="next">'
            . '<a href="'.sprintf($urlFormat, urlencode($keyword), $currentPage + 1).'">'
            . '&gt;'
            . '</a>'
            . '</li>';
    } else {
        $list[] = '<li class="next inactive">&gt;</li>';
    }

    return '<ul>'."\n".implode("\n", $list).'</ul>';
}
