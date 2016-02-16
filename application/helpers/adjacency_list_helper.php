<?php
/**
 * Adjacency List
 *
 * @package Helper
 * @author  Michał Śniatała <michal@sniatala.pl>
 * @license http://opensource.org/licenses/MIT  (MIT)
 * @since   Version 0.1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('build_admin_tree'))
{
	/**
	 * Build admin tree
	 *
	 * Creates adjacency list for administration
	 *
	 * @param array &$tree Tree items
	 *
	 * @return string
	 */
	function build_admin_tree(&$tree)
	{
		$output = '';

		if ( ! empty($tree))
		{
			foreach ($tree as &$leaf)
			{
				$leaf['name'] = htmlspecialchars($leaf['name'], ENT_QUOTES, 'UTF-8');

				if (isset($leaf['children']) && ! empty($leaf['children']))
				{
					$output .= '<li id="list_' . $leaf['id'] . '"><div><i class="icon-move"></i> ' . $leaf['name'] . '<span><a class="btn btn-primary btn-mini" href="' . site_url('al/edit/' . $leaf['id']) . '"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-mini delete" data-toggle="modal" data-type="item" data-href="' . site_url('al/delete/' . $leaf['id']) . '" data-name="' . $leaf['name'] . '" href="javascript:;"><i class="icon-trash icon-white"></i> Delete</a></span></div>';
					$output .= '<ol>' . build_admin_tree($leaf['children']) . '</ol>';
					$output .= '</li>';
				}
				else
				{
					$output .= '<li id="list_' . $leaf['id'] . '"><div><i class="icon-move"></i> ' . $leaf['name'] . '<span><a class="btn btn-primary btn-mini" href="' . site_url('al/edit/'.$leaf['id']) . '"><i class="icon-pencil icon-white"></i> Edit</a> <a class="btn btn-danger btn-mini delete" data-toggle="modal" data-type="item" data-href="' . site_url('al/delete/' . $leaf['id']) . '" data-name="' . $leaf['name'] . '" href="javascript:;"><i class="icon-trash icon-white"></i> Delete</a></span></div></li>';
				}
			}
		}

		return $output;
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('build_tree'))
{
	/**
	 * Build tree
	 *
	 * Creates adjacency list based on group id or slug
	 *
	 * @param mixed $group      Group id or slug
	 * @param array $attributes Any attributes
	 * @param array &$tree      Tree array
	 *
	 * @return string
	 */
	function build_tree($group, $attributes = array(), &$tree = array())
	{
		if (empty($tree))
		{
			$CI =& get_instance();
			$CI->load->library('adjacency_list');

			$tree = $CI->adjacency_list->get_all($group);
			$tree = parse_children($tree);
		}

		foreach (array('start_tag' => '<li>', 'end_tag' => '</li>', 'sub_start_tag' => '<ul>', 'sub_end_tag' => '</ul>') as $key => $val)
		{
			$atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
			unset($attributes[$key]);
		}

		$output = '';

		if ( ! empty($tree))
		{
			foreach ($tree as &$leaf)
			{
				$leaf['name'] = htmlspecialchars($leaf['name'], ENT_QUOTES, 'UTF-8');

				if (isset($leaf['children']) && ! empty($leaf['children']))
				{
					$output .= $atts['start_tag'] . '<a href="' . $leaf['url'] . '">' . $leaf['name'] . '</a>';
					$output .= $atts['sub_start_tag'] . build_tree($group, $attributes, $leaf['children']) . $atts['sub_end_tag'];
					$output .= $atts['end_tag'];
				}
				else
				{
					$output .= $atts['start_tag'] . '<a href="' . $leaf['url'] . '">' . $leaf['name'] . '</a>' . $atts['end_tag'];
				}
			}
		}

		return $output;
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('build_breadcrumb'))
{
	/**
	 * Build breadcrumb
	 *
	 * Creates breadcrumb based on group (id or slug) and current item id
	 *
	 * @param mixed $group        Group id or slug
	 * @param int   $item_id      Current item id
	 * @param array $attributes   Any attributes
	 * @param array &$tree        Tree array
	 * @param array &$output_tree Output tree array
	 *
	 * @return string
	 */
	function build_breadcrumb($group, $item_id, $attributes = array(), &$tree = array(), &$output_tree = array())
	{
		if (empty($tree))
		{
			$CI =& get_instance();
			$CI->load->library('adjacency_list');

			$tree = $CI->adjacency_list->get_all($group);
		}

		if ( ! empty($tree))
		{
			foreach ($tree as &$leaf)
			{
				if ($item_id === (int) $leaf['id'])
				{
					array_push($output_tree, $leaf);

					build_breadcrumb($group, (int) $leaf['parent_id'], $attributes, $tree, $output_tree);
				}
			}

			return format_breadcrumb(array_reverse($output_tree), $item_id, $attributes);
		}

		return '';
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('format_breadcrumb'))
{
	/**
	 * Format breadcrumb
	 *
	 * Format breadcrumb based on input array
	 *
	 * @param array $array      Array of items
	 * @param int   $item_id    Current item id
	 * @param array $attributes Any attributes
	 *
	 * @return string
	 */
	function format_breadcrumb($array, $item_id, $attributes = array())
	{
		foreach (array('start_tag' => '<li>', 'end_tag' => '</li>', 'start_tag_active' => '<li class="active">', 'divider' => ' <span class="divider">/</span>') as $key => $val)
		{
			$atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
			unset($attributes[$key]);
		}

		$output = '';

		if ( ! empty($array) && is_array($array))
		{
			foreach ($array as &$item)
			{
				$item['name'] = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');

				if ($item_id === (int) $item['id'])
				{
					$output .= $atts['start_tag_active'] . $item['name'] . $atts['end_tag'];
				}
				else
				{
					$output .= $atts['start_tag'] . '<a href="' . $item['url'] . '">' . $item['name'] . '</a>' . $atts['divider'] . $atts['end_tag'];
				}
			}
		}

		return $output;
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('build_tree_item'))
{
	/**
	 * Build tree item
	 *
	 * Creates adjacency list based on group (id or slug) and shows leafs related only to current item
	 *
	 * @param mixed $group        Group id or slug
	 * @param int   $item_id      Current item id
	 * @param array $attributes   Any attributes
	 * @param array &$tree        Tree array
	 * @param array &$in_array    Output tree array
	 *
	 * @return string
	 */
	function build_tree_item($group, $item_id, $attributes = array(), &$tree = NULL, &$in_array = array())
	{
		if (empty($tree))
		{
			$CI =& get_instance();
			$CI->load->library('adjacency_list');

			$tree = $CI->adjacency_list->get_all($group);
		}

		if ( ! empty($tree))
		{
			foreach ($tree as &$leaf)
			{
				if ($item_id === (int) $leaf['id'])
				{
					array_push($in_array, $leaf['id']);

					build_tree_item($group, (int) $leaf['parent_id'], $attributes, $tree, $in_array);
				}
			}

			$tree     = parse_children($tree);
			$in_array = array_reverse($in_array);

			return format_tree($tree, $in_array, $attributes);
		}

		return '';
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('format_tree'))
{
	/**
	 * Format tree
	 *
	 * Format tree based on input array
	 *
	 * @param array &$tree      Array of items
	 * @param int   &$in_array  Current item id
	 * @param array $attributes Any attributes
	 *
	 * @return string
	 */
	function format_tree(&$tree, &$in_array, $attributes = array())
	{
		foreach (array('start_tag' => '<li>', 'end_tag' => '</li>', 'sub_start_tag' => '<ul>', 'sub_end_tag' => '</ul>') as $key => $val)
		{
			$atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
			unset($attributes[$key]);
		}

		$output = '';

		if ( ! empty($tree))
		{
			foreach ($tree as &$leaf)
			{
				$leaf['name'] = htmlspecialchars($leaf['name'], ENT_QUOTES, 'UTF-8');

				if (isset($leaf['children']) && ! empty($leaf['children']) && (in_array($leaf['id'], $in_array)))
				{
					$output .= $atts['start_tag'] . '<a href="' . $leaf['url'] . '">' . $leaf['name'] . '</a>';
					$output .= $atts['sub_start_tag'] . format_tree($leaf['children'], $in_array, $attributes) . $atts['sub_end_tag'];
					$output .= $atts['end_tag'];
				}
				else
				{
					$output .= $atts['start_tag'] . '<a href="' . $leaf['url'] . '">' . $leaf['name'] . '</a>' . $atts['end_tag'];
				}
			}
		}

		return $output;
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('parse_children'))
{
	/**
	 * Parse children
	 *
	 * Parse array and format it to subarrays with children
	 *
	 * @param $array &$query Array input
	 *
	 * @return array|bool
	 */
	function parse_children(&$query)
	{
		! empty($query) OR FALSE;

		$tree = array();

		foreach ($query as &$row)
		{
			$tree[$row['id']] = $row;
		}

		unset($query);

		$tree_array = array();

		foreach ($tree as &$leaf)
		{
			if (array_key_exists($leaf['parent_id'], $tree))
			{
				$tree[$leaf['parent_id']]['children'][] = &$tree[$leaf['id']];
			}

			if ( ! isset($tree[$leaf['id']]['children']))
			{
				$tree[$leaf['id']]['children'] = array();
			}

			if ( (int) $leaf['parent_id'] === 0)
			{
				$tree_array[] = &$tree[$leaf['id']];
			}
		}

		return $tree_array;
	}
}
/* End of file adjacency_list_helper.php */
/* Location: ./helpers/adjacency_list_helper.php */
