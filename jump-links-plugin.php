<?php
/**
 * @package JJP_ShareCSV_Plugin
 * @version 1
 */
/*
	Plugin Name: Jump Links (JJP)
	Plugin URI: http://apps.omorphos.com/share-csv
	Description: share-csv
	Author: John Proestakes
	Version: 1
	Author URI: http://johnproestakes.com/
*/

	//if (session_status() !== PHP_SESSION_ACTIVE) { session_start();}



	class JJP_JumpLinks_Plugin {

		public function is_bot($user_agent){
			return preg_match(
			'/(abot|dbot|ebot|hbot|kbot|lbot|mbot|nbot|obot|pbot|rbot|sbot|tbot|vbot|ybot|zbot|bot\.|bot\/|_bot|\.bot|\/bot|\-bot|\:bot|\(bot|crawl|slurp|spider|seek|accoona|acoon|adressendeutschland|ah\-ha\.com|ahoy|altavista|ananzi|anthill|appie|arachnophilia|arale|araneo|aranha|architext|aretha|arks|asterias|atlocal|atn|atomz|augurfind|backrub|bannana_bot|baypup|bdfetch|big brother|biglotron|bjaaland|blackwidow|blaiz|blog|blo\.|bloodhound|boitho|booch|bradley|butterfly|calif|cassandra|ccubee|cfetch|charlotte|churl|cienciaficcion|cmc|collective|comagent|combine|computingsite|csci|curl|cusco|daumoa|deepindex|delorie|depspid|deweb|die blinde kuh|digger|ditto|dmoz|docomo|download express|dtaagent|dwcp|ebiness|ebingbong|e\-collector|ejupiter|emacs\-w3 search engine|esther|evliya celebi|ezresult|falcon|felix ide|ferret|fetchrover|fido|findlinks|fireball|fish search|fouineur|funnelweb|gazz|gcreep|genieknows|getterroboplus|geturl|glx|goforit|golem|grabber|grapnel|gralon|griffon|gromit|grub|gulliver|hamahakki|harvest|havindex|helix|heritrix|hku www octopus|homerweb|htdig|html index|html_analyzer|htmlgobble|hubater|hyper\-decontextualizer|ia_archiver|ibm_planetwide|ichiro|iconsurf|iltrovatore|image\.kapsi\.net|imagelock|incywincy|indexer|infobee|informant|ingrid|inktomisearch\.com|inspector web|intelliagent|internet shinchakubin|ip3000|iron33|israeli\-search|ivia|jack|jakarta|javabee|jetbot|jumpstation|katipo|kdd\-explorer|kilroy|knowledge|kototoi|kretrieve|labelgrabber|lachesis|larbin|legs|libwww|linkalarm|link validator|linkscan|lockon|lwp|lycos|magpie|mantraagent|mapoftheinternet|marvin\/|mattie|mediafox|mediapartners|mercator|merzscope|microsoft url control|minirank|miva|mj12|mnogosearch|moget|monster|moose|motor|multitext|muncher|muscatferret|mwd\.search|myweb|najdi|nameprotect|nationaldirectory|nazilla|ncsa beta|nec\-meshexplorer|nederland\.zoek|netcarta webmap engine|netmechanic|netresearchserver|netscoop|newscan\-online|nhse|nokia6682\/|nomad|noyona|nutch|nzexplorer|objectssearch|occam|omni|open text|openfind|openintelligencedata|orb search|osis\-project|pack rat|pageboy|pagebull|page_verifier|panscient|parasite|partnersite|patric|pear\.|pegasus|peregrinator|pgp key agent|phantom|phpdig|picosearch|piltdownman|pimptrain|pinpoint|pioneer|piranha|plumtreewebaccessor|pogodak|poirot|pompos|poppelsdorf|poppi|popular iconoclast|psycheclone|publisher|python|rambler|raven search|roach|road runner|roadhouse|robbie|robofox|robozilla|rules|salty|sbider|scooter|scoutjet|scrubby|search\.|searchprocess|semanticdiscovery|senrigan|sg\-scout|shai\'hulud|shark|shopwiki|sidewinder|sift|silk|simmany|site searcher|site valet|sitetech\-rover|skymob\.com|sleek|smartwit|sna\-|snappy|snooper|sohu|speedfind|sphere|sphider|spinner|spyder|steeler\/|suke|suntek|supersnooper|surfnomore|sven|sygol|szukacz|tach black widow|tarantula|templeton|\/teoma|t\-h\-u\-n\-d\-e\-r\-s\-t\-o\-n\-e|theophrastus|titan|titin|tkwww|toutatis|t\-rex|tutorgig|twiceler|twisted|ucsd|udmsearch|url check|updated|vagabondo|valkyrie|verticrawl|victoria|vision\-search|volcano|voyager\/|voyager\-hc|w3c_validator|w3m2|w3mir|walker|wallpaper|wanderer|wauuu|wavefire|web core|web hopper|web wombat|webbandit|webcatcher|webcopy|webfoot|weblayers|weblinker|weblog monitor|webmirror|webmonkey|webquest|webreaper|websitepulse|websnarf|webstolperer|webvac|webwalk|webwatch|webwombat|webzinger|wget|whizbang|whowhere|wild ferret|worldlight|wwwc|wwwster|xenu|xget|xift|xirq|yandex|yanga|yeti|yodao|zao\/|zippp|zyborg|\.\.\.\.)/i', $user_agent);
		}

		public function track($id){
			//update table set clicks = click + 1;
			if (isset($_SERVER['HTTP_USER_AGENT']) && !$this->is_bot($_SERVER["HTTP_USER_AGENT"])) {
				global $wpdb;
				$wpdb->query(
				$wpdb->prepare("UPDATE {$wpdb->prefix}jump_links SET count = count + 1 WHERE id=%d", $id));
		  } else {

			}

		}
		public function redirect($url){
			//finds entry in database and then redirects;
			wp_redirect($url, '301');
			//Header('location: '.$url);
		}
		public function locate_url($guid){
			$output = "";
			global $wpdb;
			$results = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM {$wpdb->prefix}jump_links WHERE guid=%s LIMIT 1", $guid));
			if($results){
				foreach($results as $result){
					$this->track($result->id);
					$output = $result->url;

				}
			}


			return $output;
		}
		public function activation_hook(){
			require "scripts/php/table-setup.php";
		}
		public function generate_guid($str){
			$alph = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
			$a = str_split($str);
			$output = "";
			foreach($a as $k => $char){
				switch($char){
					case "a":
						$output .= $alph[rand(0,count($alph))];
					break;
					case "#":
						$output .= rand(0,9);
					break;
					case "x":
						if(!rand(0,1)){
							$output .= $alph[rand(0,count($alph))];
						} else {
							$output .= rand(0,9);
						}
					break;

				}
			}
			return $output;
		}

		public function ajax_insert_new_url(){
			global $wpdb;
			$params = json_decode(file_get_contents('php://input'));
			$guid = $this->generate_guid("a#xxxxxx");
			$wpdb->insert($wpdb->prefix."jump_links", array(
				"url"=>$params->url,
				"title"=>$params->title,
				"guid"=>$guid
			));
			$output = array();
			if(!$wpdb->insert_id){
				$output['errors'] = "Did not work, try again later.";
			} else {

			}
			header('content-type: application/json');
			echo json_encode($output);
			wp_die();

		}




		public function ajax_update_id(){
			global $wpdb;
			$params = json_decode(file_get_contents('php://input'));

			$wpdb->update(
				$wpdb->prefix . "jump_links",
				array(
					'url' => $params->url,	// string
					'title' => $params->title	// integer (number)
				),
				array( 'id' => $_GET['id'] ),
				array(
					'%s',	// value1
					'%s'	// value2
				),
				array( '%d' )
			);

			header('content-type: application/json');

			wp_die();

		}

		public function ajax_get_id(){
			global $wpdb;
			$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$wpdb->prefix}jump_links WHERE id=%s"
				, $_GET['id'])
			);
			header('content-type: application/json');
			echo json_encode($results);
			wp_die();

		}

		public function ajax_remove_id(){
			global $wpdb;
			$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->prefix}jump_links WHERE id=%s"
				, $_GET['id'])
			);
			header('content-type: application/json');
			echo json_encode(array());
			wp_die();

		}


		public function ajax_get_url_list(){
			global $wpdb;

			$output = array('count'=>0);

			$results = $wpdb->get_results(
				"SELECT count(id) as id_count FROM {$wpdb->prefix}jump_links"
			);

			$max = 7;
			if(isset($_GET['pageid'])){
				$offset = intval($_GET['pageid'])*$max;
			} else {
				$offset = "0";
			}

			$output['count'] = intval($results[0]->id_count);

			if(intval($results[0]->id_count) <= $max){
				$output['pages'] = 1;
				$limit = "";
			} else {
				$output['pages'] = intval($results[0]->id_count) % $max == 0 ?
				floor(intval($results[0]->id_count) / $max) : floor(intval($results[0]->id_count) / $max)+1;
				$limit = " LIMIT $offset, $max";
			}

			$sortby = isset($_GET['sortby']) ? $_GET['sortby'] : "timestamp";
			$order = isset($_GET['sort']) ? $_GET['sort'] : "DESC";

			$output['results'] = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}jump_links ORDER BY $sortby $order".$limit
			);

			header('content-type: application/json');
			echo json_encode($output);
			wp_die();

		}





		public function detect(){
			//print_r($_SERVER);
			if(isset($_SERVER['REQUEST_URI'])
			&& $_SERVER['REQUEST_URI']) {
				$subject = "abcdef";
				$pattern = '/([A-Za-z]{1}[0-9]{1}([a-zA-Z0-9]{1}){6})/';
				preg_match($pattern, $_SERVER['REQUEST_URI'], $matches, PREG_OFFSET_CAPTURE, 0);

				if(isset($matches[0]) && isset($matches[0][0])){

					$url = $this->locate_url($matches[0][0]);
					if($url){
						$this->redirect($url);
						die();
					}
				}

			}
		}
		public function render_plugin_page(){
			$plugins_url = plugins_url('/',__FILE__);
			include "scripts/php/plugin-page.php";
		}
		public function create_plugin_page(){
			add_menu_page('Jump Links', 'Jump Links', 'read', 'jump-links-jjp', array($this, 'render_plugin_page'), 'dashicons-cloud');
				//add_action( 'admin_init', array($this, 'register_settings') );

				if(is_admin() && isset($_GET['page']) && $_GET['page']=="jump-links-jjp"){
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_style('thickbox');
					wp_enqueue_script('jquery');

					}
		}

		function __construct(){
			// /die('we started');
			add_action('admin_menu', array($this, "create_plugin_page"));
			register_activation_hook( __FILE__, array($this, 'activation_hook') );
			add_action('init', array($this,'detect'));
			add_action('wp_ajax_jump_links_get_list', array($this, 'ajax_get_url_list'));
			add_action('wp_ajax_jump_links_get_id', array($this, 'ajax_get_id'));
			add_action('wp_ajax_jump_links_rm_id', array($this, 'ajax_remove_id'));
			add_action('wp_ajax_jump_links_update_id', array($this, 'ajax_update_id'));

			add_action('wp_ajax_jump_links_insert_url', array($this, 'ajax_insert_new_url'));


			}
		}

	$Plugin_JumpLinks = new JJP_JumpLinks_Plugin();


//create table
//detect
//record
//redirect
