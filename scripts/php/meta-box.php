


  <script>
  window.angular || document.writeln('<script'+' src="<?=$plugin_url?>scripts/js/libs/angular.min.js" type="text/javascript"></'+'script>');
    var ajaxurl = "<?=get_admin_url()?>admin-ajax.php";
    var jecPostId = <?=$post->ID?>;
    </script>
<style>
  #JumpLinksMetaBox label {display:block}
  #JumpLinksMetaBox input {width: 100%;}
</style>

  <script type="text/javascript" src="<?=$plugin_url?>scripts/js/meta-box.js"></script>

  <aside

    id="JumpLinksMetaBox"
    ng-controller="JumpLinksController"
    ng-cloak>

    <p>
      <label>Title</label>
    <input type="text" ng-model="form.title"/></p>

    <p>
    <label>URL</label>
    <input type="text" ng-model="form.url"/>
  </p>

    <button type="button" class="button" ng-click="insertUrl()">Create</button>

    <div ng-repeat="item in generated">
      {{item}}
      </div>
  </aside>

  <script>angular.bootstrap(document.getElementById('JumpLinksMetaBox'), ['JumpLinksMetaBox']);</script>
