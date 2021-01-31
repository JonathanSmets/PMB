<?php
// +-----------------------------------------------------+
// � 2004-2008 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-----------------------------------------------------+

/* Ce fichier sert a�etablir la correspondance entre la documentation et PMB.
   Ce fichier est distribue avec le zip de la documentation. 
   Version 4.2
   N'EDITEZ PAS CE FICHIER
  
*/

//lien entre les infos postees et la doc
switch ($script_name) {

//TODO
//AFFICHAGE DE LA LICENCE > -----------------------------------------------------------------------------
/*
	case 'main.php' :
		print 'html-install/ch12.html#licence';
    	break;
*/

//PREFERENCES > -----------------------------------------------------------------------------
    case 'account.php' :
		print 'co/preferences_v42.html';
		break;

//DASHBOARD > -----------------------------------------------------------------------------
    case 'dashboard.php' :
   	print 'co/dashboard_v42.html';
    	break;
		
//CIRCULATION > -----------------------------------------------------------------------------
	case 'circ.php' :
		switch ($categ) {
			
//CIRCULATION > CIRCULATION			
			case '' :
				print 'co/circ_v42.html';
				break;
			case 'retour' :
	    		print 'co/circ_retour_v42.html';
				break;
			case 'ret_todo' :
	    		print 'co/circ_ret_todo_v42.html';
				break;
			case 'groups' :
	    		print 'co/circ_groups_v42.html';
				break;
			case 'empr_create' :
	    		print 'co/circ_empr_create_v42.html';
				break;
			case 'empr_saisie' :
	    		print 'co/circ_empr_saisie_v42.html';
				break;
			case 'pret' :
				switch ($sub) {
					case 'show_late' :
						print 'co/circ_pret_show_late_v42.html';
						break;
					default :
						print 'co/circ_v42.html';
						break;
				}
				break;
			case 'serialcirc' :
				print 'co/circ_serialcirc_v42.html';
				break;
			case 'groupexpl' :
				print 'co/circ_groupexpl_v42.html';
				break;
				
//CIRCULATION > PANIERS
			case 'caddie' :
				switch ($sub) {
					case 'gestion' :
						switch ($quoi) {
							case 'panier' :
								print 'co/circ_caddie_gestion_panier_v42.html';
								break;
							case 'procs' :
								print 'co/circ_caddie_gestion_procs_v42.html';
								break;
							case 'remote_procs' :
								print 'co/circ_caddie_gestion_remote_procs_v42.html';
								break;
							case 'classement' :
								print 'co/circ_caddie_gestion_classementGen_v42.html';
								break;
							case 'barcode' :
								print 'co/circ_caddie_gestion_barcode_v42.html';
								break;
							case 'selection' :
								print 'co/circ_caddie_gestion_selection_v42.html';
								break;
							case 'pointagebarcode' :
								print 'co/circ_caddie_gestion_pointagebarcode_v42.html';
								break;
							case 'pointage' :
								print 'co/circ_caddie_gestion_pointage_v42.html';
								break;
							case 'razpointage' :
								print 'co/circ_caddie_gestion_razpointage_v42.html';
								break;
							default :
								print 'co/circulation_paniers_v42.html';
								break;
						}
						break;
					case 'action' :
						switch ($quelle) {
							case 'supprpanier' :
								print 'co/circ_caddie_action_supprpanier_v42.html';
								break;
							case 'transfert' :
								print 'co/circ_caddie_action_transfert_v42.html';
								break;
							case 'edition' :
								print 'co/circ_caddie_action_edition_v42.html';
								break;
							case 'mailing' :
								print 'co/circ_caddie_action_mailing_v42.html';
								break;
							case 'selection' :
								print 'co/circ_caddie_action_selection_v42.html';
								break;
							case 'supprbase' :
								print 'co/circ_caddie_action_supprbase_v42.html';
								break;
							default :
								print 'co/circ_caddie_action_v42.html';
								break;
						}
						break;
					default :
						print 'co/circulation_paniers_v42.html';
						break;
				} 
				break;
				
//CIRCULATION > VISUALISER
			case 'visu_ex' :
	    		print 'co/circ_visu_ex_v42.html';
				break;
			case 'visu_rech' :
	    		print 'co/circ_visu_rech_v42.html';
				break;
				
//CIRCULATION > RESERVATIONS		
			case 'listeresa' :
				switch ($sub) {
					case 'encours' :
			    		print 'co/circ_listeresa_encours_v42.html';
						break;
					case 'depassee' :
			    		print 'co/circ_listeresa_depassee_v42.html';
						break;
					case 'docranger' :
			    		print 'co/circ_listeresa_docranger_v42.html';
						break;
					default :
						print 'co/circulation_reservations_v42.html';
						break;
				}
				break;
				
//CIRCULATION > PREVISIONS			
//TODO
			case 'resa_planning' :
		    	print 'co/nodoc_v42.html';
				break;
				
//CIRCULATION > RELANCES
			case 'relance' :
				switch ($sub) {
					case 'todo' :
			    		print 'co/circ_relance_todo_v42.html';
						break;
					case 'recouvr' :
			    		print 'co/circ_relance_recouvr_v42.html';
						break;
					default :
						print 'co/circulation_relances_v42.html';
						break;
				}
				break;

//CIRCULATION > SUGGESTIONS				
			case 'sug' :
				print 'co/circ_sug_v42.html';
				break;

//CIRCULATION > TRANSFERTS 
			case 'trans' :
				switch ($sub) {
					case 'valid' :
						print 'co/circ_trans_valid_v42.html';
						break;
					case 'envoi' :
						print 'co/circ_trans_envoi_v42.html';
						break;
					case 'recep' :
						print 'co/circ_trans_recep_v42.html';
						break;
					case 'retour' :
						print 'co/circ_trans_retour_v42.html';
						break;
					case 'refus' :
						print 'co/circ_trans_refus_v42.html';
						break;
					case 'reset' :
						print 'co/circ_trans_reset_v42.html';
						break;
					default :
						print 'co/circulation_transferts_v42.html';
						break;
				}
				break;
				
//CIRCULATION > NON DOCUMENTE
			default :
				print 'co/nodoc_v42.html';
				break;				
		}
		break;


//CATALOGUE > -----------------------------------------------------------------------------
	case 'catalog.php' :
		switch ($categ) {
			
//CATALOGUE > RECHERCHE
			case 'search' :
				switch ($mode) {
					case '' :
					case '0' :
						// Auteur/titre
			    		print 'co/catalog_search_0_v42.html';
						break;
					case '1' :
						// Categorie/sujet
						print 'co/catalog_search_1_v42.html';
						break;
					case '5' :
						// Termes du thesaurus
						print 'co/catalog_search_5_v42.html';
						break;
					case '2' :
						// Editeur/collection
						print 'co/catalog_search_2_v42.html';
						break;		
					case '9' :	
						print 'co/catalog_search_9_v42.html';
						break;												
					case '3' :
						// Paniers de notices
						print 'co/catalog_search_3_v42.html';
						break;
					case '6' :
						// Multi-criteres
						print 'co/catalog_search_6_v42.html';
						break;
					case '8' :
						//exemplaires	
						print 'co/catalog_search_8_v42.html';
						break;
					case '11' :
						//georeferencement
						print 'co/catalog_search_11_v42.html';
						break;
					case '7' :	
						//externe
						print 'co/catalog_search_7_v42.html';
						break;
//CATALOGUE > RECHERCHE > NON DOCUMENTE						
					default :
						print 'co/catalogue_recherche_v42.html';
						break;
				}
	    		break;		
			case 'last_records' :
				//dernieres notices
				print 'co/catalog_last_records_v42.html';
				break;
			case 'search_perso' :
				print 'co/catalog_search_perso_v42.html';
				//pr�d�finies
				break;			
				
//CATALOGUE > DOCUMENTS
			case 'create' :
				print 'co/catalog_create_v42.html';
				break;
			case 'create_form' :
				print 'co/catalog_create_v42.html';
				break;
			case 'avis' :
				print 'co/catalog_avis_v42.html';
				break;
			case 'tags' :
				print 'co/catalog_tags_v42.html';
				break;
				
//CATALOGUE > PERIODIQUES
			case 'serials' :
				switch ($sub) {
					case 'serial_form' :
			    		print 'co/catalog_serials_serial_form_v42.html';
						break;
					case 'view' :
						switch($view) {
							case 'abon' :
								print 'co/catalog_serials_view_abon_v42.html';
								break;
							case 'modele' :
								print 'co/catalog_serials_view_modele_v42.html';
								break;
							case 'collstate' :
								print 'co/catalog_serials_view_collstate_v42.html';
								break;
							default :
								print 'co/catalog_serials_view_v42.html';
								break;
						}
						break;
					case 'pointage' :
						print 'co/catalog_serials_pointage_v42.html';
						break;					
					case 'bulletinage' :
						switch ($action) {
							case 'bul_form' :
			    				print 'co/catalog_serials_bulletinage_bul_form_v42.html';
			    				break;
							case 'view' :
			    				print 'co/catalog_serials_bulletinage_view_v42.html';
			    				break;
							default :
			    				print 'co/catalog_serials_bulletinage_view_v42.html';
			    				break;
						}
						break;
					case 'circ_ask' :
						print 'co/catalog_serials_circ_ask_v42.html';
						break;
					case 'analysis' :
			    		print 'co/catalog_serials_bulletinage_view_v42.html';
						break;		
										
//CATALOGUE > RECHERCHE > PERIODIQUES					
					case '' :
					default:
			    		print 'co/catalog_serials_v42.html';
						break;
						
				}
				break;
				
//CATALOGUE > PANIERS				
			case 'caddie' :
				switch ($sub) {
					case 'collecte' :
						switch ($moyen) {
							case 'douchette' :
					    		print 'co/catalog_caddie_collecte_douchette_v42.html';
								break;
							case 'selection' :
					    		print 'co/catalog_caddie_collecte_selection_v42.html';
								break;
							case '' :
							default:
					    		print 'co/catalog_caddie_collecte_v42.html';
								break;
						}
						break;
					case 'pointage' :
						switch ($moyen) {
							case 'douchette' :
								print 'co/catalog_caddie_pointage_douchette_v42.html';
								break;
							case 'selection' :
								print 'co/catalog_caddie_pointage_selection_v42.html';
								break;
							case 'raz' :
								print 'co/catalog_caddie_pointage_raz_v42.html';
								break;
							case '' :
							default:
					    		print 'co/catalog_caddie_pointage_v42.html';
								break;
						}
						break;
					case 'action' :
						switch ($quelle) {
							case 'supprpanier' :
					    		print 'co/catalog_caddie_action_supprpanier_v42.html';
								break;
							case 'transfert' :
					    		print 'co/catalog_caddie_action_transfert_v42.html';
								break;
							case 'edition' :
					    		print 'co/catalog_caddie_action_edition_v42.html';
								break;
 							case 'impr_cote' :
					    		print 'co/catalog_caddie_action_impr_cote_v42.html';
 								break;
							case 'export' :
					    		print 'co/catalog_caddie_action_export_v42.html';
								break;
							case 'expdocnum' :
					    		print 'co/catalog_caddie_action_expdocnum_v42.html';
								break;
							case 'selection' :
					    		print 'co/catalog_caddie_action_selection_v42.html';
								break;
							case 'supprbase' :
					    		print 'co/catalog_caddie_action_supprbase_v42.html';
								break;
							case '' :
							default:
					    		print 'co/catalog_caddie_action_v42.html';
								break;
						}
						break;
					case 'gestion' :
					default:
						switch ($quoi) {
							case 'procs' :
								print 'co/catalog_caddie_gestion_procs_v42.html';
								break;
							case 'remote_procs' :
								print 'co/catalog_caddie_gestion_remote_procs_v42.html';
								break;
							case 'classementGen' :
								print 'co/catalog_caddie_gestion_classement_v42.html';
								break;
							case 'panier' :
							case '' :
							default:
					    		print 'co/catalog_caddie_gestion_panier_v42.html';
								break;
						}
						break;
				}
				break;
				
//CATALOGUE > ETAGERES				
			case 'etagere' :
				switch ($sub) {
					case 'constitution' :
					    print 'co/catalog_etagere_constitution_v42.html';
						break;
					case 'gestion' :
					case '' :
			    		default:
						print 'co/catalog_etagere_v42.html';
						break;
				}
				break;
				
//CATALOGUE > EXTERNE				
			case 'z3950' :
				print 'co/catalog_z3950_v42.html';
				break;
				
//CATALOGUE > SUGGESTIONS
			case 'sug' :
				print 'co/catalog_sug_v42.html';
				break;

//CATALOGUE > DOCUMENT NUMERIQUES				
			case 'explnum_create' :
				print 'co/catalog_explnum_create_v42.html';
				break;				
				
//CATALOGUE > NON DOCUMENTE				
			case '' :				
			default:
	    		print 'co/catalogue_v42.html';
	    		break;
		}
		break;

		
//AUTORITES -----------------------------------------------------------------------------
    case 'autorites.php' :
	    switch ($categ) {
	    	
//AUTORITES > AUTORITES	    	
			case '' :
	    	case 'auteurs' :
	    		print 'co/autorites_auteurs_v42.html';
	    		break;
	    	case 'categories' :
	    		print 'co/autorites_categories_v42.html';
	    		break;
	    	case 'editeurs' :
	    		print 'co/autorites_editeurs_v42.html';
	    		break;
	    	case 'collections' :
    			print 'co/autorites_collections_v42.html';
	    		break;
	    	case 'souscollections';
	    		print 'co/autorites_souscollections_v42.html';
	    		break;
	    	case 'series' :
	    		print 'co/autorites_series_v42.html';
	    		break;
	    	case 'titres_uniformes' :
	    		print 'co/autorites_titres_uniformes_v42.html';
	    		break;	
	    	case 'indexint' :
	    		print 'co/autorites_indexint_v42.html';
	    		break;	
			case 'concepts' :
				switch ($sub) {
					case 'conceptscheme' :
						print 'co/autorites_concepts_conceptscheme_v42.html';
						break;					
					case 'collection' :
						print 'co/autorites_concepts_collection_v42.html';
						break;
					case 'orderedcollection' :
					case 'concept' :
//AUTORITES > CONCEPTS > NON DOCUMENTE	
					default :
						print 'co/autorites_concepts_v42.html';
						break;
				}
				break;
	    		
//AUTORITES > SEMANTIQUE
	    	case 'semantique' :
	    		switch ($sub) {
	    			case 'synonyms' :  				
	    				print 'co/autorites_semantique_synonyms_v42.html';
	    				break;
	    			case 'empty_words' :
	    				print 'co/autorites_semantique_empty_words_v42.html';
	    				break;
	    				
//AUTORITES > SEMANTIQUE > NON DOCUMENTE	    				
	    			default :
	    				print 'co/autorites_semantique_v42.html';
	    				break;
	    		}
	    		break;
	    	case 'import' :
	    		print 'co/autorite_import_v42.html';
	    		break;
//AUTORITES > NON DOCUMENTE
	    	default :
	    		print 'co/autorites_v42.html';
	    		break;    	
	    }
        break;
        
        
//EDITIONS > -----------------------------------------------------------------------------
	case 'edit.php' :
		switch ($categ) {
			
//EDITIONS > ETATS			
			case 'procs' :
	    		print 'co/edit_procs_v42.html';
				break;
			case 'state' :
				print 'co/edit_state_v42.html';
				break;

//EDITIONS > PRETS				
			case 'expl' :
				switch ($sub) {
					case 'encours' :
			    		print 'co/edit_expl_encours_v42.html';
						break;
					case 'retard' :
			    		print 'co/edit_expl_retard_v42.html';
						break;
					case 'retard_par_date' :
			    		print 'co/edit_expl_retard_par_date_v42.html';
						break;
 					case 'ppargroupe' :
			    		print 'co/edit_expl_ppargroupe_v42.html';
						break;
 					case 'rpargroupe' :
			    		print 'co/edit_expl_rpargroupe_v42.html';
						break;
//EDITIONS > PRETS > NON DOCUMENTE									
					default :
						print 'co/editions_v42.html';
						break;
				}
				break;
				
//EDITIONS > RESERVATIONS				
			case 'notices' :
				switch ($sub) {
					case 'resa' :
			    		print 'co/edit_notices_resa_v42.html';
						break;
					case 'resa_a_traiter' :
			    		print 'co/edit_notices_resa_a_traiter_v42.html';
						break;
					case 'resa_planning' :
						print 'co/edit_notices_resa_planning_v42.html';
						break;
						
//EDITIONS > RESERVATIONS > NON DOCUMENTE						
					default :
			    		print 'co/editions_v42.html';
						break;
				}
				break;
				
//EDITIONS > LECTEURS				
			case 'empr' :
				switch ($sub) {
					case 'encours' :
			    		print 'co/edit_empr_encours_v42.html';
						break;
					case 'limite' :
			    		print 'co/edit_empr_limite_v42.html';
						break;
					case 'depasse' :
			    		print 'co/edit_empr_depasse_v42.html';
						break;
					case 'categ_change' :
						print 'co/edit_empr_categ_change_v42.html';
						break;
						
//EDITIONS > LECTEURS > NON DOCUMENTE							
					default :
			    		print 'co/editions_v42.html';
						break;
				}
				break;
				
//EDITIONS > PERIODIQUE				
			case 'serials' :
				switch($sub) {
					case 'collect' :
	    				print 'co/edit_serials_collect_v42.html';
	    				break;
					case 'circ_state' :
						print 'co/edit_serials_circ_state_v42.html';
						break;
					case 'simple_circ' :
						print 'co/edit_serials_simple_circ_v42.html';
						break;
				}
				break;
				
//EDITIONS > CODES BARRES				
			case 'cbgen' :
	    		print 'co/edit_cbgen_libre_v42.html';
				break;
				
//EDITIONS > TEMPLATES
			case 'tpl' :
				switch ($sub) {
					case 'notice' :
	    				print 'co/edit_tpl_notice_v42.html';
						break;
					case 'serialcirc' :
						print 'co/edit_tpl_serialcirc_v42.html';
						break;
					case 'bannette' :
						print 'co/edit_tpl_bannette_v42.html';
						break;
				}
				break;

//EDITIONS > TRANSFERTS
 			case 'transferts' :
 				switch ($sub) {
 					case 'validation' :
 						print 'co/edit_transferts_validation_v42.html';
	 					break; 
 					case 'envoi' :
 						print 'co/edit_transferts_envoi_v42.html';
 						break;
 					case 'retours' :
 						print 'co/edit_transferts_retours_v42.html';
 						break;
//EDITIONS > TRANSFERTS > NON DOCUMENTE 					 			
 					case 'reception' :
 					default :
		    			print 'co/editions_v42.html';
	 					break;	
	 			}
	 			break;

//EDITIONS > STATISTIQUES OPAC
 			case 'stat_opac' :
 				print 'co/edit_stat_opac_v42.html';
 				break;
	 			
//EDITIONS > NON DOCUMENTE				
			default :
	    		print 'co/editions_v42.html';
	    		break;
		}
		break;
	
        
//DSI > -----------------------------------------------------------------------------
    case 'dsi.php' :
	    switch ($categ) {
	    	
//DSI > DIFFUSION	    	
			case 'diffuser' :
				switch ($sub) {
					case 'lancer' :
						print 'co/dsi_diffuser_lancer_v42.html';	
						break;
					case 'auto' :
						print 'co/dsi_diffuser_auto_v42.html';	
						break;
					case 'manu' :
						print 'co/dsi_diffuser_manu_v42.html';	
						break;
						
//DSI > DIFFUSION > NON DOCUMENTE	    						
					default:
						print 'co/dsi_diffusion_v42.html';	
						break;
				}
				break;
				
//DSI > BANNETTES
			case 'bannettes' :
					switch ($sub) {
						case 'pro' :
							print 'co/dsi_bannettes_pro_v42.html';	
							break;
						case 'abo' :
							print 'co/dsi_bannettes_abo_v42.html';
							break;
//DSI > BANNETTES > NON DOCUMENTE
						default :
							print 'co/dsi_v42.html';
							break;
			}
			break;
			
//DSI > EQUATIONS			
			case 'equations' :
				print 'co/dsi_equations_v42.html';
				break;
				
//DSI > OPTIONS				
			case 'options' :
				print 'co/dsi_options_v42.html';
				break;

//DSI > FLUX RSS
			case 'fluxrss' :
				print 'co/dsi_fluxrss_v42.html';
				break;
			case 'docwatch' :
				print 'co/dsi_docwatch_v42.html';
				break;				
//DSI > NON DOCUMENTE
			default:
				print 'co/dsi_v42.html';
	    		break;	
		}
        break;

        
//ACQUISITIONS > -----------------------------------------------------------------------------
    case 'acquisition.php' :	
	    switch ($categ) {
//ACQUISITIONS > ACHATS
	    	case 'ach' :
				switch ($sub) {
					case 'devi' :
						print 'co/acquisition_ach_devi_v42.html';
						break;
					case 'cmde' :
						print 'co/acquisition_ach_cmde_v42.html';
						break;
					case 'recept' :
						print 'co/acquisition_ach_recept_v42.html';
						break;
					case 'livr' :
						print 'co/acquisition_ach_livr_v42.html';
						break;
					case 'fact' :
						print 'co/acquisition_ach_fact_v42.html';
						break;
					case 'fourn' :
						print 'co/acquisition_ach_fourn_v42.html';
						break;
					case 'bud' :
						print 'co/acquisition_ach_bud_v42.html';
						break;
//ACQUISITIONS > ACHATS > NON DOCUMENTE
					default:
						print 'co/acquisitions_achats_v42.html';
						break;
					}
				break;
//ACQUISITIONS > SUGGESTIONS 
			case 'sug' :
				switch ($sub) {
					case 'multi' :
						print 'co/acquisition_sug_multi_v42.html'; 
						break;
					case 'import' :
						print 'co/acquisition_sug_import_v42.html'; 
						break;
					case 'empr_sug' :
						print 'co/acquisition_sug_empr_sug_v42.html'; 
						break;
//ACQUISITIONS > SUGGESTIONS > NON DOCUMENTE	
					default :
						print 'co/acquisitions_suggestions_v42.html';
						break;
				}
				break;
//ACQUISITIONS > NON DOCUMENTE
			default:
				print 'co/acquisitions_v42.html';
	    		break;	    	
		}
        break;

        
//EXTENSIONS > -----------------------------------------------------------------------------
    case 'EXTENSIONS.php' :
		print 'co/extensions_v42.html';
    	break;
	

//DEMANDES > -----------------------------------------------------------------------------
    case 'demandes.php' :
	
	    switch ($categ) {
	    	
//DEMANDES > LISTES
	    	case 'list' :
   				print 'co/demandes_list_v42.html';
   				break;
	    		
//DEMANDES > ACTIONS
	    	case 'action' :
				print 'co/demandes_action_v42.html';
   				break;
	    		
//DEMANDES > NON DOCUMENTE
	    	default :
				print 'co/demandes_v42.html';
	    		break;
	    }
	    break;

//FICHES > -----------------------------------------------------------------------------
    case 'fichier.php' :
    
	    switch ($categ) {
	    	  	
//FICHES > CONSULTER
	    	case 'consult' :	
	    		switch ($mode) {
	    			case 'search' :
	    				print 'co/fichier_consult_search_v42.html';
	    				break;
	    			case 'search_multi' :
	    				print 'co/fichier_consult_search_multi_v42.html';
	    				break;
	    		}
	    		break;
	    	case 'saisie' :
	    		print 'co/fichier_saisie_v42.html';
	    		break;
//FICHES > GERER
	    	case 'gerer' :
	    		switch($mode) {
	    			case 'champs' :
	    				print 'co/fichier_gerer_champs_v42.html';
	    				break;
	    			case 'reindex' :
	    				print 'co/fichier_gerer_reindex_v42.html';
	    				break;
	    		}
	    		break;
//FICHES > NON DOCUMENTE
	    	default :
	    		print 'co/fichier_v42.html';
	    		break;	
	    		
    	} 	    
	    break;
	    
//PORTAIL > -----------------------------------------------------------------------------

    case 'cms.php' :
    	
    	switch ($categ) {
//PORTAIL > CONSTRUCTION
    		case 'build' :
    			print 'co/cms_build_v42.html';
    			break;
    		case 'pages' :
    			print 'co/cms_pages_v42.html';
    			break;

//PORTAIL > CONTENU EDITORIAL 
    		case 'editorial' :
    			print 'co/cms_editorial_list_v42.html';
    			break;
    		case 'section' :
    			print 'co/cms_section_edit_v42.html';
    			break;
    		case 'article' :
    			print 'co/cms_article_edit_v42.html';
    			break;
    		case 'collection' :
    			print 'co/cms_collection_v42.html';
    			break;
    			
//PORTAIL > MODULES
    		case 'manage' :

    			switch ($sub) {
    				case 'agenda' :
    					print 'co/cms_manage_agenda_v42.html';
    					break;
					case 'article' :
						print 'co/cms_manage_article_v42.html';
						break;
					case 'bannette' :
						print 'co/cms_manage_bannette_v42.html';
						break;
					case 'carousel' :
						print 'co/cms_manage_carousel_v42.html';
						break;
					case 'htmlcode' :
						print 'co/cms_manage_htmlcode_v42.html';
						break;
					case 'opacitem' :
						print 'co/cms_manage_opacitem_v42.html';
						break;
					case 'breadcrumb' :
						print 'co/cms_manage_breadcrumb_v42.html';
						break;
					case 'rss' :
						print 'co/cms_manage_rss_v42.html';
						break;
					case 'sparql' :
						print 'co/cms_manage_sparql_v42.html';
						break;
					case 'item' :
						print 'co/cms_manage_item_v42.html';
						break;
					case 'articleslist' :
						print 'co/cms_manage_articleslist_v42.html';
						break;
					case 'itemslist' :
						print 'co/cms_manage_itemslist_v42.html';
						break;
					case 'shelveslist' :
						print 'co/cms_manage_shelveslist_v42.html';
						break;
					case 'bannetteslist' :
						print 'co/cms_manage_bannetteslist_v42.html';
						break;
					case 'docnumslist' :
						print 'co/cms_manage_docnumslist_v42.html';
						break;
					case 'recordslist' :
						print 'co/cms_manage_recordslist_v42.html';
						break;
					case 'sectionslist' :
						print 'co/cms_manage_sectionslist_v42.html';
						break;
					case 'watcheslist' :
						print 'co/cms_manage_watcheslist_v42.html';
						break;
					case 'categlist' :
						print 'co/cms_manage_categlist_v42.html';
						break;
					case 'menu' :
						print 'co/cms_manage_menu_v42.html';
						break;
					case 'record' :
						print 'co/cms_manage_record_v42.html';
						break;
					case 'tagcloud' :
						print 'co/cms_manage_tagcloud_v42.html';
						break;
					case 'piwik' :
						print 'co/cms_manage_piwik_v42.html';
						break;
					case 'portfolio' :
						print 'co/cms_manage_portfolio_v42.html';
						break;
					case 'search' :
						print 'co/cms_manage_search_v42.html';
						break;
					case 'section' :
						print 'co/cms_manage_section_v42.html';
						break;
					case 'watch' :
						print 'co/cms_manage_watch_v42.html';
						break;
					default :
						print 'co/cms_v42.html';
						break;						
    			}
    			break;
    			
//PORTAIL > NON DOCUMENTE
    		default :
    			print 'co/cms_v42.html';
    			break;
    				
    	}
    	break;

    
//ADMINISTRATION > -----------------------------------------------------------------------------
    case 'admin.php' :
	
	    switch ($categ) {
//ADMINISTRATION > ADMINISTRATION	    

//ADMINISTRATION > ADMINISTRATION > EXEMPLAIRES	    	
			case 'docs' :
				switch ($sub) {
					case 'typdoc' :
			    		print 'co/admin_docs_typdoc_v42.html';
						break;
					case 'location' :
			    		print 'co/admin_docs_location_v42.html';
						break;
					case 'sur_location' :
						print 'co/admin_docs_sur_location_v42.html';
						break;
					case 'section' :
			    		print 'co/admin_docs_section_v42.html';
						break;
					case 'statut' :
			    		print 'co/admin_docs_statut_v42.html';
						break;
					case 'codstat' :
			    		print 'co/admin_docs_codstat_v42.html';
						break;
					case 'lenders' :
			    		print 'co/admin_docs_lenders_v42.html';
						break;
					case 'perso' :
			    		print 'co/admin_docs_perso_v42.html';
						break;
					default :
			    		print 'co/administration_exemplaires_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > ADMINISTRATION > NOTICES	    
			case 'notices' :
				switch ($sub) {
					case 'orinot' :
			    		print 'co/admin_notices_orinot_v42.html';
						break;
					case 'statut' :
			    		print 'co/admin_notices_statut_v42.html';
						break;
					case 'map_echelle' :
						print 'co/admin_notices_map_echelle_v42.html';
						break;
 					case 'map_projection' :
 						print 'co/admin_notices_map_projection_v42.html';
 						break;
 					case 'map_ref' :
 						print 'co/admin_notices_map_ref_v42.html';
 						break;						
					case 'perso' :
			    	print 'co/admin_notices_perso_v42.html';
					break;
					case 'onglet' :
						print 'co/admin_notices_onglet_v42.html';
						break;
					case 'notice_usage' :
						print 'co/admin_notices_notice_usage_v42.html';
						break;
					default:
			    		print 'co/administration_notices_v42.html';
						break;
				}
				break;

//ADMINISTRATION > ADMINISTRATION > AUTORITES
			case 'authorities' :
				switch ($sub) {
					
					case 'origins' :
						print 'co/admin_authorities_origins_v42.html';
						break;
					case 'perso' :
						switch ($type_field) {
							case 'author' :
								print 'co/admin_authorities_perso_author_v42.html';
								break;
							case 'categ' :
								print 'co/admin_authorities_perso_categ_v42.html';
								break;
							case 'publisher' :
								print 'co/admin_authorities_perso_publisher_v42.html';
								break;
							case 'collection' :
								print 'co/admin_authorities_perso_collection_v42.html';
								break;
							case 'subcollection' :
								print 'co/admin_authorities_perso_subcollection_v42.html';
								break;
							case 'serie' :
								print 'co/admin_authorities_perso_serie_v42.html';
								break;
							case 'tu' :
								print 'co/admin_authorities_perso_tu_v42.html';
								break;
							case 'indexint' :
								print 'co/admin_authorities_perso_indexint_v42.html';
								break;
							default: 
								print 'co/administration_autorites_v42.html';
								break;
						}
						break;
					case 'authperso' :
						print 'co/admin_authorities_authperso_v42.html';
						break;
					case 'templates' :
						print 'co/admin_authorities_templates_v42.html';
						break;
					default :
						print 'co/administration_autorites_v42.html';
						break;
				}
				break;


//ADMINISTRATION > ADMINISTRATION > DOCUMENTS NUMERIQUES	
			case 'docnum' :
				switch ($sub) {
					case 'rep' :
			    		print 'co/admin_docnum_rep_v42.html';
			    		break;
					case 'storages' :
						print 'co/admin_docnum_storages_v42.html';
						break;
					case 'statut' :
						print 'co/admin_docnum_statut_v42.html';
						break;
					default :
			    		print 'co/administration_documents_numeriques_v42.html';										
			    		break;
				}
				break;

//ADMINISTRATION > ADMINISTRATION > ETATS COLLECTIONS
			case 'collstate' :
				switch ($sub) {
					case 'emplacement' :
			    		print 'co/admin_collstate_emplacement_v42.html';
			    		break;
					case 'support' :
			    		print 'co/admin_collstate_support_v42.html';
			    		break;
					case 'statut' :
			    		print 'co/admin_collstate_statut_v42.html';
			    		break;
					case 'perso' :
			    		print 'co/admin_collstate_perso_v42.html';
			    		break;
					default :
			    		print 'co/administration_etats_collections_v42.html';										
			    		break;
				}
				break;

//ADMINISTRATION > ADMINISTRATION > ABONNEMENTS
			case 'abonnements' :
				switch ($sub) {
					case 'periodicite' :
			    		print 'co/admin_abonnements_periodicite_v42.html';					
						break;
				default :
						print 'co/administration_abonnements_v42.html';					
						break;
				}
				break;
				
//ADMINISTRATION > ADMINISTRATION > LECTEURS
			case 'empr' :
				switch ($sub) {
					case 'categ' :
			    		print 'co/admin_empr_categ_v42.html';
						break;					
					case 'statut' :
			    		print 'co/admin_empr_statut_v42.html';
						break;
					case 'codstat' :
			    		print 'co/admin_empr_codstat_v42.html';
						break;
					case 'implec' :
			    		print 'co/admin_empr_implec_v42.html';
						break;
					case 'parperso' :
			    		print 'co/admin_empr_parperso_v42.html';
						break;
					default :
			    		print 'co/administration_lecteurs_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > ADMINISTRATION > UTILISATEURS				
			case 'users' :
				switch($sub) {
					case 'users' :
	    				print 'co/admin_users_users_v42.html';
	    				break;
					case 'groups' :
						print 'co/admin_users_groups_v42.html';
						break;
					default :
						print 'co/administration_utilisateurs_v42.html';
						break;
				}
	    		break;

//ADMINISTRATION > ADMINISTRATION > CONTENU EDITORIAL
			case 'cms_editorial' :
				switch ($sub) {
					case 'type' :
						switch ($elem) {
							case 'section' :
								print 'co/admin_cms_editorial_type_section_v42.html';
								break;
							case 'article' :
								print 'co/admin_cms_editorial_type_article_v42.html';
								break;
						}
						break;
					case 'publication_state' :
						print 'co/admin_cms_editorial_publication_state_v42.html';
						break;
					default :
						print 'co/administration_contenu_editorial_v42.html';
				}
				break;
	    		
//ADMINISTRATION > OPAC 
	    		
//ADMINISTRATION > OPAC > INFOPAGES
			case 'infopages' :
				print 'co/administration_infopages_v42.html';
				break;
//ADMINISTRATION > OPAC > RECHERCHES PREDEFINIES
			case 'opac' :
				switch($sub) {
					case 'search_persopac' :
						print 'co/admin_opac_search_persopac_v42.html';
						break;
//ADMINISTRATION > OPAC > NAVIGATION						
					case 'navigopac' :
						print 'co/administration_navigation_v42.html';
						break;
//ADMINISTRATION > OPAC > FACETTES
					case 'facette_search_opac' :
						print 'co/administration_facettes_v42.html';
						break;
//ADMINISTRATION > OPAC > STATISTIQUES						
					case 'stat' :
						print 'co/administration_statistiques_v42.html';
						break;
					default :
						print 'co/nodoc_v42.html';
						break;
				}
				break;
//ADMINISTRATION > OPAC > VISIONNEUSE
			case 'visionneuse' :
				switch($sub) {
					case 'class' :
						print 'co/admin_visionneuse_class_v42.html';
						break;
					case 'mimetype' :
						print 'co/admin_visionneuse_mimetype_v42.html';
						break;
					default :
						print 'co/administration_visionneuse_v42.html';
						break;
				}
				break;

//ADMINISTRATION > OPAC > VUES OPAC
			case 'opac_view' :
				switch ($section) {
					case 'list' :
						print 'co/admin_opac_opac_view_list_v42.html';
						break;
					case 'affect' :
						print 'co/admin_opac_opac_view_affect_v42.html';
						break;
					default :
						print 'co/administration_vues_opac_v42.html';
						break;
				}
				break;

//ADMINISTRATION > ACTIONS > PERSONNALISABLES
			case 'proc' :
				switch ($sub) {
					case 'proc' :
					default:
						print 'co/administration_actions_personnalisables_v42.html';
						break;
					case 'clas' :
						print 'co/administration_classements_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > NOMENCLATURES
			case 'family' :
				print 'co/administration_tutti_v42.html';
				break;
			case 'formation' :
				print 'co/administration_formations_v42.html';
				break;
			case 'voice' :
				print 'co/administration_voix_v42.html';
				break;
			case 'instrument' :
				print 'co/administration_instruments_v42.html';
				break;

//ADMINISTRATION > MODULES > QUOTAS 	    	
	    	case 'quotas' :
	    			print 'co/administration_quotas_v42.html';
	    		break;
	    		
//ADMINISTRATION > MODULES > CALENDRIER				
			case 'calendrier' :
	    		print 'co/admin_calendrier_v42.html';
	    		break;
	    		
//ADMINISTRATION > MODULES > GESTION FINANCIERE				
			case 'finance' :
				switch ($sub) {
					case 'abts' :
						print 'co/admin_finance_abts_v42.html';
						break;
					case 'prets' :
						print 'co/admin_finance_prets_v42.html';
						break;
					case 'amendes' :
						print 'co/admin_finance_amendes_v42.html';
						break;
					case 'amendes_relance' :
						print 'co/admin_finance_amendes_relance_v42.html';
						break;
					case 'blocage' :
						print 'co/admin_finance_blocage_v42.html';
						break;
					case 'transactype' :
						print 'co/admin_finance_transactype_v42.html';
						break;
					case 'cashdesk' :
						print 'co/admin_finance_cashdesk_v42.html';
						break;
					default:
	    				print 'co/administration_gestion_financiere_v42.html';
	    				break;
				}
				break;
				
//ADMINISTRATION > MODULES > IMPORTS				
			case 'import' :
				switch ($sub) {
					case 'import' :
			    		print 'co/admin_import_import_v42.html';
						break;
					case 'import_expl' :
			    		print 'co/admin_import_import_expl_v42.html';
						break;
					case 'pointage_expl' :
			    		print 'co/admin_import_pointage_expl_v42.html';
						break;
					case 'import_skos' :
						print 'co/admin_import_import_skos_v42.html';
						break;
					default:
			    		print 'co/administration_imports_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > MODULES > CONVERSIONS/EXPORT		
			case 'convert' :
				switch ($sub) {
					case 'import' :
			    		print 'co/admin_convert_import_v42.html';
						break;
					case 'export' :
			    		print 'co/admin_convert_export_v42.html';
						break;
					case 'paramgestion' :
			    		print 'co/admin_convert_paramgestion_v42.html';
						break;
					case 'paramopac' :
			    		print 'co/admin_convert_paramopac_v42.html';
						break;	
					default:
			    		print 'co/administration_conversions_exports_v42.html';
						break;
				}
				break;

//ADMINISTRATION > MODULES > RECOLTEUR
			case 'harvest' :
				switch ($sub) {
					case 'build' :
					case 'profil' :
					default :
						print 'co/administration_recolteur_v42.html';
						break;
	    		}				
				break;

//ADMINISTRATION > MODULES > OUTILS				

//ADMINISTRATION > MODULES > OUTILS > NETTOYAGE DE BASE
			case 'netbase' :
	    		print 'co/admin_netbase_v42.html';
				break;

//ADMINISTRATION > MODULES > OUTILS > VERIFICATION DES LIENS
			case 'chklnk' :
	    		print 'co/admin_chklnk_v42.html';			
				break;
 				
//ADMINISTRATION > MODULES > OUTILS > MAJ BASE				
			case 'alter' :
	    		print 'co/admin_alter_v42.html';
				break;

//ADMINISTRATION > MODULES > OUTILS					
			case 'misc' :
				switch ($sub) {
					case 'tables' :
			    		print 'co/admin_misc_tables_v42.html';
						break;
					case 'mysql' :
			    		print 'co/admin_misc_mysql_v42.html';
						break;
					default:
	    				print 'co/administration_outils_v42.html';
	    				break;
				}
				break;
			case 'param' :
	    		print 'co/admin_param_v42.html';
				break;
				
//ADMINISTRATION > MODULES > Z3950				
			case 'z3950' :
				switch ($sub) {
					case 'zbib' :
					case 'zattr' :
			    		print 'co/admin_z3950_zbib_v42.html';
						break;
					default:
			    		print 'co/administration_z3950_v42.html';
						break;
				}
				break;

//ADMINISTRATION > MODULES > SERVICES EXTERNES
				case 'external_services' :
					switch($sub) {
						case 'general' :
							print 'co/admin_external_services_general_v42.html';
							break;
						case 'peruser' :
							print 'co/admin_external_services_peruser_v42.html';
							break;
						case 'esusers' :
							print 'co/admin_external_services_esusers_v42.html';
							break;
						case 'esusergroups' :
							print 'co/admin_external_services_esusergroups_v42.html';
							break;
						default:
							print 'co/administration_services_externes_v42.html';
							break;
					}
				break;

//ADMINISTRATION > MODULES > CONNECTEURS
			case 'connecteurs' :
				switch ($sub) {
					case 'in' :
						print 'co/admin_connecteurs_in_v42.html';
						break;
					case 'categ' :
						print 'co/admin_connecteurs_categ_v42.html';
						break;
					case 'out' :
						print 'co/admin_connecteurs_out_v42.html';
						break;
					case 'out_auth' :
						print 'co/admin_connecteurs_out_auth_v42.html';
						break;
					case 'out_sets' :
						print 'co/admin_connecteurs_out_sets_v42.html';
						break;
					case 'categout_sets' :
						print 'co/admin_connecteurs_categout_sets_v42.html';
						break;
					case 'enrichment' :
						print 'co/admin_connecteurs_enrichment_v42.html';
						break;
					default:
						print 'co/administration_connecteurs_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > MODULES > SAUVEGARDE 			
			case 'sauvegarde' :
				switch ($sub) {
					case 'lieux' :
			    		print 'co/admin_sauvegarde_lieux_v42.html';
						break;
					case 'tables' :
			    		print 'co/admin_sauvegarde_tables_v42.html';
						break;
					case 'gestsauv' :
			    		print 'co/admin_sauvegarde_gestsauv_v42.html';
						break;
					case 'launch' :
			    		print 'co/admin_sauvegarde_launch_v42.html';
						break;
					case 'list' :
			    		print 'co/admin_sauvegarde_list_v42.html';
						break;
					default:
			    		print 'co/administration_sauvegarde_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > MODULES > ACQUISITIONS 					
			case 'acquisition' :
				switch ($sub) {
					case 'entite' :
			    		print 'co/admin_acquisition_entite_v42.html';
						break;
					case 'compta' :
			    		print 'co/admin_acquisition_compta_v42.html';
						break;
					case 'tva' :
						print 'co/admin_acquisition_tva_v42.html';
						break;	
					case 'type' :
			    		print 'co/admin_acquisition_type_v42.html';
						break;
					case 'frais' :
			    		print 'co/admin_acquisition_frais_v42.html';
						break;
					case 'mode' :
			    		print 'co/admin_acquisition_mode_v42.html';
						break;
					case 'budget' :
			    		print 'co/admin_acquisition_budget_v42.html';
						break;
					case 'categ' :
			    		print 'co/admin_acquisition_categ_v42.html';
						break;
 					case 'src' :
			    		print 'co/admin_acquisition_src_v42.html';
 						break;
 					case 'lgstat' :
 						print 'co/admin_acquisition_lgstat_v42.html';
 						break;
					default:
			    		print 'co/administration_acquisitions_v42.html';
						break;
				}
				break;
				
//ADMINISTRATION > MODULES > TRANSFERTS
			case 'transferts' :
				switch ($sub) {
					case 'general' :
			    		print 'co/admin_transferts_general_v42.html';
			    		break;
					case 'circ' :
			    		print 'co/admin_transferts_circ_v42.html';
						break;
					case 'opac' :
			    		print 'co/admin_transferts_opac_v42.html';					
						break;
					case 'ordreloc' :
			    		print 'co/admin_transferts_ordreloc_v42.html';					
						break;
					case 'statutsdef' :
			    		print 'co/admin_transferts_statutsdef_v42.html';										
						break;
					case 'purge' :
			    		print 'co/admin_transferts_purge_v42.html';										
						break;
					default:
			    		print 'co/administration_transferts_v42.html';
						break;
				}
			break;

//ADMINISTRATION > MODULES > DROITS D'ACCES
			case 'acces' :
				switch ($sub) {
					case 'domain' :
						switch ($id) {
							case '1' :
								print 'co/admin_acces_domain_user_notice_v42.html';
								break;
							case '2' :
								print 'co/admin_acces_domain_empr_notice_v42.html';
								break;
							case '3' :
								print 'co/admin_acces_domain_empr_docnum_v42.html';
								break;
							default:
								print 'co/administration_droits_d_acces_v42.html';
								break;
						}
						break;
						
					case 'user_prf' :
						switch ($id) {
							case '1' :
								print 'co/admin_acces_user_prf_user_notice_v42.html';
								break;
							case '2' :
								print 'co/admin_acces_user_prf_empr_notice_v42.html';
								break;
							case '3' :
								print 'co/admin_acces_user_prf_empr_docnum_v42.html';
								break;
							default:
								print 'co/administration_droits_d_acces_v42.html';
								break;
						}
						break;
					case 'res_prf' :
						switch ($id) {
							case '1' :
								print 'co/admin_acces_res_prf_user_notice_v42.html';
								break;
							case '2' :
								print 'co/admin_acces_res_prf_empr_notice_v42.html';
								break;
							case '3' :
								print 'co/admin_acces_res_prf_empr_docnum_v42.html';
								break;
							default:
								print 'co/administration_droits_d_acces_v42.html';
								break;
						}
						break;
				default:
					print 'co/administration_droits_d_acces_v42.html';
					break;
				}
			break;
 				
//ADMINISTRATION > MODULES > EDITEUR HTML
 			case 'html_editor' :
    		print 'co/admin_html_editor_v42.html';
 			break;

//ADMINISTRATION > MODULES > DEMANDES		
			case 'demandes' :
				switch ($sub) {
					case 'theme' :
						print 'co/admin_demandes_theme_v42.html';
						break;
					case 'type' :
						print 'co/admin_demandes_type_v42.html';
						break;
					case 'perso' :
						print 'co/admin_demandes_perso_v42.html';
						break;
					default:
						print 'co/administration_demandes_v42.html';
						break;
				}
			break;

//ADMINISTRATION > MODULES > FAQ
			case 'faq' :
				switch ($sub) {
					case 'theme' :
						print 'co/admin_faq_theme_v42.html';
						break;
					case 'type' :
						print 'co/admin_faq_type_v42.html';
						break;
					default:
						print 'co/administration_faq_v42.html';
						break;
				}
				break;
			
//ADMINISTRATION > MODULES > TEMPLATE DE MAIL
			case 'mailtpl' :
				switch ($sub) {
					case 'build' :
					case 'img' :
					default:
						print 'co/administration_template_de_mail_v42.html';
						break;
				}
				break;

//ADMINISTRATION > MODULES > NON DOCUMENTE				
			default:
				print 'co/guide_complet_web_section_administration_v42.html';
				break;
		}
        break;

        
        
//NON DOCUMENTE        
    default:
        print 'co/nodoc_v42.html';
        break;
        }
?>
