<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="fas fa-utensils ic"></i> Cuisines
		<p>
			<a href="<?=path?>">Dashboard</a> <i class="fas fa-long-arrow-alt-right"></i> Cuisines
		</p>
	</div>

	<div class="pt-options">
		<a data-toggle="modal" href="#myModal" class="pt-btn"><i class="fas fa-plus"></i> Create a Cuisine</a>
	</div>
</div>


<div class="pt-resaurants">
	<div class="pt-resaurant">
		<table class="table">
			<thead>
				<th colspan="2">Cuisine name</th>
				<th class="text-center">Items</th>
				<th class="text-center">Restaurants</th>
				<th class="text-center">Created at</th>
				<th class="text-center">Updated at</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."cuisines ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<tr>
					<th width="1"><div class="pt-thumb"><img src="<?=path?>/<?=$rs['image']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'"></div></th>
					<td width="40%">
						<h3><a href="<?=path?>/cuisines.php?id=<?=$rs['id']?>&t=<?=fh_seoURL($rs['name'])?>"><?=$rs['name']?></a></h3>
					</td>
					<td class="text-center"><?php echo db_rows("items WHERE cuisine = '{$rs["id"]}'") ?></td>
					<td class="text-center"><?php echo db_rows("restaurants WHERE FIND_IN_SET('".$rs["id"]."', cuisine) > 0") ?></td>
					<td class="text-center"><?=fh_ago($rs['created_at'])?></td>
					<td class="text-center"><?=($rs['updated_at']?fh_ago($rs['updated_at']):'--')?></td>
					<td class="pt-dot-options">
						<a class="pt-options-link"><i class="fas fa-ellipsis-h"></i></a>
						<ul class="pt-drop">
							<li><a data-toggle="modal" href="#myModal" class="pt-editcuisinelink" data-id="<?=$rs['id']?>"><i class="far fa-edit"></i> Edit</a></li>
							<li><a href="#" class="pt-delete" data-type="cuisine" data-id="<?=$rs['id']?>"><i class="fas fa-trash-alt"></i> Delete</a></li>
						</ul>
					</td>
				</tr>
				<?php endwhile; ?>
				<?php else: ?>
					<tr>
						<td colspan="7" class="text-center"><?=$lang['alerts']['no-data']?></td>
					</tr>
				<?php endif; ?>
				<?php $sql->close(); ?>
			</tbody>
		</table>
	</div>
	<?php echo fh_pagination("cuisines",$limit, path."/dashboard.php?pg=cuisines&") ?>
</div>



<!-- The Modal -->
<form id="sendcuisine">
<div class="modal fade newmodal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Create a Cuisine:</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">
				<div class="form-group pt-imginp">
					<label>Cuisine Name:</label>
					<input type="text" name="name" placeholder="Cuisine name">
					<input type="hidden" name="image" rel="#dropZone" value="">
					<div class="file-upload">
					  <div class="file-select">
					    <div class="file-select-button" id="fileName"><i class="fas fa-images"></i></div>
					    <input type="file" name="chooseFile" id="chooseFile" rel="answerfile">
					  </div>
					</div>
					<div id="thumbnails" class="thumbnails"></div>
				</div>
				<div class="pt-msg"></div>
      </div>
      <div class="modal-footer">
				<input type="hidden" name="id">
        <button type="submit" class="pt-btn">Send</button>
      </div>
    </div>
  </div>
</div>
</form>
