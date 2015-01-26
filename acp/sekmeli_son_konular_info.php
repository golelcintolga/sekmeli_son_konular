<?php
/**
*
* @package Sekmeli Son Konular
* @base on list top topic
* @copyright (c) 2015 Porsuk
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace tlg\sekmeli_son_konular\acp;

class sekmeli_son_konular_info
{
	function module()
	{
		return array(
			'filename'	=> '\tlg\sekmeli_son_konular\acp\sekmeli_son_konular_module',
			'title'		=> 'ACP_SSK',
			'modes'		=> array(
				'config'	=> array('title' => 'ACP_SSK_CONFIG', 'auth' => 'ext_tlg/sekmeli_son_konular && acl_a_board', 'cat' => array('ACP_SSK')),
			),
		);
	}
}
