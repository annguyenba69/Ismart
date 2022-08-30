<?php

use App\Page;
use App\ProductCat;

if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = "đ")
    {
        return number_format($number, '0', '.', ',') . $suffix;
    }
}
if (!function_exists('limit_text')) {
    function limit_text($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

if (!function_exists('get_last_child_cat')) {
    function get_last_child_cat($cats)
    {
        $last_child_cat = $cats[0];
        foreach ($cats as $cat) {
            if ($cat->id > $last_child_cat->id) {
                $last_child_cat = $cat;
            }
        }
        return $last_child_cat;
    }
}

if (!function_exists('get_parent_categories')) {
    function get_parent_categories()
    {
        $result = [];
        foreach (ProductCat::all() as $cat) {
            if ($cat->parent_id == 0) {
                $result[] = $cat;
            }
        }
        return $result;
    }
}

if (!function_exists('get_pages')) {
    function get_pages()
    {
        return Page::all();
    }
}

if (!function_exists('get_pagging')) {
    function get_pagging($total_page, $page, $base_url)
    {
        $str_pagging = '<nav>
                    <ul class="pagination filter">';
        if ($page > 1) {
            $page_prev = $page - 1;
            $str_pagging .= "<li class=\"page-item\">
    <a class=\"page-link\" href='{$base_url}?page={$page_prev}' rel=\"prev\" aria-label=\"« Previous\">‹</a>
</li>";
        } else {
            $str_pagging .= '<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
    <span class="page-link" aria-hidden="true">‹</span>
</li>';
        };
        for ($i = 1; $i <= $total_page; $i++) {
            $active = "";
            if ($i == $page) {
                $active = "active";
            };
            $str_pagging .= "<li class=\"page-item $active\"><a class=\"page-link\"
    href='{$base_url}?page={$i}'>$i</a></li>";
        }
        if ($page < $total_page) {
            $page_next = $page + 1;
            $str_pagging .= "<li class=\"page-item\">
    <a class=\"page-link\" href='{$base_url}?page={$page_next}' rel=\"next\"
        aria-label=\"Next »\">›</a>
</li>";
        } else {
            $str_pagging .= '<li class="page-item disabled" aria-disabled="true" aria-label="Next »">
    <span class="page-link" aria-hidden="true">›</span>
</li>';
        }
        $str_pagging .= '</ul>
</nav>';
        return $str_pagging;
    }
}
