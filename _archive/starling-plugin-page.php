<div class="wrap">
<h2>Starling for engagement</h2>
<style>
	thead.fixed {position: fixed; top:30px; background:#fff; }
	thead.fixed tr {width: 100%; }
	.callout h2 {font-size: 18px;}
	.callout {background: #ccc; margin:10px  0;}
	.callout > form { display:border-box;margin:0 10px; }
	#overlay {position: absolute; top:0; left:0; bottom:0; right:0; height: 100%; background: rgba(0,0,0,.1);}
	#overlay div {  position: absolute; z-index: 999999;}
	#overlay div ul { background: #fff;padding:5px 0; margin:0; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,.1); }
	#overlay div ul ul  {display:none; background: #fff; }
	#overlay div li {padding:0; margin:0; position: relative; width: 12em; }
	#overlay div li:hover > a {background: #333;color: #fff;}
	#overlay div li a {padding: .5em .75em; display:block; color: #333; text-decoration:none; font-size: 14px;}
	#overlay div li:hover > ul  {display:block; position: absolute; left: 100%; top:0;}
	</style> 

<? 

	include "import_csv.php";
	
 
?>
  <script>var ajaxurl = <?=admin_url('admin-ajax.php')?>;</script>
  <table class="widefat fixed" id="sharecsv" cellspacing="0">
    <thead>
    <tr width="100%">
            <th id="columnname" class="manage-column column-columnname" scope="col"  width="20%">Post date</th>
            <th id="columnname" class="manage-column column-columnname" scope="col" width="20%">Media</th>
            <th id="columnname" class="manage-column column-columnname" scope="col" width="40%">Content</th>
            <th id="columnname" class="manage-column column-columnname" scope="col" width="20%">Status</th>
    </tr>
    </thead>
    <tfoot>
    <tr>

            <th class="manage-column column-columnname" scope="col"></th>
            <th class="manage-column column-columnname" scope="col"></th>
            <th class="manage-column column-columnname" scope="col"></th>
            <th class="manage-column column-columnname" scope="col"></th>

    </tr>
    </tfoot>
    <tbody>
    
    
     <? global $wpdb;
 $result = $wpdb->get_results('SELECT * FROM wp_sharecsv ORDER BY postdate ASC');
 $i = 0;
 foreach($result as $row){
 	echo ($i%2==0) ? "<tr data-id=\"{$row->id}\">" : "<tr data-id=\"{$row->id}\" class=\"alternate\">";
 	echo "<td>{$row->postdate}</td>";
 	echo ($row->media <>"") ? "<td><span class=\"dashicons dashicons-format-image\"></span> <a href=\"" . get_admin_url() . "admin-post.php?action=share_csv_remove_media&id={$row->id}\" data-id=\"{$row->id}\" class=\"remove-media\">Remove</a></td>" : "<td><a data-id=\"{$row->id}\" class=\"add-media\" href=\"#\">Add media</a></td>";
 	echo "<td><div data-editable=\"true\" data-field=\"content\">{$row->content}</div>";
 	
 	echo "</td> <td>{$row->status}</td></tr>";
 	$i++;
 	}
 
 
  ?>
    
    	
    	</tbody>





</div>