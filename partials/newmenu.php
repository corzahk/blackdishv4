<?php


if( page == "dashboard" ){
	$sql_where = "";
	$form_modal = true;
} else {
	$sql_where = "WHERE author = '".us_id."'";
	$form_modal = true;
}
?>
<form id="sendmenu">
<div class="modal fade newmodal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?=$lang['restaurant']['new_menu']?></h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<label><?=$lang['restaurant']['menu_name']?> <small class="text-danger">*</small></label>
							<input type="text" name="name" placeholder="<?=$lang['restaurant']['menu_name']?>">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label><?=$lang['restaurant']['menu_restaurant']?> <small class="text-danger">*</small></label>
							<select class="selectpicker" data-live-search="true" data-width="100%" name="rest" title="<?=$lang['restaurant']['menu_restaurant_l']?>">
								<?php
								$sql = $db->query("SELECT id, name FROM ".prefix."restaurants {$sql_where} ORDER BY name ASC");
								if($sql->num_rows):
								while($rs = $sql->fetch_assoc()):
								?>
								<option data-tokens="<?=$rs['name']?>" value="<?=$rs['id']?>"><?=$rs['name']?></option>
								<?php
								endwhile;
								endif;
								$sql->close();
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="pt-msg"></div>
      </div>

      <div class="modal-footer">
				<input type="hidden" name="id">
        <button type="submit" class="pt-btn"><?=$lang['restaurant']['btn']?></button>
      </div>

    </div>
  </div>
</div>
</form>
