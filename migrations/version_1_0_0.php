<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sekmeli_son_konular\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('ssk_index', '1')),
			array('config.add', array('ssk_lasttopic', '1')),
			array('config.add', array('ssk_lastrplytopic', '1')),
			array('config.add', array('ssk_topread', '1')),
			array('config.add', array('ssk_topreply', '1')),
			array('config.add', array('ssk_topuserpost', '1')),
			array('config.add', array('ssk_newuser', '1')),
			array('config.add', array('ssk_counter', '5')),
			array('config.add', array('ssk_location', '0')),
			array('config.add', array('ssk_wordlimit', '50')),
			array('config.add', array('ssk_cache', '300')),
			// Add the ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_SSK')),
			array('module.add', array(
				'acp', 'ACP_SSK', array(
					'module_basename'	=> '\tlg\sekmeli_son_konular\acp\sekmeli_son_konular_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}
