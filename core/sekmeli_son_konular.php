<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sekmeli_son_konular\core;

class sekmeli_son_konular
{
	protected $auth;
	protected $config;
	protected $cache;
	protected $template;
	protected $user;
	protected $db;
	protected $root_path;
	protected $phpEx;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\template\twig\twig $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->config			= $config;
		$this->cache = $cache;
		$this->template			= $template;
		$this->user				= $user;
		$this->db				= $db;
		$this->root_path		= $root_path;
		$this->phpEx			= $php_ext;
		
	}

//Yeni konular baslar.
	public function ssk_last_topic($tpl_loopname = 'last_topic'){
	if (!isset($this->config['ssk_lasttopic']) || !$this->config['ssk_lasttopic']){return;}
		$number = 1;
		$limit = $this->config['ssk_wordlimit'];
		$forum_ary = array_unique(array_merge(array_keys($this->auth->acl_getf('!f_read', true)), array_keys($this->auth->acl_getf('!f_list', true))));
		$izin = '';
		if (sizeof($forum_ary))
		{
		$izin = ' AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true);
		}	
		if (($last_topic = $this->cache->get('_ssklasttopic')) === false)
		{
		$last_topic = array();
		
		
		$sql = 'SELECT topic_id, forum_id, topic_title, topic_time, topic_poster, topic_first_poster_name, topic_first_poster_colour
				FROM ' . TOPICS_TABLE . '
				WHERE topic_posts_approved = 1 '.$izin.'
				ORDER BY topic_time  DESC';
		$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
		while ($row = $this->db->sql_fetchrow($result)) {
			
			$text = $row['topic_title'];
			$text_count = utf8_strlen($text);
			if($text_count > $limit){
				$new_text = utf8_substr($text, 0, $limit).'...';
			}else{
				$new_text = $text;
			}
		
			$last_topic[$row['topic_id']] = array(
				'topic_id' => $row['topic_id'],
				'forum_id' => $row['forum_id'],
				'topic_title' => $new_text,
				'topic_alt_title' => $row['topic_title'],
				'topic_time' => $row['topic_time'],
				'topic_poster' => $row['topic_poster'],
				'topic_first_poster_name' => $row['topic_first_poster_name'],
				'topic_first_poster_colour' => $row['topic_first_poster_colour'],
			);
		}$this->db->sql_freeresult($result);
			// cache 5 minutes
			$this->cache->put('_ssklasttopic', $last_topic, $this->config['ssk_cache']);
		}
			foreach ($last_topic as $row)
			{
				$this->template->assign_block_vars('new_topic',array(
					'NUMBER'=>$number,
					'U_VIEW_TOPIC'	=> append_sid("{$this->root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
					'TOPIC_TITLE'	=> censor_text($row['topic_title']),
					'TOPIC_ALT_TITLE'	=> censor_text($row['topic_alt_title']),
					'TOPIC_TIME'	=> sprintf($this->user->lang['TOPIC_DATE'], $this->user->format_date($row['topic_time'])),
					'USER_NAME'	=> sprintf($this->user->lang['POST_AUTHOR'],get_username_string('no_profile', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour'])),
				));
			$number++;
			}
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
//Yeni konular biter.
	
//Son cevaplanan konular baslar.
	function ssk_lastrplytopic($tpl_loopname = 'last_rplytopic'){
		if (!isset($this->config['ssk_lastrplytopic']) || !$this->config['ssk_lastrplytopic']){return;}
		$number = 1;
		$limit = $this->config['ssk_wordlimit'];
		$forum_ary = array_unique(array_merge(array_keys($this->auth->acl_getf('!f_read', true)), array_keys($this->auth->acl_getf('!f_list', true))));
		$izin = '';
		if (sizeof($forum_ary))
		{
		$izin = ' AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true);
		}
			
		if (($last_rply_topic = $this->cache->get('_ssklastrplytopic')) === false)
		{
			$last_rply_topic = array();
		$sql = 'SELECT topic_id, forum_id, topic_title, topic_last_post_id, topic_last_post_time, topic_posts_approved, topic_last_poster_id, topic_last_poster_name, topic_last_poster_colour
				FROM ' . TOPICS_TABLE . '
				WHERE  topic_posts_approved > 1 '.$izin.'
				ORDER BY topic_last_post_time  DESC';
		$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
		while ($row = $this->db->sql_fetchrow($result)) {
			
			$text = $row['topic_title'];
			$text_count = utf8_strlen($text);
			if($text_count > $limit){
				$new_text = utf8_substr($text, 0, $limit).'...';
			}else{
				$new_text = $text;
			}
			
			$last_rply_topic[$row['topic_id']] = array(
				'topic_id' => $row['topic_id'],
				'forum_id' => $row['forum_id'],
				'topic_title' => $new_text,
				'topic_alt_title' => $row['topic_title'],
				'topic_last_post_id' => $row['topic_last_post_id'],
				'topic_last_post_time' => $row['topic_last_post_time'],
				'topic_last_poster_id' => $row['topic_last_poster_id'],
				'topic_last_poster_name' => $row['topic_last_poster_name'],
				'topic_last_poster_colour' => $row['topic_last_poster_colour'],
			);		
		}$this->db->sql_freeresult($result);
			// cache 5 minutes
			$this->cache->put('_ssklastrplytopic', $last_rply_topic, $this->config['ssk_cache']);
		}
			foreach ($last_rply_topic as $row)
			{
				$this->template->assign_block_vars('reply_topic',array(
				'NUMBER'=>$number,
				'U_VIEW_TOPIC'	=> append_sid("{$this->root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']) . '#p' . $row['topic_last_post_id'],
				'TOPIC_TITLE'	=> censor_text($row['topic_title']),
				'TOPIC_ALT_TITLE'	=> censor_text($row['topic_alt_title']),
				'TOPIC_TIME'	=> sprintf($this->user->lang['TOPIC_DATE'], $this->user->format_date($row['topic_last_post_time'])),
				'USER_NAME'	=> sprintf($this->user->lang['POST_AUTHOR'],get_username_string('no_profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour'])),
				));
				$number++;
			}		
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
//Son cevaplanan konular biter.	
	
//En cok okunan konular baslar.
	function ssk_top_read($tpl_loopname = 'top_read'){
	if (!isset($this->config['ssk_topread']) || !$this->config['ssk_topread']){return;}
$limit = $this->config['ssk_wordlimit'];
		$forum_ary = array_unique(array_merge(array_keys($this->auth->acl_getf('!f_read', true)), array_keys($this->auth->acl_getf('!f_list', true))));
		$izin = '';
		if (sizeof($forum_ary))
		{
		$izin = ' AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true);
		}
		$number = 1;
		if (($top_read = $this->cache->get('_ssktopread')) === false)
		{
		$top_read = array();
		$sql = 'SELECT topic_id, forum_id, topic_title, topic_views
				FROM ' . TOPICS_TABLE . '
				WHERE topic_posts_approved >= 1 '.$izin.'
				ORDER BY topic_views  DESC';
		$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
		while ($row = $this->db->sql_fetchrow($result)) {
			
			$text = $row['topic_title'];
			$text_count = utf8_strlen($text);
			if($text_count > $limit){
				$new_text = utf8_substr($text, 0, $limit).'...';
			}else{
				$new_text = $text;
			}
			
			$top_read[$row['topic_id']] = array(
				'topic_id' => $row['topic_id'],
				'forum_id' => $row['forum_id'],
				'topic_title' => $new_text,
				'topic_alt_title' => $row['topic_title'],
				'topic_views' => $row['topic_views'],
			);
		}$this->db->sql_freeresult($result);
		// cache 5 minutes
		$this->cache->put('_ssktopread', $top_read, $this->config['ssk_cache']);
		}
		foreach ($top_read as $row)
		{
			$this->template->assign_block_vars('read_topic',array(
				'NUMBER'=>$number,
				'U_VIEW_TOPIC'	=> append_sid("{$this->root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
				'TOPIC_TITLE'	=> censor_text($row['topic_title']),
				'TOPIC_ALT_TITLE'	=> censor_text($row['topic_alt_title']),
				'TOPIC_READY'	=> sprintf($this->user->lang['TOPIC_READ'], $row['topic_views']),
			));
			$number++;
		}		
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
//En cok okunan konular biter.	
	
//Popüler konular baslar.
	function ssk_top_reply($tpl_loopname = 'top_reply'){
	if (!isset($this->config['ssk_topreply']) || !$this->config['ssk_topreply'] ){return;}
		if (!isset($this->config['hot_threshold']) || !$this->config['hot_threshold'] ){return;}
		$number = 1;
		$limit = $this->config['ssk_wordlimit'];
		$forum_ary = array_unique(array_merge(array_keys($this->auth->acl_getf('!f_read', true)), array_keys($this->auth->acl_getf('!f_list', true))));
		$izin = '';
		if (sizeof($forum_ary))
		{
		$izin = ' AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true);
		}	

	$pop = $this->config['hot_threshold'];
		if (($top_reply = $this->cache->get('_ssktopreply')) === false)
		{
	$top_reply = array();		
	$sql = 'SELECT topic_id, forum_id, topic_title, topic_views, topic_last_post_time, topic_posts_approved
			FROM ' . TOPICS_TABLE . "
			WHERE topic_posts_approved >= $pop".$izin.'
			ORDER BY topic_posts_approved DESC';
	$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
	while ($row = $this->db->sql_fetchrow($result)) {
				
			$text = $row['topic_title'];
			$text_count = utf8_strlen($text);
			if($text_count > $limit){
				$new_text = utf8_substr($text, 0, $limit).'...';
			}else{
				$new_text = $text;
			}
				
				$top_reply[$row['topic_id']] = array(
					'topic_id' => $row['topic_id'],
					'forum_id' => $row['forum_id'],
					'topic_title' => $new_text,
					'topic_alt_title' => $row['topic_title'],
					'topic_views' => $row['topic_views'],
					'topic_last_post_time' => $row['topic_last_post_time'],
					'topic_posts_approved' => $row['topic_posts_approved'],
				);
	}$this->db->sql_freeresult($result);
			// cache 5 minutes
			$this->cache->put('_ssktopreply', $top_reply, $this->config['ssk_cache']);
		}
		foreach ($top_reply as $row)
		{
			$pop_topic = $row['topic_posts_approved']-1;
			$this->template->assign_block_vars('pop_topic',array(
			'NUMBER'=>$number,
			'U_VIEW_TOPIC'	=> append_sid("{$this->root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
			'TOPIC_TITLE'	=> censor_text($row['topic_title']),
			'TOPIC_ALT_TITLE'	=> censor_text($row['topic_alt_title']),
			'TOPIC_REPLY'	=> sprintf($this->user->lang['TOPIC_REPLY'], $pop_topic),
			));
			$number++;
		}		
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
//Popüler konular biter.

//en çok mesaj yazanlar baslar.
	function ssk_top_post($tpl_loopname = 'top_post'){
	if (!isset($this->config['ssk_topuserpost']) || !$this->config['ssk_topuserpost']){return;}
		$number = 1;
		if (($top_post = $this->cache->get('_ssktopuserpost')) === false)
		{
			$top_post = array();
			$sql = 'SELECT user_id,username,user_posts,user_colour
				FROM ' . USERS_TABLE . '
				WHERE user_posts > 0
				ORDER BY user_posts DESC';
			$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
			while ($row = $this->db->sql_fetchrow($result)) {
				$top_post[$row['user_id']] = array(
					'user_id' => $row['user_id'],
					'username' => $row['username'],
					'user_colour' => $row['user_colour'],
					'user_posts' => $row['user_posts'],
				);
			}$this->db->sql_freeresult($result);
			// cache 5 minutes
			$this->cache->put('_ssktopuserpost', $top_post, $this->config['ssk_cache']);
		}
		foreach ($top_post as $row)
		{
			$this->template->assign_block_vars('user_post',array(
			'NUMBER'=>$number,
			'USER_NAME'	=> get_username_string('full',$row['user_id'],$row['username'],$row['user_colour']),
			'POST'	=> sprintf($this->user->lang['USER_POST'], $row['user_posts']),
			));
			$number++;
		}		
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
	//en çok mesaj yazanlar biter.	

	//en son üye olanlar baslar.
	function ssk_new_user($tpl_loopname = 'newuser'){
	if (!isset($this->config['ssk_newuser']) || !$this->config['ssk_newuser']){return;}
		$number = 1;
		if (($new_user = $this->cache->get('_ssknewuser')) === false)
		{
		$new_user = array();
		$sql = 'SELECT user_id, user_type, user_regdate, username, user_colour
					FROM ' . USERS_TABLE . '
					WHERE user_type != 2
					ORDER BY user_regdate DESC';
			$result = $this->db->sql_query_limit($sql, $this->config['ssk_counter']);
			while ($row = $this->db->sql_fetchrow($result)) {
				$new_user[$row['user_id']] = array(
					'user_id' => $row['user_id'],
					'username' => $row['username'],
					'user_colour' => $row['user_colour'],
					'user_regdate' => $row['user_regdate'],
				);
			}$this->db->sql_freeresult($result);
			// cache 5 minutes
			$this->cache->put('_ssknewuser', $new_user, $this->config['ssk_cache']);
		}
		foreach ($new_user as $row)
		{
			$this->template->assign_block_vars('last_member',array(
				'NUMBER'=>$number,
				'USER_NAME'	=> get_username_string('full',$row['user_id'],$row['username'],$row['user_colour']),
				'USER_REGDATE'	=>$this->user->format_date($row['user_regdate']),
			));
		$number++;
		}		
		$this->template->assign_vars(array(
		strtoupper($tpl_loopname) . '_DISPLAY' => true,
		));
	}
	//en son üye olanlar biter.
}