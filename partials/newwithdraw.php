<?php

?>
<form id="sendwithdraw">
<div class="modal fade newmodal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?=$lang['restaurant']['new_withdraw']?>
					<br /><small><?=$lang['restaurant']['with_balance']?> <b><?=dollar_sign.us_balance?></b></small></h4>

        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
				<div class="form-row">
					<div class="col-4">
						<div class="form-group">
							<label><?=$lang['restaurant']['with_amount']?> <small class="text-danger">*</small></label>
							<input type="text" class="money" name="amount" placeholder="<?=$lang['restaurant']['with_amount']?>">
						</div>
					</div>
					<div class="col-8">
						<div class="form-group">
							<label><?=$lang['restaurant']['with_email']?> <small class="text-danger">*</small></label>
								<input type="text" name="email" placeholder="<?=$lang['restaurant']['with_email']?>">
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
