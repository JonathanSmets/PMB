<?php
// +-------------------------------------------------+
// � 2002-2012 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: frbr_entity_collections_view_collectionslist.class.php,v 1.4 2018-07-26 15:25:52 tsamson Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class frbr_entity_collections_view_collectionslist extends frbr_entity_common_view_django{
	
	
	public function __construct($id=0){
		parent::__construct($id);
		$this->default_template = "<div>
{% for collection in collections %}
<h3>{{collection.name}}</h3>
<blockquote>{{collection.comment}}</blockquote>
{% endfor %}
</div>";
	}
		
	public function render($datas){	
		//on rajoute nos �l�ments...
		//le titre
		$render_datas = array();
		$render_datas['title'] = $this->msg["frbr_entity_collections_view_collectionslist_title"];
		$render_datas['collections'] = array();
		if(is_array($datas)){
			foreach($datas as $collection_id){
				$render_datas['collections'][] = authorities_collection::get_authority('authority', 0, ['num_object' => $collection_id, 'type_object' => AUT_TABLE_COLLECTIONS]);
			}
		}
		//on rappelle le tout...
		return parent::render($render_datas);
	}
	
	public function get_format_data_structure(){		
		$format = array();
		$format[] = array(
			'var' => "title",
			'desc' => $this->msg['frbr_entity_collections_view_title']
		);
		$collections = array(
			'var' => "collections",
			'desc' => $this->msg['frbr_entity_collections_view_collections_desc'],
			'children' => authority::get_properties(AUT_TABLE_COLLECTIONS,"collections[i]")
		);
		$format[] = $collections;
		$format = array_merge($format,parent::get_format_data_structure());
		return $format;
	}
}