<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Adjacency List
 *
 * @package Model
 * @author  Michał Śniatała <michal@sniatala.pl>
 * @license http://opensource.org/licenses/MIT  (MIT)
 * @since   Version 0.1
 */
class Adjacency_list_model extends CI_Model 
{
	/**
	 * Holds an array of used tables.
	 *
	 * @var string
	 */
	public $tables = array();

	/**
	 * Holds an array of used flash names.
	 *
	 * @var string
	 */
	public $flash = array();

	//--------------------------------------------------------------------

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->config('adjacency_list', TRUE);
		$this->lang->load('adjacency_list');

		$this->tables = $this->config->item('tables', 'adjacency_list');
		$this->flash  = $this->config->item('flash', 'adjacency_list');		
	}

	//--------------------------------------------------------------------

	/**
	 * get_all
	 *
	 * @param mixed $group Group name or id
	 *
	 * @return  array
	 */
	public function get_all($group)
	{
		if ( ! is_numeric($group))
		{
			$group = $this->db->where('slug', $group)->get($this->tables['groups'])->row()->id;
		}

		return $this->db->where('group_id', $group)->order_by('position', 'asc')->get($this->tables['lists'])->result_array();
	}

	//--------------------------------------------------------------------
	
	/**
	 * get_item
	 *
	 * @param int $item_id Item id
	 *
	 * @return array
	 */
	public function get_item($item_id)
	{
		return $this->db->where('id', $item_id)->get($this->tables['lists'])->row_array();
	}

	//--------------------------------------------------------------------

	/**
	 * add_item
	 *
	 * @param array $data Data array
	 *
	 * @return bool
	 */
	public function add_item($data)
	{
		$this->db->insert($this->tables['lists'], $data);
		if ($this->db->affected_rows())
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_add_item_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_add_item_error'));
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * update_item
	 *
	 * @param int   $item_id Item id
	 * @param array $data    Data array
	 *
	 * @return bool
	 */
	public function update_item($item_id, $data)
	{
		$return = $this->db->where('id', $item_id)->update($this->tables['lists'], $data);
		if ($return)
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_update_item_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_update_item_error'));
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * delete_item
	 *
	 * @param int $item_id Item id
	 *
	 * @return bool
	 */
	public function delete_item($item_id)
	{
		$this->db->where('id', $item_id)->delete($this->tables['lists']);
		if ($this->db->affected_rows())
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_delete_item_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_delete_item_error'));
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * has_children
	 *
	 * @param int $item_id Item id
	 *
	 * @return bool
	 */
	public function has_children($item_id)
	{
		if ($this->db->where('parent_id', $item_id)->count_all_results($this->tables['lists']) > 0)
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_has_children_error'));
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * reorder
	 *
	 * @param array $list Array list
	 *
	 * @return bool
	 */
	public function reorder($list)
	{
		$position = 1;

		$this->db->trans_start();
		foreach ($list as $id => $parent_id)
		{
			$this->db->where('id', $id)->set('parent_id', $parent_id)->set('position', $position)->update($this->tables['lists']);
			$position++;
		}
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	//--------------------------------------------------------------------

	// Adjacency groups //

	//--------------------------------------------------------------------

	/**
	 * get_all_groups
	 *
	 * @return array
	 */
	public function get_all_groups()
	{
		return $this->db->order_by('id', 'asc')->get($this->tables['groups'])->result_array();
	}

	//--------------------------------------------------------------------

	/**
	 * add_group
	 *
	 * @param array $data Data array
	 *
	 * @return bool
	 */
	public function add_group($data)
	{
		$data['slug'] = url_title($data['name'], '-', TRUE);
		$this->db->insert($this->tables['groups'], $data);
		if ($this->db->affected_rows())
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_add_group_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_add_group_error'));
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * get_group
	 *
	 * @param int $item_id Item id
	 *
	 * @return array
	 */
	public function get_group($item_id)
	{
		return $this->db->where('id', $item_id)->get($this->tables['groups'])->row_array();
	}

	//--------------------------------------------------------------------

	/**
	 * update_group
	 *
	 * @param int   $item_id Item id
	 * @param array $data    Data array
	 *
	 * @return bool
	 */
	public function update_group($item_id, $data)
	{
		$data['slug'] = url_title($data['name'], '-', TRUE);
		$return = $this->db->where('id', $item_id)->update($this->tables['groups'], $data);
		if ($return)
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_update_group_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_update_group_error'));
			return FALSE;
		}
	}

	//--------------------------------------------------------------------

	/**
	 * delete_group
	 *
	 * @param int $item_id Item id
	 *
	 * @return bool
	 */
	public function delete_group($item_id)
	{
		$this->db->trans_start();

		$this->db->where('id', $item_id)->delete($this->tables['groups']);
		$ar = $this->db->affected_rows();

		if ($ar)
		{
			$this->db->where('group_id', $item_id)->delete($this->tables['lists']);
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() ? $ar : FALSE)
		{
			$this->session->set_flashdata($this->flash['success'], $this->lang->line('al_delete_group_success'));
			return TRUE;
		}
		else
		{
			$this->session->set_flashdata($this->flash['error'], $this->lang->line('al_delete_group_error'));
			return FALSE;
		}
	}
}
/* End of file adjacency_list_model.php */
/* Location: ./models/adjacency_list_model.php */
