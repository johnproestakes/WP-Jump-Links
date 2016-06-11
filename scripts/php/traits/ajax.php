<?
namespace JumpLinks;

trait Ajax {
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

  public function ajax_insert_new_url(){
    global $wpdb;

    $params = json_decode(file_get_contents('php://input'));
    $guid = $this->generate_guid($this->guid_pattern);
    $wpdb->insert($wpdb->prefix."jump_links", array(
      "url"=>$params->url,
      "title"=>$params->title,
      "guid"=>$guid
    ));
    $output = array('guid'=>$guid);
    if(!$wpdb->insert_id){
      $output['errors'] = "Did not work, try again later.";
    } else {
      $output['id'] = $wpdb->insert_id;
      $output['url'] = site_url() . "/" . $guid;
      $output['title'] = $params->title;
    }
    header('content-type: application/json');
    echo json_encode($output);
    wp_die();

  }


}
