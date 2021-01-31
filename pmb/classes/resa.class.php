<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: resa.class.php,v 1.44.4.1 2019-10-31 14:41:32 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

// classe emprunteur
// classe remani�e le 7.12.2003. : prise en compte de r�sas sur le bulletinage

if (!defined('RESA_CLASS')) {
 	define('RESA_CLASS', 1);

	require_once("$class_path/quotas.class.php");
	
	class reservation {
	
		//---------------------------------------------------------
		//			Propri�t�s
		//---------------------------------------------------------
		public $id				= 0	;		// id MySQL de la r�servation
		public $id_empr			= 0	;		// id MySQL emprunteur
		public $id_notice		= 0	;		// id notice
		public $id_bulletin		= 0	;		// id bulletin si applicable
		public $date			= '';
		public $formatted_date 	= '';
		public $date_debut		= '';
		public $formatted_date_debut 	= '';
		public $date_fin		= '';
		public $formatted_date_fin 		= '';
		public $confirmee		= 0;
		public $loc_retrait		= 0;
		public $tstamp			= '';		// time stamp de la r�servation
		public $message			= '';		// message d'erreur �ventuel
		public $statut			= 0	;		// statuts possibles
		public $notice			= '';		// notice abr�g�e (pour affichage)
		public $force 			= 0; 		// Forcage de la notice en cas de d�passement de quota de r�servation
		public $expl_cb		= ''; 
		public $expl_id		= 0;
		public $resa_pnb_flag = 0;
		protected $exemplaire;
		protected $on_empr_fiche = false;
		/* note les statuts possibles :
		0	->	aucun probl�me pour r�server
		1	->	aucun exemplaire ne peut �tre reserv�
		2	->	un ou des exemplaires peuvent �tre reserv�s et un au moins des exemplaires est disponible
		*/
		
		//---------------------------------------------------------
		//			M�thodes
		//---------------------------------------------------------
		
		// <----------------- constructeur ------------------>
		public function __construct($id_empr=0, $id_notice=0, $bulletinage=0, $cb='') {
			$this->id_empr = $id_empr+0;
			$this->id_notice = $id_notice+0;
			$this->service = new stdClass();
			if($bulletinage) {
				$this->id_bulletin = $bulletinage;
				$this->id_notice = 0;
			}
			$this->fetch_data();
			if($cb) {
				$query = "select expl_id,expl_notice,expl_bulletin from exemplaires where expl_cb='$cb' limit 1";
				$result = pmb_mysql_query($query);
				if (($expl = pmb_mysql_fetch_object($result))) {
					$this->id_notice = $expl->expl_notice;
					$this->id_bulletin = $expl->expl_bulletin;
					$this->expl_id = $expl->expl_id;
					$this->expl_cb = $cb;
				} else {
					$this->id_bulletin = 0;
					$this->id_notice = 0;
					$this->expl_cb = '0';
				}
			}
		}
		
		protected function fetch_data() {
			if($this->id_empr && ($this->id_notice || $this->id_bulletin)) {
				$query = "select * from resa where resa_idempr = ".$this->id_empr." AND resa_idnotice = ".$this->id_notice." AND resa_idbulletin = ".$this->id_bulletin;
				$result = pmb_mysql_query($query);
				if($query && pmb_mysql_num_rows($result)) {
					$row = pmb_mysql_fetch_object($result);
					$this->id = $row->id_resa;
					$this->date = $row->resa_date;
					$this->formatted_date = format_date($this->date);
					$this->date_debut = $row->resa_date_debut;
					$this->formatted_date_debut = format_date($this->date_debut);
					$this->date_fin = $row->resa_date_fin;
					$this->formatted_date_fin = format_date($this->date_fin);
					$this->confirmee = $row->resa_confirmee;
					$this->loc_retrait = $row->resa_loc_retrait;
					$this->resa_pnb_flag = $row->resa_pnb_flag;
				}
			}
		}
		
		public function get_empr_info() {
			$query = "select resa_idempr as empr, id_resa, resa_cb, concat(ifnull(concat(empr_nom,' '),''),empr_prenom) as nom_prenom, empr_cb 
			from resa left join empr on resa_idempr=id_empr where resa_idnotice='".$this->id_notice."' and resa_idbulletin='".$this->id_bulletin."' order by resa_date limit 1";
			$result = pmb_mysql_query($query);
			if (pmb_mysql_num_rows($result)) {
				if(($row=pmb_mysql_fetch_object($result))) {
					$link="<a href=\"./circ.php?categ=pret&form_cb=".$row->empr_cb."\">".$row->nom_prenom."</a>";
					return $link;
				}
			}
			return '';
		}
		public function get_empr_info_cb() {
			$query = "select resa_idempr as empr, id_resa, resa_cb, concat(ifnull(concat(empr_nom,' '),''),empr_prenom) as nom_prenom, empr_cb 
			from resa, empr where resa_cb='".$this->expl_cb."' and resa_idempr=id_empr limit 1";
			$result = pmb_mysql_query($query);
			if (pmb_mysql_num_rows($result)) {
				if(($row=pmb_mysql_fetch_object($result))) {
					$link="<a href=\"./circ.php?categ=pret&form_cb=".$row->empr_cb."\">".$row->nom_prenom."</a>";
					return $link;
				}
			}
			return '';
		}
		
		public static function check_expl_reservable($id_expl) {
			$id_expl += 0;
			$query = "select e.expl_cb as cb, e.expl_id as id, s.pret_flag as pretable, e.expl_notice as notice, e.expl_bulletin as bulletin, e.expl_note as note, expl_comment, s.statut_libelle as statut";
			$query .= " from exemplaires e, docs_statut s";
			$query .= " where e.expl_id=$id_expl";
			$query .= " and s.idstatut=e.expl_statut";
			$query .= " limit 1";
	
			$result = pmb_mysql_query($query);
			if (($expl = pmb_mysql_fetch_array($result))) {
				if (!$expl['pretable']) {
					// l'exemplaire est en consultation sur place
					return 0;
				}
			} else {
				// exemplaire inconnu
				return 0;
			}
			// on check si l'exemplaire est d�j� en pr�t
			$query = "select pret_idempr from pret where pret_idexpl=$id_expl limit 1";
			$result = pmb_mysql_query($query);
			if (@ pmb_mysql_num_rows($result)) {
				// l'exemplaire est d�j� en pr�t
				return 0;
			}	
			// on check si l'exemplaire a une r�servation
			$query = "select resa_idempr as empr, id_resa, resa_cb, concat(ifnull(concat(empr_nom,' '),''),empr_prenom) as nom_prenom, empr_cb from resa left join empr on resa_idempr=id_empr where resa_idnotice='$expl->notice' and resa_idbulletin='$expl->bulletin' order by resa_date limit 1";
			$result = pmb_mysql_query($query);
			if (pmb_mysql_num_rows($result)) {
				// l'exemplaire a une r�servation
				return 0;
				
			}
			// l'exemplaire est disponible pour valider une r�servation
			return 1;
		}
		
		public function get_query_expl_lendable() {
			global $pmb_location_reservation;
			
			$query = "select expl_id ,expl_cb from exemplaires e, docs_statut s
				where s.idstatut=e.expl_statut and s.statut_allow_resa=1";
			$query .= " and ".$this->get_restrict_expl_notice_query();
			if($pmb_location_reservation) {
				$query_loc = "select empr_location from empr where id_empr=".$this->id_empr;
				$res = pmb_mysql_query($query_loc);
				$empr = pmb_mysql_fetch_object($res);
				$query.=" and e.expl_location in (select resa_loc from resa_loc where resa_emprloc=".$empr->empr_location.") ";
			}
			return $query;
		}
		
		public function check_localisation_expl() {
			global $msg, $pmb_transferts_actif, $transferts_choix_lieu_opac;
			// recup de la localisation de l'emprunteur
			$query = "select empr_location from empr where id_empr=".$this->id_empr;
			$res = pmb_mysql_query($query);
			$empr = pmb_mysql_fetch_object($res);
			$empr_location=$empr->empr_location;
			
			if($this->id_notice) $field_expl= " expl_notice=$this->id_notice ";
			else $field_expl= " expl_bulletin=$this->id_bulletin ";
			// v�rifier si un exemplaire est disponible dans les localisation autoris�es
			
			if ($pmb_transferts_actif && $transferts_choix_lieu_opac !=3) {
				$transf_possible=" and (s.transfert_flag=1 or expl_location=$empr_location )";
				$requete="select expl_id from exemplaires e ,docs_statut s
				where  $field_expl and  expl_location in (select resa_loc  from resa_loc where resa_emprloc=$empr_location )
				and s.idstatut=e.expl_statut and s.statut_allow_resa=1 $transf_possible limit 1";
				
				$res = pmb_mysql_query($requete);	
				if(pmb_mysql_num_rows($res)) {
					return TRUE;							
				}	
				$this->message = "<strong>".$msg["resa_no_expl_in_location_transferable"]."</strong>";				
			}else{			
				$requete="select expl_id from exemplaires e ,docs_statut s
				where  $field_expl and  expl_location in (select resa_loc  from resa_loc where resa_emprloc=$empr_location )
				and s.idstatut=e.expl_statut and s.statut_allow_resa=1 limit 1";
				
				$res = pmb_mysql_query($requete);	
				if(pmb_mysql_num_rows($res)) {
					return TRUE;							
				}			
				// recup de la liste des localisations ou l'emprunteur peut r�server un exemplaire
				$requete="select location_libelle from resa_loc, docs_location  where resa_emprloc=$empr_location and idlocation=resa_loc";
				$res = pmb_mysql_query($requete);	
				$locations="";
				if(pmb_mysql_num_rows($res)) {
					while(($row=pmb_mysql_fetch_object($res))) {
						if($locations) $locations.=", ";
						$locations.=$row->location_libelle;				
					}
				}
				$this->message = "<strong>".str_replace("!!loc_liste!!",$locations,$msg["resa_no_expl_in_location"])."</strong>";
			}	
			return FALSE;
		}
		
		public function can_reserve() {
			global $msg;
			global $quota_resa;
			global $pmb_transferts_actif, $transferts_choix_lieu_opac,$pmb_location_reservation;
			
			$this->service->error="";
			if (!$this->empr_exists() ){
				$this->service->error="check_empr_exists";
				return FALSE;
			}		
			if(!$this->notice_exists() ){
				$this->service->error="check_notice_exists";
				return FALSE;
			}			
			
			//les quotas
			if (!$quota_resa) {
				//Si un quota atteint (check_quota inclu le message + la mise � 0 ou 1 de $this->force)
				$ret=$this->check_quota();
				if ($ret["ERROR"]) {
					$this->service->message=$ret["MESSAGE"];
					$this->service->error="check_quota";
					return FALSE;
				}
			}

			if($this->resa_exists() ){
				$this->service->error="check_resa_exists";
				return FALSE;
			}
			if($this->allready_loaned()){
				$this->service->error="check_allready_loaned";
				return FALSE;
			}
			// check_statut inclus la possibilit� de r�server ou pas les docs dispo 
			if($this->check_statut()) {
				// $this->service->error est affect� dans check_statut()
				return FALSE;
			}				
			if($pmb_location_reservation) {
				if(!$this->check_localisation_expl()){
					$this->service->error="check_localisation_expl";	
					return FALSE;
				}			
			}		
			return TRUE;
		}
		
		// <----------------- add() : ajout d'une r�servation ------------------>
		public function add($idloc_retrait=0, $force=0) {
			global $msg;
			global $quota_resa;
			global $pmb_transferts_actif, $transferts_choix_lieu_opac,$pmb_location_reservation;
			
			$this->service->error="";
			if(!$force){
				if (!$this->empr_exists() ){
					$this->service->error="check_empr_exists";
					return FALSE;
				}		
				if(!$this->notice_exists() ){
					$this->service->error="check_notice_exists";
					return FALSE;
				}			
				//les quotas
				if (!$quota_resa) {
					//Si un quota atteint (check_quota inclu le message + la mise � 0 ou 1 de $this->force)
					$ret = $this->check_quota();
					if ($ret["ERROR"]) {
						$this->service->message=$ret["MESSAGE"];
						$this->service->error="check_quota";
						return FALSE;
					}
				}
	
				if($this->resa_exists() ){
					$this->service->error="check_resa_exists";
					return FALSE;
				}
				if($this->allready_loaned()){
					$this->service->error="check_allready_loaned";
					return FALSE;
				}	
				// check_statut inclus la possibilit� de r�server ou pas les docs dispo 
				if($this->check_statut()) {
					// $this->service->error est affect� dans check_statut()
					return FALSE;				
				}				
				if($pmb_location_reservation) {
					if(!$this->check_localisation_expl()){
						$this->service->error="check_localisation_expl";	
						return FALSE;
					}			
				}	
			}			
			// tout est OK, �criture de la r�servation en table
			// On r�cup�re d'abord la dur�e
			$t=get_time($this->id_empr,$this->id_notice,$this->id_bulletin);
			$query = "INSERT INTO resa (id_resa, resa_idempr, resa_idnotice, resa_idbulletin, resa_date, resa_loc_retrait, resa_pnb_flag) ";
			$query .= "VALUES ('', '".$this->id_empr."', ";
			if($this->id_notice) $query .= "'".$this->id_notice."',0 ,";
				elseif ($this->id_bulletin)
					$query .= "0, '".$this->id_bulletin."',";
			$query .= " SYSDATE(),";
						
			if (($pmb_transferts_actif=="1")&&($transferts_choix_lieu_opac=="1")) {
				$rqt = "SELECT empr_location FROM empr WHERE id_empr=".$this->id_empr;
				$idloc_retrait = pmb_mysql_result(pmb_mysql_query($rqt),0);				
			} 
			$query .= "'$idloc_retrait', '" . $this->resa_pnb_flag . "' )";			
			$result = pmb_mysql_query($query);
			if(!$result) {
				$this->message = "$query -> $msg[resa_no_create]";
				$this->service->error="resa_no_create";	
				return FALSE;
			}else {
				$this->id = pmb_mysql_insert_id();
				$this->message = $msg["resa_ajoutee"];
				
				// Archivage de la r�sa: info lecteur et notice et nombre d'exemplaire
				$rqt = "SELECT * FROM empr WHERE id_empr=".$this->id_empr;
				$empr = pmb_mysql_fetch_object(pmb_mysql_query($rqt));	
						
				$id_notice=$id_bulletin=0;
				if($this->id_notice) {
					$id_notice=	$this->id_notice;
					$query = "SELECT count(*) FROM exemplaires where expl_notice='$id_notice'";
				}elseif($this->id_bulletin) {
					$id_bulletin=$this->id_bulletin;
					$query = "SELECT count(*) FROM exemplaires where expl_bulletin='$id_bulletin'";
				}
				$nb_expl = pmb_mysql_result(pmb_mysql_query($query),0);
				
				$query = "INSERT INTO resa_archive SET
					resarc_id_empr = '".$this->id_empr."', 
					resarc_idnotice = '".$id_notice."', 
					resarc_idbulletin = '".$id_bulletin."',
					resarc_date = SYSDATE(), 
					resarc_loc_retrait = '$idloc_retrait',
					resarc_from_opac= 0,
					resarc_empr_cp ='".addslashes($empr->empr_cp)."',
					resarc_empr_ville = '".addslashes($empr->empr_ville)."',
					resarc_empr_prof = '".addslashes($empr->empr_prof)."',
					resarc_empr_year = '".$empr->empr_year."',
					resarc_empr_categ = '".$empr->empr_categ."',
					resarc_empr_codestat = '".$empr->empr_codestat ."',
					resarc_empr_sexe = '".$empr->empr_sexe."',
					resarc_empr_location = '".$empr->empr_location."',
					resarc_expl_nb = '$nb_expl',		
					resarc_pnb_flag = '" . $this->resa_pnb_flag . "'
				 ";
				pmb_mysql_query($query);
				$stat_id = pmb_mysql_insert_id();
				// Lier achive et r�sa pour suivre l'�volution de la r�sa
				$query = "update resa SET resa_arc='$stat_id' where id_resa='".$this->id."'";
				pmb_mysql_query($query);
			}
			return TRUE;
		}
		
		// <----------------- delete() : suppression d'une r�servation ------------------>
		public function delete() {
			global $msg;
			//  suppression  de la r�servation de la table des r�servations
			$id_notice=$id_bulletin=0;
			if($this->id_notice) {
				$id_notice=$this->id_notice;
				$query = "delete from resa where resa_idempr=".$this->id_empr." and resa_idnotice=".$this->id_notice;
			} elseif($this->id_bulletin) {
				$id_bulletin=$this->id_bulletin;
				$query = "delete from resa where resa_idempr=".$this->id_empr." and resa_idbulletin=".$this->id_bulletin;
			}	
			$result = @pmb_mysql_query($query);
			// archivage
			$rqt_arch = "UPDATE resa_archive SET resarc_anulee = 1 WHERE resarc_id_empr = '".$this->id_empr."' and resarc_idnotice = '".$id_notice."' and	resarc_idbulletin = '".$id_bulletin."' "; 
			pmb_mysql_query($rqt_arch);
			
			if(!$result) {
				$this->message = $msg["resa_no_suppr"];
				return FALSE;
			} else {
				// on checke l'existence d'autres r�servataires
				$query = "select e.empr_nom, e.empr_prenom, e.empr_cb from resa r, empr e";
				$query .= " where r.resa_idempr=e.id_empr";
				if($this->id_notice)
					$query .= " and r.resa_idnotice=".$this->id_notice;
				elseif($this->id_bulletin)
					$query .= " and r.resa_idbulletin=".$this->id_bulletin;
				$query .= " order by r.resa_date limit 1";
				$result = pmb_mysql_query($query);
				if(pmb_mysql_num_rows($result)) {
		
					// d'autres r�servataires existent
					$next_empr = pmb_mysql_fetch_object($result);
		
					$this->message = $msg['resa_supprimee'];
		
					// on regarde la disponibilit� du document
					// on compte le nombre total d'exemplaires pour la notice
					if($this->id_notice)
						$query = "select count(1) from exemplaires where expl_notice=".$this->id_notice;
					elseif($this->id_bulletin)
						$query = "select count(1) from exemplaires where expl_bulletin=".$this->id_bulletin;
					$result = pmb_mysql_query($query);
					$total_ex = pmb_mysql_result($result, 0, 0);
		
					// on compte le nombre d'exemplaires sortis
					$query = "select count(1) from exemplaires e, pret p";
					if($this->id_notice)
						$query .= " where e.expl_notice=".$this->id_notice;
					elseif($this->id_bulletin)
						$query .= " where e.expl_bulletin=".$this->id_bulletin;			
					$query .= " and p.pret_idexpl=e.expl_id";
					$result = pmb_mysql_query($query);
					$total_sortis = pmb_mysql_result($result, 0, 0);
		
					// on en d�duit le nombre d'exemplaires disponibles
					$total_dispo = $total_ex - $total_sortis;
		
					if($total_dispo) {
						$this->message .= " <strong> $msg[resa_dispo_suivant] ";
						$this->message .= $next_empr->empr_nom." ".$next_empr->empr_prenom."</strong>. (".$next_empr->empr_cb.")";
						}
					return TRUE;
				} else {
					$this->message = $msg["resa_supprimee"];
					return TRUE;
				}
			}
		}
		
		// <----------------- check_quota() : v�rification du d�passement de quota -------------------------->
		public function check_quota() {
			global $msg;
			global $pmb_quotas_avances;
			global $pmb_resa_quota_pret_depasse;
			
			//Initialisation r�sultat
			$error=array();
			$error["ERROR"]=false;
			
			//Si les quotas avanc�s sont autoris�s
			if ($pmb_quotas_avances) {
				$struct=array();
				//Quota de notice ou bulletin ?
				if ($this->id_notice) {
					$quota_type="BOOK_NMBR_QUOTA";
					$struct["NOTI"]=$this->id_notice;
					$elt_name="NOTICETYPE";
				} else {
					$quota_type="BOOK_NMBR_SERIAL_QUOTA";
					$struct["BULL"]=$this->id_bulletin;
					$elt_name="BULLETINTYPE";
				}
				//Initialisation du quota
				$qt=new quota($quota_type);
				$struct["READER"]=$this->id_empr;
			
				//Si r�sa bloqu�e en cas de d�passement de quota de pr�t
				if (!$pmb_resa_quota_pret_depasse) {
					//Le quota de pr�t est-il atteint pour cette notice ou bulletin
					//R�cup�ration de l'�l�ment indirect � tester
					$elt=$qt->get_element_by_name($elt_name);
					//R�cup�ration de l'exemplaire le plus d�favorable associ� � la r�servation
					$object_id=$qt->get_object_for_indirect_element(quota::$_quotas_[$qt->descriptor]['_elements_'][$elt],$struct);
					//Initialisation du quota de pr�t
					$qt_pret=new quota("LEND_NMBR_QUOTA");
			
					$struct_pret["READER"]=$this->id_empr;
					$struct_pret["EXPL"]=$object_id;
					$r=$qt_pret->check_quota($struct_pret);
				} else $r=false;
			
				//Si quota de pr�t non viol� alors on regarde les quotas de r�servation
				if (!$r) {
					//V�rification
					$r=$qt->check_quota($struct);
					//Si quota viol�
					if ($r) {
						$error["ERROR"]=true;
						//Erreur
						$error["MESSAGE"]=$qt->error_message;
						//Peut-on forcer ou pas la r�sa
						$error["FORCE"] = $qt->force;
					}
				} else {
					$error["ERROR"]=true;
					//Erreur
					$error["MESSAGE"]=$qt_pret->error_message."<br />".$msg["resa_quota_pret_error"];
					//Peut-on forcer ou pas la r�sa
					$r_force=$qt->check_quota($struct);
					if($r_force){
						$error["FORCE"] = $qt->force;
					}
					else $error["FORCE"] = 0;
				}
			}	
			if ($error["ERROR"]) {
				$this->message=$error["MESSAGE"];
				$this->force=$error["FORCE"];
			}
			return $error;
		}
		
		// <----------------- empr_exists() : v�rification de l'existence de l'utilisateur ------------------>
		public function empr_exists() {
			global $msg;
			$query = "select count(1) from empr where id_empr=".$this->id_empr;
			$result = @pmb_mysql_query($query);
			if(!@pmb_mysql_result($result, 0, 0)) {
				$this->message = "<strong>$msg[resa_no_empr]</strong>";
				return FALSE;
			}
			return TRUE;
		}
		
		// <----------------- notice_exists() : v�rification de l'existence de la notice  ou du bulletinage ------------------>
		public function notice_exists() {
			global $msg;
			if($this->id_notice) $query = "select count(1) from notices where notice_id=".$this->id_notice;
				elseif ($this->id_bulletin)
					$query = "select count(1) from bulletins where bulletin_id=".$this->id_bulletin;
			$result = @pmb_mysql_query($query);
			if(!@pmb_mysql_result($result, 0, 0)) {
				$this->message = "<strong>$msg[resa_no_doc]</strong>";
				return FALSE;
			}
			return TRUE;
		}
		
		// <----------------- resa_exists() : v�rification de l'existence de la r�servation ------------------>
		public function resa_exists() {
			global $msg;
			$query = "select count(1) from resa where resa_idempr=".$this->id_empr;
			if($this->id_notice) $query .= " and resa_idnotice=".$this->id_notice;
				elseif ($this->id_bulletin)
					$query .= " and resa_idbulletin=".$this->id_bulletin;
			$result = @pmb_mysql_query($query);
			if(@pmb_mysql_result($result, 0, 0)) {
				$this->message = "<strong>$msg[resa_deja_resa]</strong>";
				return TRUE;
			}
			return FALSE;
		}
		
		// <----------------- allready_loaned() : on regarde si l'emprunteur n'a pas d�j� ce document ------------------>
		public function allready_loaned() {
			global $msg;
			$query = "select count(1) from pret p, exemplaires e";
			$query .= " where p.pret_idempr=".$this->id_empr;
			$query .= " and p.pret_idexpl=e.expl_id";
			if($this->id_notice)
				$query .= " and e.expl_notice=".$this->id_notice;
			elseif ($this->id_bulletin)
				$query .= " and e.expl_bulletin=".$this->id_bulletin;
			$result = @pmb_mysql_query($query);
			if(@pmb_mysql_result($result, 0, 0)) {
				$this->message = "<strong>$msg[resa_deja_doc]</strong>";
				return TRUE;
			}
			return FALSE;
		}
		
		// <----------------- check_statut() : le genre de choses qu'on peut attendre en retour ------------------>
		/* fonction complexe � rediscuter : cas possibles :
		- doc en consultation sur place uniquement
		- doc mixed : exemplaire(s) en consultation sur place et exemplaire(s) en circulation
		- doc en circulation ET disponible
		La solution retenue : fetcher tous les exemplaires attach�s � la notice et d�finir des flags de situation
		*/
		public function check_statut() {
			global $pmb_resa_dispo; // les r�sa de disponibles sont-elles autoris�es ?
			global $msg,$pmb_location_reservation;
			
			if ($this->id_notice) {
				$notice = new mono_display($this->id_notice, 0);
				$this->notice = $notice->header;
			} elseif ($this->id_bulletin) {
				$bulletin = new bulletinage($this->id_bulletin, 0);
				$this->notice = $bulletin->display;
			}
		
			// on checke s'il y a des exemplaires pr�tables
			$query = $this->get_query_expl_lendable();
			$result = pmb_mysql_query($query);
			if(!@pmb_mysql_num_rows($result)) {
				// aucun exemplaire n'est disponible pour le pr�t
				$this->message .= "$msg[resa]&nbsp;:&nbsp;".$this->notice."<br /><strong>$msg[resa_no_expl]</strong>";
				$this->service->error="check_statut";	
				return 1;
			}

			// on regarde si les r�sa de disponibles sont autoris�es
			if ($pmb_resa_dispo=="1") return 0;
			
			// on checke si un exemplaire est disponible
			// aka. si un des exemplaires en circulation n'est pas mentionn� dans la table des pr�ts,
			// c'est qu'il est disponible � la biblioth�que
			$list_dispo = '';
		
			while($pretable = pmb_mysql_fetch_object($result)) {
				$req2 = "select count(1) from pret where pret_idexpl=".$pretable->expl_id;		
				$req2_result = pmb_mysql_query($req2);
				if(!pmb_mysql_result($req2_result, 0, 0)) {
					// l'exemplaire ne figure pas dans la table pret -> dispo
					// on r�cup�re les donn�es exemplaires pour constituer le message
					$req3 = "select p.expl_cote, s.section_libelle, l.location_libelle";
					$req3 .= " from exemplaires p, docs_section s, docs_location l";
					$req3 .= " where p.expl_id=".$pretable->expl_id;
					$req3 .= " and s.idsection=p.expl_section";
					$req3 .= " and l.idlocation=p.expl_location limit 1";
					
					$req3_result = pmb_mysql_query($req3);
					$req3_obj = pmb_mysql_fetch_object($req3_result);
					if($req3_obj->expl_cote) {				
						// Si r�sa valid� il n'est pas disponible en pr�t
						$req4 = "select count(1) from resa where resa_cb='".$pretable->expl_cb."' and resa_confirmee='1'";
						$req4_result = pmb_mysql_query($req4);
						if(!pmb_mysql_result($req4_result, 0, 0)) {	
							$list_dispo .= '<br />'.$req3_obj->location_libelle.'.';
							$list_dispo .= $req3_obj->section_libelle.' cote&nbsp;: '.$req3_obj->expl_cote;
						}
					}
				}
			}
		
			if($list_dispo) {

				$this->message = $msg['resa_doc_dispo']."<br />";
				$this->message .= $this->notice.$list_dispo;
				$this->service->error="check_doc_dispo";	
				return 2;
			}
		
			// rien de sp�cial
			return  0;
		}
		
		
		public function get_resa_cb() {
			global $pmb_resa_dispo; // les r�sa de disponibles sont-elles autoris�es ?
			global $msg,$pmb_location_reservation,$deflt_docs_location,$pmb_transferts_actif,$transferts_choix_lieu_opac;
			
			$this->expl_affectable=array();
			$this->expl_reservable=array();
			$this->expl_transferable=array();
			
			// on check s'il y a des exemplaires pr�tables
			$query = $this->get_query_expl_lendable();
			$result = pmb_mysql_query($query);
			if(!@pmb_mysql_num_rows($result)) {
				// aucun exemplaire n'est disponible pour le pr�t
				$this->message .= "$msg[resa]&nbsp;:&nbsp;".$this->notice."<br /><strong>$msg[resa_no_expl]</strong>";
				return 1;
			}
		
			while(($pretable = pmb_mysql_fetch_object($result))) {
				$req2 = "select count(1) from pret where pret_idexpl=".$pretable->expl_id;		
				$req2_result = pmb_mysql_query($req2);
				if(!pmb_mysql_result($req2_result, 0, 0)) {
					// l'exemplaire ne figure pas dans la table pret -> dispo
					// on r�cup�re les donn�es exemplaires pour constituer le message
					$req3 = "select p.expl_cote, s.section_libelle, l.location_libelle, expl_location";
					$req3 .= " from exemplaires p, docs_section s, docs_location l";
					$req3 .= " where p.expl_id=".$pretable->expl_id;
					$req3 .= " and s.idsection=p.expl_section";
					$req3 .= " and l.idlocation=p.expl_location limit 1";
					$req3_result = pmb_mysql_query($req3);
					$req3_obj = pmb_mysql_fetch_object($req3_result);
					if($req3_obj->expl_cote) {
						// Si r�sa valid� il n'est pas disponible en pr�t
						$req4 = "select count(1) from resa where resa_cb='".addslashes($pretable->expl_cb)."' and resa_confirmee='1'";
						$req4_result = pmb_mysql_query($req4);
						if(!pmb_mysql_result($req4_result, 0, 0)) {					
							$this->expl_affectable[]=$pretable->expl_cb;
						}
						if($req3_obj->expl_location !=$deflt_docs_location) {
							$this->expl_transferable[]=$pretable->expl_cb;
						}	
					}
				}
				$this->expl_reservable[]=$pretable->expl_cb;
			}
			// Calcul du rang de r�servation du lecteur
			$rank = 1;	
			
			$from= "";
			$where = "";
			if ($pmb_transferts_actif=="1") {	
				switch ($transferts_choix_lieu_opac) {
					case "1":
						//retrait de la resa sur lieu choisi par le lecteur					
						$where= " AND resa_loc_retrait=" . $deflt_docs_location;					
					break;					
					case "2":
						//retrait de la resa sur lieu fix�
						$where= " AND resa_loc_retrait=" . $deflt_docs_location;
					break;			
					case "3":
						//retrait de la resa sur lieu exemplaire
						$from= " ,exemplaires ";
						$where= " AND expl_cb='".$pretable->expl_cb."' and expl_location=" . $deflt_docs_location;
					break;	
					default:
						//retrait de la resa sur lieu lecteur
						$from= " ,empr ";
						$where= " AND resa_idempr=id_empr and empr_location=" . $deflt_docs_location;
					break;						
				} //switch $transferts_choix_lieu_opac			
			} 
			// chercher le premier (par ordre de rang, donc de date de d�but de r�sa, non valid� 
			$rqt = 	"SELECT id_resa, resa_idempr,resa_loc_retrait 
					FROM resa $from
					WHERE resa_idnotice='".$this->id_notice."' 
						AND resa_idbulletin='".$this->id_bulletin."' 
						AND resa_cb='' 
						AND resa_date_fin='0000-00-00' 
						$where
					ORDER BY resa_date ";
					
			/*
			if($pmb_location_reservation) {
				$rqt = "SELECT resa_idempr FROM resa ,empr WHERE resa_idnotice='".$this->id_notice."' AND resa_idbulletin='".$this->id_bulletin."' and resa_idempr=id_empr
				and empr_location in (select resa_loc from resa_loc where resa_emprloc=$empr_location) ORDER BY resa_date";
			} else {
				$rqt = "SELECT resa_idempr FROM resa WHERE resa_idnotice='".$this->id_notice."' AND resa_idbulletin='".$this->id_bulletin."' ORDER BY resa_date";
			}
			*/
			$result = pmb_mysql_query($rqt);
			while(($resa=pmb_mysql_fetch_object($result))) {
				if($resa->resa_idempr == $this->id_empr) break;
				$rank++;
			}
			$this->resa_rank=$rank;
			//print $query ."<br />".$rank."<br />";

		
			// rien de sp�cial
			return  0;
		}
		
		public function transfert_resa_dispo($loc){
			global $msg;
			$loc=intval($loc);
			if(!$loc) $loc=0;
			$rqt = "SELECT ".
					"trim(concat(ifnull(notices_m.tit1,''),ifnull(notices_s.tit1,''),' ',ifnull(bulletin_numero,''), if (mention_date, concat(' (',mention_date,')') ,''))) as tit, ".
					"expl_cb, ".
					"location_libelle, ".
					"expl_id ,
			lender_libelle ".
					"FROM (((exemplaires ".
					"LEFT JOIN notices AS notices_m ON expl_notice=notices_m.notice_id) ".
					"LEFT JOIN bulletins ON expl_bulletin = bulletins.bulletin_id) ".
					"LEFT JOIN notices AS notices_s ON bulletin_notice = notices_s.notice_id) ".
					"INNER JOIN docs_location ON expl_location=idlocation ".
					"INNER JOIN docs_statut ON expl_statut=idstatut ".
					"INNER JOIN lenders ON idlender=expl_owner " .
					"WHERE ".
					"pret_flag=1 ".
					"and transfert_flag=1 ".
					"AND expl_notice=".$this->id_notice." ".
					"AND expl_bulletin=".$this->id_bulletin." ".
					"AND expl_location<>".$loc." ".
					"ORDER BY transfert_ordre";
			$res = pmb_mysql_query($rqt);
			$count=0;
			if ($res) {
				while (($data = pmb_mysql_fetch_array($res))) {
					$sel_expl=1;
					$statut="";
					$req_res = "select count(1) from resa where resa_cb='".addslashes($data[1])."' and resa_confirmee='1'";
					$req_res_result = pmb_mysql_query($req_res);
					if(pmb_mysql_result($req_res_result, 0, 0)) {
						$sel_expl=0;
					}
					$req_pret = "select date_format(pret_retour, '".$msg["format_date"]."') as aff_pret_retour  from pret where pret_idexpl='".$data[3]."' ";
					$req_pret_result = pmb_mysql_query($req_pret);
					if(pmb_mysql_num_rows($req_pret_result)) {
						$sel_expl=0;
					}
					$req="select  count(1)  from transferts_demande, transferts where etat_demande ='0' and num_expl='".$data[3]."' and etat_transfert=0 and id_transfert=num_transfert ";
					$r = pmb_mysql_query($req);
					if(pmb_mysql_result($r, 0, 0)) {
						$sel_expl=0;
					}
					if($sel_expl) {
						$count++;
					}else{
		
					}
				}
			}
			return $count;
		}
		
		public function set_on_empr_fiche($on_empr_fiche=false) {
			$this->on_empr_fiche = $on_empr_fiche;
		}
		
		public function get_restrict_expl_location_query() {
			global $pmb_lecteurs_localises;
			global $deflt_resas_location;
			global $pmb_transferts_actif, $transferts_choix_lieu_opac;
			global $f_loc, $f_dispo_loc;
			
			$sql_expl_loc = '';
			if ($pmb_lecteurs_localises && !$this->on_empr_fiche){
				if ($f_loc=="")	$f_loc = $deflt_resas_location;
				if ($f_loc && $f_dispo_loc)	$sql_expl_loc= " and (expl_location='".$f_loc."' or expl_location='".$f_dispo_loc."') ";
				elseif ($f_loc) $sql_expl_loc .= " and expl_location='".$f_loc."' ";
				elseif ($f_dispo_loc) $sql_expl_loc= " and expl_location='".$f_dispo_loc."' ";
			}
			if ($pmb_transferts_actif=="1" && $f_loc && !$this->on_empr_fiche) {
				switch ($transferts_choix_lieu_opac) {
					case "1":
						//retrait de la resa sur lieu choisi par le lecteur
						break;
					case "2":
						//retrait de la resa sur lieu fix�
						break;
					case "3":
						//retrait de la resa sur lieu exemplaire
						if (!$this->on_empr_fiche) {
							if ($f_loc && $f_dispo_loc)	$sql_expl_loc .= " and (expl_location='".$f_loc."' or expl_location='".$f_dispo_loc."') ";
							elseif ($f_loc) $sql_expl_loc .= " and expl_location='".$f_loc."' ";
							elseif ($f_dispo_loc) $sql_expl_loc .= " and expl_location='".$f_dispo_loc."' ";
						}
						break;
					default:
						//retrait de la resa sur lieu lecteur
						if (!$this->on_empr_fiche) {
							if ($f_loc && $f_dispo_loc)	$sql_expl_loc .= " and (expl_location='".$f_loc."' or expl_location='".$f_dispo_loc."') ";
							elseif ($f_loc) $sql_expl_loc .= " and expl_location='".$f_loc."' ";
							elseif ($f_dispo_loc) $sql_expl_loc .= " and expl_location='".$f_dispo_loc."' ";
						}
						break;
				}
			}
			return $sql_expl_loc;
		}
		
		public function get_restrict_expl_notice_query() {
			if ($this->id_notice) {
				return " expl_notice=".$this->id_notice;
			} elseif ($this->id_bulletin) {
				return " expl_bulletin=".$this->id_bulletin;
			}
		}
		
		/**
		 * On compte le nombre total d'exemplaires pr�tables pour la notice
		 * @param number $location Localisation
		 * @param string $outside Pour la localisation ou en dehors
		 * @return string
		 */
		public function get_number_expl_lendable($location=0, $outside=false) {
			$query = "SELECT count(1) FROM exemplaires, docs_statut WHERE expl_statut=idstatut AND statut_allow_resa=1 ";
			if($location) {
				if($outside) {
					$query .= " AND expl_location <> ".$location;
				} else {
					$query .= " AND expl_location = ".$location;
				}
			} else {
				$query .= $this->get_restrict_expl_location_query();
			}
			$query .= " AND ".$this->get_restrict_expl_notice_query();
			$tresult = pmb_mysql_query($query);
			return pmb_mysql_result($tresult, 0, 0);
		}
		
		/**
		 * On compte le nombre d'exemplaires sortis
		 */
		public function get_number_expl_out() {
			$query = "SELECT count(1) as qte FROM exemplaires , pret WHERE pret_idexpl=expl_id ".$this->get_restrict_expl_location_query();
			$query .= " AND ".$this->get_restrict_expl_notice_query();
			$tresult = pmb_mysql_query($query);
			return pmb_mysql_result($tresult, 0, 0);
		}
		
		/**
		 * On compte le nombre d'exemplaires en circulation
		 */
		public function get_number_expl_in_circ() {
			$query = "SELECT count(1) FROM exemplaires, serialcirc_expl WHERE num_serialcirc_expl_id=expl_id ".$this->get_restrict_expl_location_query();
			$query .= " AND ".$this->get_restrict_expl_notice_query();
			$tresult = pmb_mysql_query($query);
			return pmb_mysql_result($tresult, 0, 0);
		}
		
		/**
		 * On compte le nombre d'exemplaires disponibles
		 */
		public function get_number_expl_available() {
			// on compte le nombre total d'exemplaires pr�tables pour la notice
			// on compte le nombre d'exemplaires sortis
			// on compte le nombre d'exemplaires en circulation
			// on en d�duit le nombre d'exemplaires disponibles
			$number = $this->get_number_expl_lendable() - $this->get_number_expl_out() - $this->get_number_expl_in_circ();
			return $number;
		}
		
		public function get_exemplaire() {
			if(!isset($this->exemplaire)) {
				$this->exemplaire = new exemplaire($this->expl_cb, $this->expl_id);
			}
			return $this->exemplaire;
		}
		
		public static function get_cb_from_id($id) {
			$rqt = "select resa_cb from resa where id_resa='".$id."' ";
			$res = pmb_mysql_query($rqt) ;
			$nb=pmb_mysql_num_rows($res) ;
			if (!$nb) return "" ;
			$obj=pmb_mysql_fetch_object($res) ;
			return $obj->resa_cb ;
		}
		
		public static function verif_cb_resa_flag($cb){
			$query = " select statut_allow_resa from exemplaires , docs_statut where expl_cb='".addslashes($cb)."' and idstatut=expl_statut";
			$result = pmb_mysql_query($query);
			if(pmb_mysql_num_rows($result)) {
				$expl = pmb_mysql_fetch_object($result);
				return $expl->statut_allow_resa;
			}
		}
	} # fin de d�claration classe reservation

} # fin de d�finition
