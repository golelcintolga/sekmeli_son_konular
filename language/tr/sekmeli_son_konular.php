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
	'ACP_SSK' => 'Sekmeli Son Konular',
	'ACP_SSK_CONFIG' => 'Ayarlar',
	'AYARLAR_GUNCELLENDI'=> 'Ayarlar Güncellendi',
	
	'SSK_INDEX' => 'Sekmeli Son Konular',
	'SSK_EXPLAIN' => 'Anasayfa da son konuları listeler',
	'SSK_LOCATION'=> 'Gösterilecek Konum',
	'FORUM_TOP' => 'Forumun Üstünde',
	'FORUM_BOTTOM' => 'Forumun Altında',
	'NUMBER_ENTRIES' => 'Gösterilecek girdi sayısı',
	'SSK_ENTRIES_EXPLAIN' => 'Listede gösterilecek konu sayısını giriniz.',

	'NEW_TOPICS'		=> 'Yeni Mesajlar',
	'TOP_REPLY_TOPICS'	=> 'Cevaplanan Son Konular',
	'TOP_READ_TOPIC'	=> 'En Çok Okunan Konular',
	'POPULAR_TOPICS'	=> 'En Çok Cevaplanan Konular',
	'TOP_POST_MEMBERS' => 'En Çok Mesaj Yazanlar',
	'NEWS_MEMBERS' => 'Yeni Üyeler',
	
	'TOPIC_DATE'		=> 'Tarih: %s',
	'TOPIC_REPLY'		=> '<strong>%s</strong> Kez cevap yazıldı',
	'TOPIC_READ'		=> '<strong>%s</strong> Kez okundu',
	'POST_AUTHOR'	=> 'Gönderen: %s',
	'USER_POST' => '<strong>%s</strong> Mesajı var',
));