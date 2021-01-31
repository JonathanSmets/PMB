<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: vedette_subcollections_ui.class.php,v 1.5 2019-07-11 14:17:15 btafforeau Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($include_path."/templates/vedette/vedette_subcollections.tpl.php");

class vedette_subcollections_ui extends vedette_element_ui{

	
	/**
	 * Boite de s�lection de l'�l�ment
	 *
	 * @return string
	 * @access public
	 */
	public static function get_form($params = array()){
		global $vedette_subcollections_tpl;
		return $vedette_subcollections_tpl["vedette_subcollections_selector"];
	}
	
	
	/**
	 * Renvoie le code javascript pour la cr�ation du s�l�cteur
	 *
	 * @return string
	 */
	public static function get_create_box_js($params = array()){
		global $vedette_subcollections_tpl;
		if(!in_array('vedette_subcollections_script', parent::$created_boxes)){
			parent::$created_boxes[] = 'vedette_subcollections_script';
			return $vedette_subcollections_tpl["vedette_subcollections_script"];
		}
		return '';
	}
	
	/**
	 * Renvoie les donn�es (id objet, type)
	 *
	 * @return void
	 * @access public
	 */
	public static function get_from_form($params = array()){
	
	}

}
