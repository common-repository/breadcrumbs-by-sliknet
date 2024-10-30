<?
/**
 * Plugin Name: Breadcrumbs
 * Plugin URI: http://sliknet.com/
 * Description: Breadcrumbs by slikNET with support schema.org
 * Version: 1.0.1
 * Author: slikNET
 * Author URI: http://sliknet.com/
 **/

define( 'BREADCRUMBS_SN__DOMAIN', 'breadcrumbs_sliknet' );
define( 'BREADCRUMBS_SN__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BREADCRUMBS_SN__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


//  LANGUAGES
function breadcrumbs_init() {
    load_plugin_textdomain( BREADCRUMBS_SN__DOMAIN, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'init', 'breadcrumbs_init' );



//  SET SETTINGS AFTER ACTIVATE PLUGIN
function breadcrumbs_install(){
    save_breadcrumbs_options();
}
register_activation_hook( __FILE__, 'breadcrumbs_install' );


//  SAVE PLUGIN OPTIONS
function save_breadcrumbs_options($args = ''){
    //  DEFAULT OPTIONS
    $defaults = array(
        'page_text_home' => __('Home page', BREADCRUMBS_SN__DOMAIN),
        'page_text_category' => '%s',
        'page_text_search' => __('Search results for', BREADCRUMBS_SN__DOMAIN) .' <b>%s</b>',
        'articles_tags' => __('Articles with tag', BREADCRUMBS_SN__DOMAIN) .' <b>%s</b>',
        'articles_author' => __('Articles by author', BREADCRUMBS_SN__DOMAIN) .' <b>%s</b>',
        'page_404' => __('404', BREADCRUMBS_SN__DOMAIN),
        'show_current' => 1,
        'show_on_home' => 0,
        'show_home_link' => 1,
        'delimiter' => ''
    );
    $args = wp_parse_args( $args, $defaults );
    update_option('breadcrumbs_sliknet', $args );
}

if(isset($_POST['breadcrumbs_options_submit'])){
    $args = array();
    foreach($_POST as $name=>$value){
        if ( $value != '' ) $args[$name] = $value;
    }
    save_breadcrumbs_options($args);
}


//  GET PLUGIN OPTIONS
$breadcrumbs_options = get_option(BREADCRUMBS_SN__DOMAIN);
$page_text_home = $breadcrumbs_options['page_text_home'];
$page_text_category = $breadcrumbs_options['page_text_category'];
$page_text_search = $breadcrumbs_options['page_text_search'];
$articles_tags = $breadcrumbs_options['articles_tags'];
$articles_author = $breadcrumbs_options['articles_author'];
$page_404 = $breadcrumbs_options['page_404'];
$show_current = $breadcrumbs_options['show_current'];
$show_on_home = $breadcrumbs_options['show_on_home'];
$show_home_link = $breadcrumbs_options['show_home_link'];
$delimiter = $breadcrumbs_options['delimiter'];


//  Breadcrumbs function
function breadcrumbs() {
    global $post, $page_text_home, $page_text_category, $page_text_search, $articles_tags, $articles_author, $page_404, $show_current, $show_on_home, $show_home_link, $delimiter;

    $show_title = 1;
    $delimiter = '<li class="separator">'.$delimiter.'</li>';
    $before = '<li class="active"><span>';
    $after = '</span></li>';

    $home_link = home_url('/');
    $link_before = '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">';
    $link_after = '</li>';
    $text_before = '<span itemprop="title">';
    $text_after = '</span>';
    $link_attr = 'itemprop="url"';
    $link = $link_before . '<a ' . $link_attr . ' href="%1$s">'.$text_before.'%2$s'.$text_after.'</a>' . $link_after;
    $parent_id = $parent_id_2 = $post->post_parent;
    $frontpage_id = get_option('page_on_front');

    if (is_home() || is_front_page()) {
        if ($show_on_home == 1) echo '<ul class="breadcrumb"><li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $home_link . '" itemprop="url">' .$text_before . $page_text_home . $text_after . '</a></li></ul>';
    } else {

        echo '<ul class="breadcrumb">';
        if ($show_home_link == 1) {
            echo '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $home_link . '" itemprop="url">'. $text_before . $page_text_home . $text_after . '</a></li>';
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
        }

        if ( is_category() ) {
            $this_cat = get_category(get_query_var('cat'), false);
            if ($this_cat->parent != 0) {
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a ' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                $cats = preg_replace('/<a(.+?)>(.+?)<\/a>/i', '<a$1>'.$text_before.'$2'.$text_after.'</span></a>', $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            if ($show_current == 1) echo $before . sprintf($page_text_category, single_cat_title('', false)) . $after;

        } elseif ( is_search() ) {
            echo $before . sprintf($page_text_search, get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($show_current == 1) echo $delimiter . $before . strip_tags(get_the_title()) . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a ' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                $cats = preg_replace('/<a(.+?)>(.+?)<\/a>/i', '<a$1>'.$text_before.'$2'.$text_after.'</a>', $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
                if ($show_current == 1) echo $before . strip_tags(get_the_title()) . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $link_before . '<a ' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                $cats = preg_replace('/<a(.+?)>(.+?)<\/a>/i', '<a$1>'.$text_before.'$2'.$text_after.'</a>', $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo $delimiter . $before . strip_tags(get_the_title()) . $after;

        } elseif ( is_page() && !$parent_id ) {
            if ($show_current == 1) echo $before . strip_tags(get_the_title()) . $after;

        } elseif ( is_page() && $parent_id ) {
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), strip_tags(get_the_title($page->ID)));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs)-1) echo $delimiter;
                }
            }
            if ($show_current == 1) {
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
                echo $before . strip_tags(get_the_title()) . $after;
            }

        } elseif ( is_tag() ) {
            echo $before . sprintf($articles_tags, single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($articles_author, $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $page_404 . $after;

        } elseif ( has_post_format() && !is_singular() ) {
            echo get_post_format_string( get_post_format() );
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo 'Page ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }
        echo '</ul><!-- .breadcrumbs -->';
    }
}


//  ADMIN PANEL
function breadcrumbs_menu(){
    include 'breadcrumbs-admin.php';
}
function breadcrumbs_admin_actions(){
    add_options_page(__('Breadcrumbs settings', BREADCRUMBS_SN__DOMAIN), __('Breadcrumbs settings', BREADCRUMBS_SN__DOMAIN), 1,
        "breadcrumbs_sliknet", "breadcrumbs_menu");
}
add_action('admin_menu', 'breadcrumbs_admin_actions');