<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Build admin tree
 *
 * Creates adjacency list for administration
 *
 * @access  public
 * @param   array   tree items
 * @return  string
 */
if ( ! function_exists('build_admin_tree'))
{
    function build_admin_tree(&$tree)
    {
        $output = '';

        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
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

            return $output;
        }
    }
}

/**
 * Build tree
 *
 * Creates adjacency list based on group id or slug
 *
 * @access  public
 * @param   mixed   group id or slug
 * @param   mixed   any attributes
 * @param   array   tree array
 * @return  string
 */
if ( ! function_exists('build_tree'))
{
    function build_tree($group, $attributes = array(), &$tree = NULL)
    {
        if ($tree === NULL)
        {
            $CI =& get_instance();
            $CI->load->library('adjacency_list');
            $tree = $CI->adjacency_list->get_all_by_group($group);
        }

        foreach (array('start_tag' => '<li>', 'end_tag' => '</li>', 'sub_start_tag' => '<ul>', 'sub_end_tag' => '</ul>') as $key => $val)
        {
            $atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
            unset($attributes[$key]);
        }

        $output = '';

        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
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

            return $output;
        }
    }
}