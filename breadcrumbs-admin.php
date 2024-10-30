<?
//  GET OPTIONS
global $page_text_home,
       $page_text_category,
       $page_text_search,
       $articles_tags,
       $articles_author,
       $page_404,
       $show_current,
       $show_on_home,
       $show_home_link,
       $delimiter;
?>

<h1><? _e('Settings', BREADCRUMBS_SN__DOMAIN)?></h1>
<form  action="#" method="post">
    <fieldset>
        <h2><? _e('Text for pages', BREADCRUMBS_SN__DOMAIN)?></h2>
        <table>
            <tbody>
                <tr>
                    <td><label for="page_text_home"><? _e('Home', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="page_text_home" id="page_text_home" value="<?=esc_attr($page_text_home)?>"></td>
                </tr>
                <tr>
                    <td><label for="page_text_category"><? _e('Category', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="page_text_category" id="page_text_category" value="<?=esc_attr($page_text_category)?>"></td>
                </tr>
                <tr>
                    <td><label for="page_text_search"><? _e('Search results', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="page_text_search" id="page_text_search" value="<?=esc_attr($page_text_search)?>"></td>
                </tr>
                <tr>
                    <td><label for="articles_tags"><? _e('Articles with tag', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="articles_tags" id="articles_tags" value="<?=esc_attr($articles_tags)?>"></td>
                </tr>
                <tr>
                    <td><label for="articles_author"><? _e('Articles by author', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="articles_author" id="articles_author" value="<?=esc_attr($articles_author)?>"></td>
                </tr>
                <tr>
                    <td><label for="page_404"><? _e('Page 404', BREADCRUMBS_SN__DOMAIN)?></label></td>
                    <td><input type="text" name="page_404" id="page_404" value="<?=esc_attr($page_404)?>"></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
    <fieldset>
        <h2><? _e('Options', BREADCRUMBS_SN__DOMAIN)?></h2>
        <table>
            <tr>
                <td><label for="delimiter"><? _e('Separator', BREADCRUMBS_SN__DOMAIN)?></label></td>
                <td><input type="text" name="delimiter" id="delimiter" value="<?=esc_attr($delimiter)?>"></td>
            </tr>
            <tr>
                <td><label><? _e('Show current title of page/post/category', BREADCRUMBS_SN__DOMAIN)?></label></td>
                <td>
                    <input type="radio" name="show_current" <?=($show_current == 1)?'checked':''?> id="show_current_1" value="1">
                    <label for="show_current_1"><? _e('Yes', BREADCRUMBS_SN__DOMAIN)?></label>
                    <input type="radio" name="show_current" <?=($show_current == 0)?'checked':''?> id="show_current_0" value="0">
                    <label for="show_current_0"><? _e('No', BREADCRUMBS_SN__DOMAIN)?></label>
                </td>
            </tr>
            <tr>
                <td><label><? _e('Show on Home page', BREADCRUMBS_SN__DOMAIN)?></label></td>
                <td>
                    <input type="radio" name="show_on_home" <?=($show_on_home == 1)?'checked':''?> id="show_on_home_1" value="1">
                    <label for="show_on_home_1"><? _e('Yes', BREADCRUMBS_SN__DOMAIN)?></label>
                    <input type="radio" name="show_on_home" <?=($show_on_home == 0)?'checked':''?> id="show_on_home_0" value="0">
                    <label for="show_on_home_0"><? _e('No', BREADCRUMBS_SN__DOMAIN)?></label>
                </td>
            </tr>
            <tr>
                <td><label><? _e('Show home link', BREADCRUMBS_SN__DOMAIN)?></label></td>
                <td>
                    <input type="radio" name="show_home_link" <?=($show_home_link == 1)?'checked':''?> id="show_home_link_1" value="1">
                    <label for="show_home_link_1"><? _e('Yes', BREADCRUMBS_SN__DOMAIN)?></label>
                    <input type="radio" name="show_home_link" <?=($show_home_link == 0)?'checked':''?> id="show_home_link_0" value="0">
                    <label for="show_home_link_0"><? _e('No', BREADCRUMBS_SN__DOMAIN)?></label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="<? _e('Save settings', BREADCRUMBS_SN__DOMAIN)?>" name="breadcrumbs_options_submit" id="breadcrumbs_options_submit"></td>
            </tr>
        </table>
    </fieldset>
</form>
