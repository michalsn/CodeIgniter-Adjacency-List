<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Adjacency List
*
* Author: Michał Śniatała
*         michal@sniatala.pl
*         @michalsn
*
* Requirements: PHP5 or above
*
* License: MIT
*
*/

class Adjacency_list
{
    /**
    * Holds an value of adjacency max levels
    *
    * @var int
    */
    public $max_levels;

    /**
    * Holds an value of configuration for dropdown list
    *
    * @var array
    */
    public $dropdown;

    /**
    * __construct
    *
    * @return void
    */
    public function __construct()
    {
        $this->load->config('adjacency_list', TRUE);
        $this->lang->load('adjacency_list');
        $this->load->model('adjacency_list_model');

        $this->max_levels = $this->config->item('max_levels', 'adjacency_list');
        $this->dropdown = $this->config->item('dropdown', 'adjacency_list');
    }

    /**
    * __call
    *
    * Acts as a simple way to call model methods without loads of alias'
    *
    */
    public function __call($method, $arguments)
    {
        if ( ! method_exists($this->adjacency_list_model, $method))
        {
            throw new Exception('Undefined method Adjacency_list::' . $method . '() called');
        }

        return call_user_func_array(array($this->adjacency_list_model, $method), $arguments);
    }

    /**
    * __get
    *
    * Enables the use of CI super-global without having to define an extra variable.
    *
    * @access	public
    * @param	$var
    * @return	mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    /**
    * Get all items by group id or slug
    *
    * @access	public
    * @param	mixed
    * @return 	mixed
    */
    public function get_all_by_group($group = 1)
    {
        if ($query = $this->adjacency_list_model->get_all($group))
        {
            $tree = array();

            foreach ($query as $row)
            {
                $tree[$row['id']] = $row;
            }

            unset($query);

            $tree_array = array();

            foreach ($tree as $leaf)
            {
                if (array_key_exists($leaf['parent_id'], $tree))
                {
                    $tree[$leaf['parent_id']]['children'][] = &$tree[$leaf['id']];
                }

                if ( ! isset($tree[$leaf['id']]['children']))
                {
                    $tree[$leaf['id']]['children'] = array();
                }

                if ($leaf['parent_id'] == 0)
                {
                    $tree_array[] = &$tree[$leaf['id']];
                }
            }

            return $tree_array;
        }
        else
        {
            return FALSE;
        }
    }

    /**
    * Get all items from group to dropdown array
    *
    * @access  public
    * @param  mixed
    * @param  integer
    * @param  integer
    * @param  mixed
    * @return array
    */
    public function get_all_for_dropdown($group_id = 1, $exclude = 0, $level = 0, &$tree = NULL)
    {
        $output = array();

        if ($level == 0)
        {
            $tree = $this->get_all_by_group($group_id);
            $output[0] = $this->dropdown['parent'];
        }

        if (is_array($tree))
        {
            foreach ($tree as $leaf)
            {
                if ($exclude != $leaf['id'])
                {
                    $output[$leaf['id']] = str_repeat($this->dropdown['space'], $level) . ' ' . $leaf['name'];

                    if ((($this->max_levels != 0) && ($this->max_levels > $level + 1)) || ($this->max_levels == 0) || ($exclude == 0))
                    {
                        if (isset($leaf['children']) && ! empty($leaf['children']))
                        {						
                            $output += $this->get_all_for_dropdown($group_id, $exclude, $level + 1, $leaf['children']);	
                        }
                    }
                }
            }
        }

        return $output;
    }

}
 
/* End of file adjacency_list.php */
/* Location: ./application/libraries/adjacency_list.php */