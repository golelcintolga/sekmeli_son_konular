<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sekmeli_son_konular\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var \tlg\sekmeli_son_konular\core\sekmeli_son_konular */
	protected $ssk_functions;
	
	/** @var \phpbb\config\config */
	protected $config;
	
	/** @var \phpbb\template\template */
	protected $template;

	public function __construct(\tlg\sekmeli_son_konular\core\sekmeli_son_konular $functions, \phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->ssk_functions = $functions;
		$this->config = $config;
		$this->template = $template;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title' => 'ssk_index',
			'core.user_setup' => 'load_language_on_setup',
		);
	}
	
	public function ssk_index($event)
	{
		if (!$this->config['ssk_index']){ return; }
		$this->ssk_functions->ssk_last_topic('last_topic', true);
		$this->ssk_functions->ssk_lastrplytopic('last_rplytopic', true);
		$this->ssk_functions->ssk_top_read('top_read', true);
		$this->ssk_functions->ssk_top_reply('top_reply', true);
		$this->ssk_functions->ssk_top_post('top_post', true);
		$this->ssk_functions->ssk_new_user('newuser', true);
		
		$this->template->assign_vars(array(
			'S_SSK_DISPLAY'	=>	$this->config['ssk_index'],
			'S_SSK_LOCATION'	=> $this->config['ssk_location'],
		));
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'tlg/sekmeli_son_konular',
			'lang_set' => 'sekmeli_son_konular',
		);
		$event['lang_set_ext'] = $lang_set_ext;		
	}
	
}