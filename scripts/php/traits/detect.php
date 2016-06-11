<?

namespace JumpLinks;


trait Detect {

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



  public function detect(){
    //print_r($_SERVER);
    if(isset($_SERVER['REQUEST_URI'])
    && $_SERVER['REQUEST_URI']) {
      $subject = "abcdef";
      preg_match('/([A-Za-z]{1}[0-9]{1}([a-zA-Z0-9]{1}){6})/', $_SERVER['REQUEST_URI'], $matches, PREG_OFFSET_CAPTURE, 0);

      if(isset($matches[0]) && isset($matches[0][0])){

        $url = $this->locate_url($matches[0][0]);
        if($url){
          $this->redirect($url);
          die();
        }
      }

    }
  }

}
