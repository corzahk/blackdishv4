<?php


include __DIR__."/header.php";


if($id):
$rs = db_rs("restaurants WHERE id = '{$id}'");
$rs["working_hours"] = $rs["working_hours"] ? json_decode($rs["working_hours"], true) : [];


function TimeIsBetweenTwoTimes($from, $till, $input) {
	$date1 = DateTime::createFromFormat('H:i a', $from);
	$date2 = DateTime::createFromFormat('H:i a', $till);
	$date3 = DateTime::createFromFormat('H:i a', $input);
	if ($date1 > $date2 && $date1 < $date3) return true;
	else return false;
}


$current_time = date("g:i A");
$from_time    = isset($rs["working_hours"][date("N")][0]) ? $rs["working_hours"][date("N")][0] : '';
$to_time      = isset($rs["working_hours"][date("N")][1]) ? $rs["working_hours"][date("N")][1] : '';

?>

<?php if ($rs['cover']): ?>
<style>.pt-restaurantspage .pt-restaurant-head:before {background-image: url(<?=path.'/'.$rs['cover']?>)}</style>
<?php endif; ?>
<div class="container">
	<div class="pt-restaurant-head">
		<div class="pt-dtable">
			<div class="pt-vmiddle">
				<div class="pt-profile">
					<div class="pt-thumb">
						<img src="<?=path.'/'.$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'">
						<?php if (TimeIsBetweenTwoTimes($current_time, $from_time, $to_time)): ?>
							<span><?=$lang['restaurant']['open']?></span>
						<?php else: ?>
							<span class="bg-danger"><?=$lang['restaurant']['close']?></span>
						<?php endif; ?>

					</div>
					<div class="pt-name"><h1><?=$rs['name']?></h1></div>
					<div class="pt-stars"><?php echo fh_stars($rs['id'], "restaurant") ?></div>
					<div class="pt-address"><i class="fas fa-map-marker-alt"></i> <?=$rs['address']?></div>
				</div>
			</div>
		</div>
	</div>
	<?php if (!$rs['neworders']): ?>
	<div class="alert alert-danger"><?=$lang['restaurant']['sorry']?></div>
	<?php endif; ?>

	<div class="row">
		<div class="col-8">
			<div class="pt-restaurant-body">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home"><?=$lang['restaurant']['menu']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1"><?=$lang['restaurant']['reviews']?></a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2"><?=$lang['restaurant']['album']?></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active container" id="home">
						<?php
						$sql = $db->query("SELECT name, id FROM ".prefix."menus WHERE restaurant = '{$id}'");
						if($sql->num_rows):
						$i = 0;
						while($rs_m = $sql->fetch_assoc()):
							$i++;
						?>
							<div class="pt-resaurant<?=($i==1?' open':'')?>">
								<h3 class="pt-title<?=($i==1?' active':'')?>">
									<?=$rs_m['name']?> (<?=db_rows("items WHERE menu = '{$rs_m['id']}' && restaurant = '{$id}'")?>)
									<i class="fas fa-<?=($i==1?'minus':'plus')?>-circle"></i>
								</h3>
								<?php
								$item_sql = $db->query("SELECT id, name, selling_price, image, ingredients, reduce_price, instock FROM ".prefix."items WHERE menu = '{$rs_m['id']}' && restaurant = '{$id}'");
								if($item_sql->num_rows):
								while($item_rs = $item_sql->fetch_assoc()):
								?>
									<div class="pt-resaurant">
										<div class="media">
											<div class="media-left">
												<div class="pt-thumb"><img src="<?=path?>/<?=$item_rs['image']?>" alt="<?=$item_rs['name']?>" onerror="this.src='<?=noimage?>'"></div>
											</div>
											<div class="media-body">
												<div class="pt-dtable">
													<div class="pt-vmiddle">
														<h3><?=$item_rs['name']?></h3>
														<?php if ($item_rs['ingredients']): ?>
															<p><span><i class="fas fa-utensils"></i> <?=$item_rs['ingredients']?></span></p>
														<?php endif; ?>
														<div class="pt-options">
															<?php if($item_rs['instock']): ?>
															<a class="pt-out"><?=$lang['restaurant']['out']?></a>
															<?php endif; ?>
															<?php if($item_rs['reduce_price'] && $item_rs['reduce_price'] != $item_rs['selling_price']): ?>
															<a class="pt-reduce"><?=dollar_sign.$item_rs['reduce_price']?></a>
															<?php endif; ?>
															<?php if ($rs['neworders']): ?>
															<div class="pt-addtocart" data-id="<?=$item_rs['id']?>">
																<a data-toggle="modal" href="#addtocartModal" class="pt-addtobasket tips"><i class="fas fa-shopping-basket"></i><b><?=$lang['home']['addtocart']?></b></a>
																<a data-toggle="modal" href="#addtocartModal" class="pt-price"><?=dollar_sign.$item_rs['selling_price']?></a>
															</div>
															<?php else: ?>
																<a class="pt-reduce text-success"><?=dollar_sign.$item_rs['selling_price']?></a>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								endwhile;
								endif;
								$item_sql->close();
								?>
							</div>
						<?php
						endwhile;
						else:
						?>
						<div class="text-center"><?=$lang['alerts']['no-data']?></div>
						<?php
						endif;
						$sql->close();
						?>
					</div>

					<div class="tab-pane container" id="menu1">
						<?php
						$sql_review = $db->query("SELECT * FROM ".prefix."reviews WHERE restaurant = '{$id}' ORDER BY id DESC");
						if($sql_review->num_rows):
						while($rs_review = $sql_review->fetch_assoc()):
						?>
						<div class="pt-resaurant pt-reviews">
								<div class="modal-header">
									<div class="float-left">
										<?=fh_stars_alt($rs_review['stars'], 5-$rs_review['stars'])?>
										<b><?=$rs_review['title']?></b>
									</div>

									<div class="float-right">
										by <?php echo fh_user($rs_review['author']) ?> - <?php echo fh_ago($rs_review['created_at']) ?>
									</div>
								</div>
								<p><?=$rs_review['content']?></p>
						</div>
						<?php
						endwhile;
						else:
						?>
						<div class="text-center"><?=$lang['alerts']['no-data']?></div>
						<?php
						endif;
						$sql_review->close();
						?>
					</div>

					<div class="tab-pane container" id="menu2">
						<div class="form-row">
						<?php
						$sql_img = $db->query("SELECT * FROM ".prefix."images WHERE table_name = 'restaurants' && table_id = '{$id}'");
						if($sql_img->num_rows):
						while($rs_img = $sql_img->fetch_assoc()):
						?>
						<div class="col-3">
						<div class="pt-album-img"><a href="<?=path.'/'.$rs_img['url']?>" data-lightbox="image-1"><img src="<?=path.'/'.$rs_img['url']?>" onerror="this.src='<?=noimage?>'"></a></div>
						</div>
						<?php
						endwhile;
						else:
						?>
						<div class="text-center"><?=$lang['alerts']['no-data']?></div>
						<?php
						endif;
						$sql_img->close();
						?>
						<br clear="both">
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="col-4">
			<div class="pt-restaurant-sidebar">
				<div class="pt-search">
					<div class="pt-input">
						<input type="text" name="search" placeholder="<?=$lang['header']['search']?>">
						<i class="icons icon-magnifier"></i>
						<div class="sresults"></div>
					</div>
				</div>
				<div class="pt-social">
					<a href="https://www.facebook.com/<?=$rs['facebook']?>" class="fb"><i class="fab fa-facebook"></i></a>
					<a href="https://www.instagram.com/<?=$rs['instagram']?>" class="in"><i class="fab fa-instagram"></i></a>
					<a href="https://www.twitter.com/<?=$rs['twitter']?>" class="tw"><i class="fab fa-twitter"></i></a>
					<a href="https://www.youtube.com/<?=$rs['youtube']?>" class="yt"><i class="fab fa-youtube"></i></a>
					<a href="<?=path?>/restaurants.php?id=<?=$id?>&t=<?=$t?>"><i class="fas fa-globe"></i></a>
				</div>

				<div class="pt-opening">
					<h3><i class="far fa-clock"></i> <?=$lang['restaurant']['opening_hours']?></h3>
					<?php $working_hours = ($rs && count($rs['working_hours']) ? $rs['working_hours'] : []) ?>
					<table class="table">
						<tr>
							<td><?=$lang['monday']?></td>
							<td><?=(isset($working_hours[1][0]) ? $rs['working_hours'][1][0] : '--')?> - <?=(isset($working_hours[1][1]) ? $rs['working_hours'][1][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['tuesday']?></td>
							<td><?=(isset($working_hours[2][0]) ? $rs['working_hours'][2][0] : '--')?> - <?=(isset($working_hours[2][1]) ? $rs['working_hours'][2][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['wednesday']?></td>
							<td><?=(isset($working_hours[3][0]) ? $rs['working_hours'][3][0] : '--')?> - <?=(isset($working_hours[3][1]) ? $rs['working_hours'][3][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['thursday']?></td>
							<td><?=(isset($working_hours[4][0]) ? $rs['working_hours'][4][0] : '--')?> - <?=(isset($working_hours[4][1]) ? $rs['working_hours'][4][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['friday']?></td>
							<td><?=(isset($working_hours[5][0]) ? $rs['working_hours'][5][0] : '--')?> - <?=(isset($working_hours[5][1]) ? $rs['working_hours'][5][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['saturday']?></td>
							<td><?=(isset($working_hours[6][0]) ? $rs['working_hours'][6][0] : '--')?> - <?=(isset($working_hours[6][1]) ? $rs['working_hours'][6][1] : '--')?></td>
						</tr>
						<tr>
							<td><?=$lang['sunday']?></td>
							<td><?=(isset($working_hours[7][0]) ? $rs['working_hours'][7][0] : '--')?> - <?=(isset($working_hours[7][1]) ? $rs['working_hours'][7][1] : '--')?></td>
						</tr>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>


<?php else: ?>

<?php

$get_rating   = isset($_GET['rating']) ? sc_sec($_GET['rating'])     : '' ;
$get_service  = isset($_GET['service']) ? sc_sec($_GET['service'])   : '' ;
$get_open     = isset($_GET['open']) ? sc_sec($_GET['open'])         : '' ;
$get_cuisine  = isset($_GET['cuisine']) ? sc_sec($_GET['cuisine'])   : '' ;
$get_location = isset($_GET['location']) ? sc_sec($_GET['location']) : '' ;
$get_country  = isset($_GET['country']) ? sc_sec($_GET['country'])   : '' ;
$get_city     = isset($_GET['city']) ? sc_sec($_GET['city'])         : '' ;
$get_payment  = isset($_GET['payment']) ? sc_sec($_GET['payment'])   : '' ;

?>

<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['restaurant']['title']?></h3>
		<p><?=$lang['restaurant']['desc']?></p>
	</div>
</div>

<div class="container">
	<div class="row pt-restaurants">
		<div class="col-4">
			<div class="pt-restaurant-sidebar">
				<div class="pt-search">
					<div class="pt-input">
						<input type="text" placeholder="<?=$lang['header']['search']?>">
						<i class="icons icon-magnifier"></i>
					</div>
				</div>
				<form method="get">

				<h6><?=$lang['restaurant']['reviews']?></h6>
				<div class="pt-stars">
					<div class="pt-rating">
		       <input type="radio" name="rating" value="1" aria-label="1 star"/>
					 <input type="radio" name="rating" value="2" aria-label="2 stars"/>
					 <input type="radio" name="rating" value="3" aria-label="3 stars"/>
					 <input type="radio" name="rating" value="4" aria-label="4 stars"/>
					 <input type="radio" name="rating" value="5" aria-label="5 stars"/>
		     </div>
				</div>

				<h6><?=$lang['restaurant']['service']?></h6>
				<div>
					<input type="checkbox" name="service" value="all" value="" id="c0" class="choice" checked>
					<label for="c0"><?=$lang['restaurant']['all']?></label>
				</div>
				<div>
					<input type="checkbox" name="service" value="delivery" id="c1" class="choice">
					<label for="c1"><?=$lang['restaurant']['delivery']?></label>
				</div>
				<div>
					<input type="checkbox" name="service" value="pickup" id="c2" class="choice">
					<label for="c2"><?=$lang['restaurant']['pickup']?></label>
				</div>
				<h6><?=$lang['restaurant']['working']?></h6>
				<div>
					<input type="checkbox" name="open" value="all" id="op0" class="choice" checked>
					<label for="op0"><?=$lang['restaurant']['all']?></label>
				</div>
				<div>
					<input type="checkbox" name="open" value="true" id="op1" class="choice">
					<label for="op1"><?=$lang['restaurant']['open_now']?></label>
				</div>
				<h6><?=$lang['restaurant']['cuisine']?></h6>
				<div>
					<input type="checkbox" name="cuisine" value="all" id="cc0" class="choice" checked>
					<label for="cc0"><?=$lang['restaurant']['all']?></label>
				</div>
				<?php
				$sql = $db->query("SELECT * FROM ".prefix."cuisines ORDER BY name ASC");
				if($sql->num_rows):
				while($rs = $sql->fetch_assoc()):
				?>
				<div>
					<input type="checkbox" name="cuisine" value=<?=$rs['id']?>"" id="cc<?=$rs['id']?>" class="choice">
					<label for="cc<?=$rs['id']?>"><?=$rs['name']?></label>
				</div>
				<?php
				endwhile;
				endif;
				$sql->close();
				?>
				<h6><?=$lang['restaurant']['location']?></h6>
				<div>
					<input type="checkbox" name="location" value="all" id="l0" class="choice" checked>
					<label for="l0"><?=$lang['restaurant']['all']?></label>
				</div>
				<div class="m-2">
					<select class="selectpicker" data-live-search="true" data-width="100%" name="country" title="<?=$lang['restaurant']['country']?>">
						<?php foreach($countries as $k => $c): ?>
							<option data-tokens="<?=$k?> <?=$c?>" value="<?=$k?>"><?=$c?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="m-2">
					<input type="text" name="city" value="" placeholder="<?=$lang['restaurant']['city']?>">
				</div>
				<h6><?=$lang['restaurant']['payment']?></h6>
				<div>
					<input type="checkbox" name="payment" value="all" id="pm0" class="choice" checked>
					<label for="pm0"><?=$lang['restaurant']['all']?></label>
				</div>
				<div>
					<input type="checkbox" name="payment" value="1" id="pm1" class="choice">
					<label for="pm1"><?=$lang['restaurant']['visa']?></label>
				</div>
				<div>
					<input type="checkbox" name="payment" value="2" id="pm2" class="choice">
					<label for="pm2"><?=$lang['restaurant']['paypal']?></label>
				</div>
				<div class="pt-submit">
					<button type="submit"><?=$lang['restaurant']['apply']?>  <i class="fas fa-long-arrow-alt-right"></i></button>
				</div>
			</form>
			</div>
		</div>

		<div class="col-8">
			<div class="row">
		<?php
		$sql_where = '';
		if ($get_rating) {
			$get_rating1 = $get_rating+1;
			$sql_where .= "&& rating >= '{$get_rating}' AND rating < '{$get_rating1}'";
		}
		if ($get_service && $get_service != 'all') {
			$get_service = $get_service == 'delivery' ? 2 : 3;
			$sql_where .= "&& services = '{$get_service}'";
		}
		if ($get_cuisine && $get_cuisine != 'all') {
			$get_cuisine = (int)($get_cuisine);
			$sql_where .= "&& FIND_IN_SET('{$get_cuisine}', cuisine) > 0";
		}
		if ($get_country && $get_location != 'all') {
			$sql_where .= "&& country = '{$get_country}'";
		}
		if ($get_city && $get_location != 'all') {
			$sql_where .= "&& city = '{$get_city}'";
		}


		$sql = $db->query("SELECT * FROM ".prefix."restaurants WHERE status = '0' {$sql_where} ORDER BY id DESC");

		if($sql->num_rows):
		while($rs = $sql->fetch_assoc()):
		?>
		<div class="col-4">
			<div class="pt-item">
				<div class="pt-thumb"><img src="<?=path?>/<?=$rs['photo']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'"></div>
				<div class="pt-title"><a href="<?=path?>/restaurants.php?id=<?=$rs['id']?>&t=<?=fh_seoURL($rs['name'])?>"><h3><?=$rs['name']?></h3></a></div>
				<div class="pt-stars"><?php echo fh_stars($rs['id'], "restaurant") ?></div>
				<div class="pt-address"><i class="fas fa-map-marker-alt"></i> <?=$rs['city']?> - <?=$countries[$rs['country']]?></div>
			</div>
		</div>
		<?php endwhile; ?>
		<?php else: ?>
			<div class="text-center"><?=$lang['alerts']['no-data']?></div>
		<?php endif; ?>
		<?php $sql->close(); ?>
	</div>
	</div>


	</div>
</div>

<?php
endif;


include __DIR__."/footer.php";
