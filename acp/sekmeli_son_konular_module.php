<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
namespace tlg\sekmeli_son_konular\acp;

class sekmeli_son_konular_module
{

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $cache;
		global $phpbb_root_path, $phpbb_admin_path;

		add_form_key('acp_ssk');

		$this->page_title = 'ACP_SSK';
		$this->tpl_name = 'sekmeli_son_konular';

	  	$submit 	= (isset($_POST['submit'])) ? true : false;
		if ($submit)
		{
			if (!check_form_key('acp_ssk'))
			{
				trigger_error('FORM_INVALID');
			}
			set_config('ssk_index', request_var('ssk_index', 1));
			set_config('ssk_lasttopic', request_var('ssk_lasttopic', 1));
			set_config('ssk_lastrplytopic', request_var('ssk_lastrplytopic', 1));
			set_config('ssk_topread', request_var('ssk_topread', 1));
			set_config('ssk_topreply', request_var('ssk_topreply', 1));
			set_config('ssk_topuserpost', request_var('ssk_topuserpost', 1));
			set_config('ssk_newuser', request_var('ssk_newuser', 1));
			set_config('ssk_counter', request_var('ssk_counter', 5));
			set_config('ssk_location', request_var('ssk_location', 0));
			set_config('ssk_wordlimit', request_var('ssk_wordlimit', 50));
			set_config('ssk_cache', request_var('ssk_cache', 300));
			
			$cache->destroy('_ssk_last_topic');
			$cache->destroy('_ssk_last_rplytopic');
			$cache->destroy('_ssk_top_read');
			$cache->destroy('_ssk_top_reply');
			$cache->destroy('_ssk_top_user_post');
			$cache->destroy('_ssk_new_user');
		
			trigger_error($user->lang['UPDATE_CONFIG'] . adm_back_link($this->u_action));
		}
		$template->assign_vars(array(
			'SSK_INDEX'				=> $config['ssk_index'],
			'SSK_LASTTOPIC'		=> $config['ssk_lasttopic'],
			'SSK_LASTRPLYTOPIC'=> $config['ssk_lastrplytopic'],
			'SSK_TOPREAD'			=> $config['ssk_topread'],
			'SSK_TOPREPLY'		=> $config['ssk_topreply'],
			'SSK_TOPUSERPOST'	=> $config['ssk_topuserpost'],
			'SSK_NEWUSER'		=> $config['ssk_newuser'],
			'SSK_COUNTER'			=> $config['ssk_counter'],
			'SSK_LOCATION'		=> $config['ssk_location'],
			'SSK_WORDLIMIT'		=> $config['ssk_wordlimit'],
			'SSK_CACHE'				=> $config['ssk_cache'],
		));
	}
}