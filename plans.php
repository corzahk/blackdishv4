<?php


include __DIR__."/header.php";
?>
<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['plans']['title']?></h3>
		<p><?=$lang['plans']['desc']?></p>
	</div>
</div>

<div class="container">

<div class="pt-plans">
<div class="row">
	<?php
	$sql = $db->query("SELECT * FROM ".prefix."plans");
	while($value = $sql->fetch_assoc()):
	?>
		<div class="col">
			<div class="pt-plan">
				<h5><?=$value['plan']?></h5>
				<h6><span><?=dollar_sign?></span><b><?=$value['price']?></b></h6>
				<p><?=$lang['plans']['month']?></p>
				<form class="sendpaypalplan">
					<input type="hidden" name="item_name" value="<?=$value['plan']?>">
					<input type="hidden" name="item_number" value="Plan#<?=$value['id']?>">
					<?php if (!us_level): ?>
						<button type="button" name="button" data-toggle="modal" href="#loginModal"><?=$lang['plans']['btn']?> <i class="fas fa-arrow-alt-circle-right"></i></button>
					<?php else: ?>
						<button type="submit" name="button"><?=$lang['plans']['btn']?> <i class="fas fa-arrow-alt-circle-right"></i></button>
					<?php endif; ?>
				</form>
				<ul>
					<?php
					$value['specifics'] = [
						[$value['desc1'], 'green', '1'],
						[$value['desc2'], '', '1'],
						[$value['desc3'], '', '1'],
						[$value['desc4'], '', '1'],
						[$value['desc5'], '', '1'],
						[$value['desc6'], '', $value['statistics']],
						[$value['desc7'], '', $value['export_statistics']],
						[$value['desc8'], '', $value['invoices']],
						[$value['desc9'], '', $value['support']]
					];
					foreach ($value['specifics'] as $v):
						?>
						<li<?=($v[1] == 'green' ?' class="alert-success"' :'')?>>
							<span><i class="fas fa-<?=($v[2]=='1'?'check' :'times')?>"></i></span> <?=$v[0]?>
						</li>
						<?php
					endforeach;
					?>
				</ul>
			</div>
		</div>
		<?php
	endwhile;
	?>
</div>
</div>


</div>
<?php
include __DIR__."/footer.php";
?>
