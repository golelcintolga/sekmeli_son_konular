<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_SSK' => 'Tabbed Latest Topics',
	'ACP_SSK_CONFIG' => 'Config',
	'AYARLAR_GUNCELLENDI'=> 'Update Config',
	
	'SSK_INDEX' => 'Tabbed Latest Topics',
	'SSK_EXPLAIN' => 'Displays last topics list on the index page',
	'SSK_LOCATION'=> 'Location on forum',
	'FORUM_TOP' => 'Top of Forum',
	'FORUM_BOTTOM' => 'Bottom of Forum',
	'NUMBER_ENTRIES' => 'How Many Number Entries',
	'SSK_ENTRIES_EXPLAIN' => 'How many would you like to display.',

	'NEW_TOPICS'		=> 'Newest Posts',
	'TOP_REPLY_TOPICS'	=> 'Last Reply Topics',
	'TOP_READ_TOPIC'	=> 'Top Read Topics',
	'POPULAR_TOPICS'	=> 'Popular Topics',
	'TOP_POST_MEMBERS' => 'Top Posts Users',
	'NEWS_MEMBERS' => 'Newest Users',
	
	'TOPIC_DATE'		=> 'Date: %s',
	'TOPIC_REPLY'		=> '<strong>%s</strong> Replies',
	'TOPIC_READ'		=> '<strong>%s</strong> Read',
	'POST_AUTHOR'	=> 'by: %s',
	'USER_POST' => '<strong>%s</strong> Posts',
));