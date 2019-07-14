<?php
/*
Plugin Name: Display Categories Widget
Description: Display Categories Widget - Easy to display categories as widget on your sidebar, Smart Customizable widget settings on the backend
Plugin URI: http://www.iteamweb.com/open-source-softwares/wordpress/wordpress-plugins/display-categories-widget/
Version: 2.1
Author: Suresh Baskaran
License: GPL
*/
class DisplayCategoriesWidget extends WP_Widget

{
    function __construct()
    {
        $widget_ops = array(
            'classname' => 'DisplayCategoriesWidget',
            'description' => 'Displays categories'
        );
        parent::__construct('DisplayCategoriesWidget', 'Display Categories Widget', $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array(
            'title' => '',
            'cat_id' => 0,
						'category' => '',
						'dcw_limit' => '',
						'dcw_option_name' => '',
						'dcw_exclude' => '',
						'dcw_depth' => '',
						'display_parent' => 0,
						'display_empty_categories' => 0,
						'showcount_value' => 0,
						'use_desc_for_title' => 0,
						'sort_order_by' => 'name',
						'sort_order_as' => 'ASC',
						'show_format' => 0,
						'dcw_column' => '1'
        ));
        $title = $instance['title'];
        $category = $instance['category'];
        $dcw_limit = $instance['dcw_limit'];
        $dcw_option_name = $instance['dcw_option_name'];
        if ($dcw_option_name == "") $dcw_option_name = "Select A Category";
        $dcw_exclude = $instance['dcw_exclude'];
        $dcw_depth = $instance['dcw_depth'];
        $display_parent = $instance['display_parent'];
        $display_empty_categories = $instance['display_empty_categories'];
        $showcount_value = $instance['showcount_value'];
        $use_desc_for_title = $instance['use_desc_for_title'];
        $sort_order_by = $instance['sort_order_by'];
        $sort_order_as = $instance['sort_order_as'];
        $show_format = $instance['show_format'];
        $dcw_column = $instance['dcw_column'];

        // Get the existing categories and build a simple select dropdown for the user.

        $categories = get_categories(array(
            'hide_empty' => 0
        ));
        $cat_options = array();
        $cat_options[] = '<option value="BLANK">Select one...</option>';
        foreach($categories as $cat) {
            $selected = ($category == $cat->cat_ID) ? ' selected="selected"' : '';
            $cat_options[] = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->name . '</option>';
        }

?>
    <p><label for="<?php
        echo $this->get_field_id('title'); ?>"><?php
        _e('Title:'); ?> <input class="widefat" id="<?php
        echo $this->get_field_id('title'); ?>" name="<?php
        echo $this->get_field_name('title'); ?>" type="text" value="<?php
        echo esc_attr($title); ?>" /></label></p>
    

<p>
                <label for="<?php
        echo $this->get_field_id('category'); ?>">
                    <?php
        _e('Choose category (optional):'); ?>
                </label>
                <select id="<?php
        echo $this->get_field_id('category'); ?>" class="widefat" name="<?php
        echo $this->get_field_name('category'); ?>">
                    <?php
        echo implode('', $cat_options); ?>
                </select>
            </p>
<p><label for="<?php
        echo $this->get_field_id('dcw_limit'); ?>"><?php
        _e('Limit (optional):'); ?> <input class="widefat" id="<?php
        echo $this->get_field_id('dcw_limit'); ?>" name="<?php
        echo $this->get_field_name('dcw_limit'); ?>" type="text" value="<?php
        echo esc_attr($dcw_limit); ?>" /></label></p>
<p><label for="<?php
        echo $this->get_field_id('dcw_option_name'); ?>"><?php
        _e('Label no-selection (optional):'); ?> <input class="widefat" id="<?php
        echo $this->get_field_id('dcw_option_name'); ?>" name="<?php
        echo $this->get_field_name('dcw_option_name'); ?>" type="text" value="<?php
        echo esc_attr($dcw_option_name); ?>" /></label></p>
<p><label for="<?php
        echo $this->get_field_id('dcw_exclude'); ?>"><?php
        _e('Category ID\'s to exclude (optional):'); ?> <input class="widefat" id="<?php
        echo $this->get_field_id('dcw_exclude'); ?>" name="<?php
        echo $this->get_field_name('dcw_exclude'); ?>" type="text" value="<?php
        echo esc_attr($dcw_exclude); ?>" /></label><br /><?php
        _e('<small>Ex: 26,32,54 (comma-separated list of category ids)</small>'); ?></p>
<p><label for="<?php
        echo $this->get_field_id('dcw_depth'); ?>"><?php
        _e('Levels in the hierarchy to show (optional):'); ?> <input class="widefat" id="<?php
        echo $this->get_field_id('dcw_depth'); ?>" name="<?php
        echo $this->get_field_name('dcw_depth'); ?>" type="text" value="<?php
        echo esc_attr($dcw_depth); ?>" /></label><br /><?php
        _e('<small>0 - All Categories and child Categories (Default).<br />
-1 - All Categories displayed in flat (no indent) form (overrides hierarchical).<br />
1 - Show only top level Categories<br />
n - Value of n (some number) specifies the depth (or level) to descend in displaying Categories</small>'); ?></p>
<p><?php
        _e('Display Parent? (optional):'); ?> <br /><input name="<?php
        echo $this->get_field_name('display_parent'); ?>" type="radio" value="1" <?php
        if (esc_attr($display_parent) == 1) echo "checked"; ?> />Yes &nbsp; <input name="<?php
        echo $this->get_field_name('display_parent'); ?>" type="radio" value="0"  <?php
        if (esc_attr($display_parent) == 0) echo "checked"; ?>/>No </p>

<p><?php
        _e('Show? (optional):'); ?> <br /><input name="<?php
        echo $this->get_field_name('show_format'); ?>" type="radio" value="0" <?php
        if (esc_attr($show_format) == 0) echo "checked"; ?> />List &nbsp; <input name="<?php
        echo $this->get_field_name('show_format'); ?>" type="radio" value="2"  <?php
        if (esc_attr($show_format) == 2) echo "checked"; ?>/>Drop Down </p>

<p><?php
        _e('Display Empty categories? (optional):'); ?> <br /><input name="<?php
        echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="0" <?php
        if (esc_attr($display_empty_categories) == 0) echo "checked"; ?> />Yes &nbsp; <input name="<?php
        echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="1"  <?php
        if (esc_attr($display_empty_categories) == 1) echo "checked"; ?>/>No </p>
<p><?php
        _e('Display Number of posts near categories? (optional):'); ?> <br /><input name="<?php
        echo $this->get_field_name('showcount_value'); ?>" type="radio" value="1" <?php
        if (esc_attr($showcount_value) == 1) echo "checked"; ?> />Yes &nbsp; <input name="<?php
        echo $this->get_field_name('showcount_value'); ?>" type="radio" value="0"  <?php
        if (esc_attr($showcount_value) == 0) echo "checked"; ?>/>No </p>
<p><?php
        _e('Display category description as title? (optional):'); ?> <br /><input name="<?php
        echo $this->get_field_name('use_desc_for_title'); ?>" type="radio" value="1" <?php
        if (esc_attr($use_desc_for_title) == 1) echo "checked"; ?> />Yes &nbsp; <input name="<?php
        echo $this->get_field_name('use_desc_for_title'); ?>" type="radio" value="0"  <?php
        if (esc_attr($use_desc_for_title) == 0) echo "checked"; ?>/>No </p> 
<p><?php
        _e('Order by:'); ?> <br /><input name="<?php
        echo $this->get_field_name('sort_order_by'); ?>" type="radio" value="name" <?php
        if (esc_attr($sort_order_by) == 'name') echo "checked"; ?> />Name &nbsp; <input name="<?php
        echo $this->get_field_name('sort_order_by'); ?>" type="radio" value="id"  <?php
        if (esc_attr($sort_order_by) == 'id') echo "checked"; ?>/>Id &nbsp; <input name="<?php
        echo $this->get_field_name('sort_order_by'); ?>" type="radio" value="count"  <?php
        if (esc_attr($sort_order_by) == 'count') echo "checked"; ?>/>Count </p> 
<p><?php
        _e('Sort Order ASC/DESC:'); ?> <br /><input name="<?php
        echo $this->get_field_name('sort_order_as'); ?>" type="radio" value="ASC" <?php
        if (esc_attr($sort_order_as) == 'ASC') echo "checked"; ?> />ASC &nbsp; <input name="<?php
        echo $this->get_field_name('sort_order_as'); ?>" type="radio" value="DESC"  <?php
        if (esc_attr($sort_order_as) == 'DESC') echo "checked"; ?>/>DESC </p> 
<p>
                <label for="<?php
        echo $this->get_field_id('dcw_column'); ?>">
                    <?php
        _e('No. of columns to display (optional):'); ?>
                </label>
                <select id="<?php
        echo $this->get_field_id('dcw_column'); ?>" class="widefat" name="<?php
        echo $this->get_field_name('dcw_column'); ?>">
                 <?php
        for ($dcw_i = 1; $dcw_i < 4; $dcw_i++) {
?>
                    <option value=<?php
            echo $dcw_i; ?> <?php
            if ($instance['dcw_column'] == $dcw_i) echo ' selected="selected"'; ?>><?php
            echo $dcw_i; ?></option>
                 <?php
        } ?>
                </select>
            </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['category'] = $new_instance['category'];
        $instance['dcw_limit'] = $new_instance['dcw_limit'];
        $instance['dcw_option_name'] = $new_instance['dcw_option_name'];
        $instance['dcw_exclude'] = $new_instance['dcw_exclude'];
        $instance['dcw_depth'] = $new_instance['dcw_depth'];
        $instance['display_parent'] = $new_instance['display_parent'];
        $instance['display_empty_categories'] = $new_instance['display_empty_categories'];
        $instance['showcount_value'] = $new_instance['showcount_value'];
        $instance['use_desc_for_title'] = $new_instance['use_desc_for_title'];
        $instance['sort_order_by'] = $new_instance['sort_order_by'];
        $instance['sort_order_as'] = $new_instance['sort_order_as'];
        $instance['show_format'] = $new_instance['show_format'];
        $instance['dcw_column'] = $new_instance['dcw_column'];
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $cat_id = $instance['category'] ?? 0;
        $dcw_limit = $instance['dcw_limit'] ?? 'Categories';
        $dcw_option_name = $instance['dcw_option_name'] ?? '';
        $dcw_exclude = $instance['dcw_exclude'] ?? '';
        $dcw_depth = $instance['dcw_depth'] ?? 0;
        $display_empty_categories = $instance['display_empty_categories'] ?? 0;
        $showcount_value = $instance['showcount_value'] ?? 0;
        $use_desc_for_title = $instance['use_desc_for_title'] ?? 0;
        $sort_order_by = $instance['sort_order_by'] ?? 'name';
        $sort_order_as = $instance['sort_order_as'] ?? 'ASC';
        $show_format = $instance['show_format'] ?? 0;
        $dcw_column = $instance['dcw_column'] ?? 1;
				$dcw_display_parent = $instance['display_parent'] ?? 0;

        if (!empty($title)) echo $before_title . $title . $after_title;
        if (  $dcw_display_parent == 1) {
            $yourcat = get_category($cat_id);
            if ($yourcat) echo '<h2>' . $yourcat->name . '</h2>';
        }

        if ($cat_id == "BLANK") $cat_id = "0";
        if ($dcw_depth == "BLANK") $dcw_depth = "0";
        $dcw_incrementor = 1;
        if ($show_format == 0) {
            echo "<style>.dcw_c1 {float:left; width:100%} .dcw_c2 {float:left; width:50%} .dcw_c3 {float:left; width:33%}</style>";
            echo "<ul class='dcw'>";
            wp_list_categories('orderby='.$sort_order_by.'&order='.$sort_order_as.'&use_desc_for_title='.$use_desc_for_title.'&show_count=' . $showcount_value . '&child_of=' . $cat_id . '&hide_empty=' . $display_empty_categories . '&title_li=&number=' . $dcw_limit . '&exclude=' . $dcw_exclude . '&depth=' . $dcw_depth);
            echo "</ul>";
            $class_definer = "dcw_c" . $dcw_column;
            echo "<script>jQuery('ul.dcw').find('li').addClass('$class_definer');</script>";
        }

        if ($show_format == 2) {
            $dcw_disp_widget_id = dcw_get_widget_id($this->id);
?>
    <form action="<?php
            bloginfo('url'); ?>" method="get">
    <div>
    <?php
            wp_dropdown_categories('orderby='.$sort_order_by.'&order='.$sort_order_as.'&name=cat' . $dcw_disp_widget_id . '&show_option_none=' . $dcw_option_name . '&hierarchical=1&show_count=' . $showcount_value . '&child_of=' . $cat_id . '&hide_empty=' . $display_empty_categories . '&title_li=&number=' . $dcw_limit . '&exclude=' . $dcw_exclude . '&depth=' . $dcw_depth); ?>
    <script type="text/javascript">
        <!--
        var dropdown<?php
            echo $dcw_disp_widget_id; ?> = document.getElementById("cat<?php
            echo $dcw_disp_widget_id; ?>");
        function onCatChange<?php
            echo $dcw_disp_widget_id; ?>() {
            if ( dropdown<?php
            echo $dcw_disp_widget_id; ?>.options[dropdown<?php
            echo $dcw_disp_widget_id; ?>.selectedIndex].value > 0 ) {
                location.href = "<?php
            echo esc_url(home_url('/')); ?>?cat="+dropdown<?php
            echo $dcw_disp_widget_id; ?>.options[dropdown<?php
            echo $dcw_disp_widget_id; ?>.selectedIndex].value;
            }
        }
        dropdown<?php
            echo $dcw_disp_widget_id; ?>.onchange = onCatChange<?php
            echo $dcw_disp_widget_id; ?>;
        -->
    </script>
    </div>
    </form>
    
<?php
            $dcw_incrementor++;
        }

        echo $after_widget;
    }
}

function dcw_get_widget_id($dcw_wid)
{
    $dcw_process_id = explode('-', $dcw_wid);
    return $dcw_process_id[1];
}

add_action('widgets_init', function() {return register_widget("DisplayCategoriesWidget");}); ?>
