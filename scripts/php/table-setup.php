<?

global $wpdb;

$table_name = $wpdb->prefix . "jump_links";
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  guid varchar(8) NOT NULL,
  title varchar(128) NOT NULL,
  url varchar(250) NOT NULL,
  count bigint(11) NOT NULL,
  timestamp timestamp DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY id (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
