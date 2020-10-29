<?php

?>

<div class="pt-breadcrumb">
	<div class="pt-title">
		<i class="icon-layers icons ic"></i> <?=$lang['header']['plans']?>
		<p>
			<a href="<?=path?>"><?=$lang['header']['dashboard']?></a> <i class="fas fa-long-arrow-alt-right"></i> <?=$lang['header']['plans']?>
		</p>
	</div>
</div>


<div class="pt-plans">
	<form id="sendplans">
		<div class="pt-box">
				<input class="tgl tgl-light" id="cb1" value="1" name="site_plans" type="checkbox"<?=(site_plans ? ' checked' : '')?>/>
				<label class="tgl-btn" for="cb1"></label>
				<label><?=$lang['dash']['p_disacticate']?></label>
		</div>
		<div class="row">
			<?php
			$sql = $db->query("SELECT * FROM ".prefix."plans");
			while($rs = $sql->fetch_assoc()):
			?>
	    <div class="col-3">
				<div class="pt-box">
				<?php foreach ($rs as $key => $value): ?>
					<?php if(!in_array($key, ['id', 'created_at', 'invoices', 'statistics', 'export_statistics', 'show_ads', 'stripe', 'support'])): ?>
					<label class="mb-2"> <?php if(in_array($key, ['restaurants', 'menus', 'items', 'orders'])): ?><b><?=ucfirst($key)?></b> <?php endif;?>
						<input type="text" name="<?=$key?>[<?=$rs['id']?>]" placeholder="plan <?=$key?>" value="<?=$value?>">
					</label>
					<?php endif;?>
					<?php if(in_array($key, ['invoices', 'statistics', 'export_statistics', 'show_ads', 'stripe', 'support'])): ?>
						<div class="mb-3">
							<input class="tgl tgl-light" id="<?=$key.$rs['id']?>" value="1"type="checkbox" name="<?=$key?>[<?=$rs['id']?>]"<?=($value==1?'checked':'')?>/>
							<label class="tgl-btn" for="<?=$key.$rs['id']?>"></label>
							<label><label><?=str_replace('_',' ',$key)?></label></label>
						</div>

					<?php endif;?>
				<?php endforeach;?>
	    </div>
	    </div>
			<?php
			endwhile;
			$sql->close();
			?>
		</div>
		<div>
			<button type="submit" class="pt-btn">
				<span><?=$lang['send']?> <i class="fas fa-arrow-circle-right"></i></span>
			</button>
		</div>
  </form>
</div>
