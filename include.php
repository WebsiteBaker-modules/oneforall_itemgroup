<?php

/*
  Snippet developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2016, Christoph Marti

  LICENCE TERMS:
  This snippet is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  DISCLAIMER:
  This snippet is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.


  -----------------------------------------------------------------------------------------
   Code snippet OneForAll ListAllItems for Website Baker v2.6.x
  -----------------------------------------------------------------------------------------

*/



// Function to display a list of items of a specified OneForAll group (invoke function from template or code page)
if (!function_exists('oneforall_itemgroup')) {
	function oneforall_itemgroup($mod_name, $view_groups = null, $max_items = null) {



		// MAKE YOUR MODIFICATIONS TO THE LAYOUT OF THE ITEMS DISPLAYED
		// ************************************************************

		// Use this html for the layout
		$setting_header = '
		<div id="mod_oneforall_itemgroup_wrapper">
		<ul>';

		$setting_item_loop = '
		<li><a href="[LINK]" title="[TITLE]" target="_blank">[TITLE]</a></li>';
	
		$setting_footer = '
		</ul>
		</div>';
		// end layout html




		// DO NOT CHANGE ANYTHING BEYOND THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING
		// **************************************************************************

		global $wb, $admin, $database;

		// Check if module exits
		$mod_name   = $admin->add_slashes(strip_tags($mod_name));
		$mod_exists = $database->get_one("SELECT module FROM ".TABLE_PREFIX."sections WHERE module = '$mod_name'");

		if (empty($mod_exists)) {
			echo 'ERROR: No pages make use of module &quot;'.$mod_name.'&quot;. Please check the function arguments.';
		}
		else {

			// The HTML
			$html = $setting_header;

			// Get the group field
			$group_field = $database->query("SELECT field_id, extra FROM `".TABLE_PREFIX."mod_".$mod_name."_fields` WHERE type = 'group' LIMIT 1");

			// If a group field is defined get the group field id and the group names
			if ($group_field->numRows() == 1) {
				$group = $group_field->fetchRow();
				$group_field_id = $group['field_id'];
				$group_names    = explode(',', $group['extra']);
				$group_names    = array_map('trim', $group_names);

				// Get the groups we want to show
				$group_field_values = '';
				if (empty($view_groups)) {
					echo 'ERROR: No group name provided. Please use the second function argument to specify at least one group name. Add more than one group using comma separated values.';
				} else {
					// Convert csv to array
					$view_groups = explode(',', $view_groups);
					$view_groups = array_map('trim', $view_groups);
					// Intersection of the 2 arrays
					$intersect   = array_intersect($group_names, $view_groups);
					// Increment array key
					$intersect   = array_flip(array_map(function($el){ return $el + 1; }, array_flip($intersect)));
					// Create string for mysql IN clause
					$group_field_values = implode("','", array_keys($intersect));
				}

				// Limit number of items
				$limit_sql = '';
				if ($max_items) {
					$limit_sql = " LIMIT $max_items";
				}

				// Query items
				$query_items = $database->query("SELECT i.page_id, i.title, i.link FROM `".TABLE_PREFIX."mod_".$mod_name."_items` i INNER JOIN `".TABLE_PREFIX."mod_".$mod_name."_item_fields` f ON i.item_id = f.item_id WHERE i.active = '1' AND i.title != '' AND f.field_id = '".$group_field_id."' AND f.value IN('".$group_field_values."') ORDER BY i.position ASC".$limit_sql);

				// Loop through all items of this module
				if ($query_items->numRows() > 0) {
					while ($item = $query_items->fetchRow()) {
						$page_id = stripslashes($item['page_id']);
						$title   = htmlspecialchars(stripslashes($item['title']));
						// Work-out the item link
						$item_link = WB_URL.PAGES_DIRECTORY.get_page_link($page_id).$item['link'].PAGE_EXTENSION;

						// Replace placeholders by values
						// Make array of placeholders
						$placeholders = array('[TITLE]', '[LINK]');
						// Make array of values
						$values = array($title, $item_link);
						// HTML of item loop
						$html .= str_replace($placeholders, $values, $setting_item_loop);
					}
				}

				// Add item to the HTML
				$html .= $setting_footer;

				// Output HTML code
				echo $html;
			}
			else {
				echo 'ERROR: No group field defined.';
			}
		}
	}
}

?>
