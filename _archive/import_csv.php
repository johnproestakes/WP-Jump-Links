<?php $frmAction = get_admin_url()."admin-post.php";?> 
<div class="callout"><form method="post" enctype="multipart/form-data" action="<? echo $frmAction; ?>">
<h2>Upload your CSV file.</h2>
<input size='50' type='file' name='filename'>
<input name="action" value="import_csv_submit_form" type="hidden"/>
<?php submit_button('Upload CSV File'); ?>
</form></div>