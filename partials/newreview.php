<form id="sendreview">
<div class="modal fade newmodal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?=$lang['restaurant']['review_create']?></h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>

      <div class="modal-body">
				<div class="form-group">
					<label><?=$lang['restaurant']['review_title']?> <small class="text-danger">*</small></label>
					<input type="text" name="title" placeholder="Review Title">
				</div>
				<div class="form-group">
					<label><?=$lang['restaurant']['review_rate']?> <small class="text-danger">*</small></label>
					<div class="pt-rating">
		       <input type="radio" name="rating" value="1" aria-label="1 star" required/>
					 <input type="radio" name="rating" value="2" aria-label="2 stars"/>
					 <input type="radio" name="rating" value="3" aria-label="3 stars"/>
					 <input type="radio" name="rating" value="4" aria-label="4 stars"/>
					 <input type="radio" name="rating" value="5" aria-label="5 stars"/>
		     </div>
				</div>
				<div class="form-group">
					<label><?=$lang['restaurant']['review_content']?></label>
					<textarea name="content"></textarea>
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
