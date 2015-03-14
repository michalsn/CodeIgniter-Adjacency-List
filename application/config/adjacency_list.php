<?php 
/**
 * Adjacency List
 *
 * @package Config
 * @author  Michał Śniatała <michal@sniatala.pl>
 * @license http://opensource.org/licenses/MIT  (MIT)
 * @since   Version 0.1
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//-------------------------------------------------------------------------
// Tables.
//-------------------------------------------------------------------------
// Database table names.
//
	$config['tables']['lists']  = 'adjacency_lists';
	$config['tables']['groups'] = 'adjacency_groups';


//-------------------------------------------------------------------------
// Max levels.
//-------------------------------------------------------------------------
// Max number of levels in list. Set 0 for unlimited levels.
//
	$config['max_levels'] = 0;


//-------------------------------------------------------------------------
// Dropdown parent name.
//-------------------------------------------------------------------------
// First name in dropdown.
//
	$config['dropdown']['parent'] = '--- None ---';


//-------------------------------------------------------------------------
// Dropdown space.
//-------------------------------------------------------------------------
// Space between levels in dropdown.
//
	$config['dropdown']['space'] = '&nbsp;&nbsp;&nbsp;';


//-------------------------------------------------------------------------
// Flash names.
//-------------------------------------------------------------------------
// Names for flash success and error.
//
	$config['flash']['success'] = 'success';
	$config['flash']['error']   = 'error';


/* End of file adjacency_list.php */
/* Location: ./config/adjacency_list.php */