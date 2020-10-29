

<ul class="pt-main-stats">
	<li>
		<div class="pt-box">
			<span><i class="icon-wallet icons"></i></span>
			<b><?=db_rows("orders")?></b><br /><small>Pedidos totales</small>
		</div>
	</li>
	<li>
		<div class="pt-box">
			<span><i class="icon-star icons"></i></span>
			<b><?=db_rows("payments")?></b><br /><small>Pagos totales</small>
		</div>
	</li>
	<li>
		<div class="pt-box">
			<span><i class="fas fa-store"></i></span>
			<b><?=db_rows("restaurants")?></b><br /><small>Total Restaurantes</small>
		</div>
	</li>
	<li>
		<div class="pt-box">
			<span><i class="fas fa-pizza-slice"></i></span>
			<b><?=db_rows("items")?></b><br /><small>Total Platillos</small>
		</div>
	</li>
</ul>

<ul class="pt-main-stats">
	<li class="thr">
		<div class="pt-box">
			<span><i class="fas fa-comments-dollar"></i></span>
			<b><?=fh_cp_amount("orders", "payment_amount", " GROUP BY transaction_id")?></b><br /><small>Cantidad de pedidos</small>
		</div>
	</li>
	<li class="thr">
		<div class="pt-box">
			<span><i class="fas fa-file-invoice-dollar"></i></span>
			<b><?=fh_cp_amount("payments", "price")?></b><br /><small>Monto de los pagos</small>
		</div>
	</li>
	<li class="thr">
		<div class="pt-box">
			<span><i class="fas fa-search-dollar"></i></span>
			<b><?=fh_cp_amount("taxes", "taxes")?></b><br /><small>Monto de impuestos</small>
		</div>
	</li>
</ul>

<div class="row">
	<div class="col-8">
		<div class="pt-order-chart pt-box">
			<h3>
				Orden de estadisticas
				<span class="ptcporders" rel="days">Dias</span>
				<span class="ptcporders" rel="months">Meses</span>
			</h3>
			<div class="p-4 pl-5 pr-5"><canvas id="orders-cporders"></canvas></div>

		</div>
	</div>
	<div class="col-4">
		<div class="pt-order-chart pt-box">
			<h3>Pedidos por género</h3>
			<div class="p-4"><canvas id="orders-cpgender"></canvas></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-3">
		<div class="pt-order-chart pt-box">
			<h3>Pagos 24h</h3>
			<div class="pt-content">
				<ul>
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."payments WHERE date >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
					if($sql->num_rows):
					while($rs = $sql->fetch_assoc()):
					?>
					<li>
						<div class="media">
							<div class="media-left">
								<div class="pt-thumb"><img src="<?=db_get("users", "photo", $rs['author'])?>" onerror="this.src='<?=nophoto?>'" /></div>
							</div>
							<div class="media-body">
								<?=fh_user($rs['author'])?>
								<p>
									<span><i class="far fa-clock"></i> <?=fh_ago($rs['date'])?></span>
									<span><i class="fas fa-comment-dollar"></i> $<?=$rs['price']?></span>
								</p>
							</div>
						</div>
					</li>
					<?php
					endwhile;
					else:
						echo '<li class="text-center">'.$lang['alerts']['no-data'].'</li>';
					endif;
					$sql->close();
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="pt-order-chart pt-box">
			<h3>Pagos 24h</h3>
			<div class="pt-content pt-scroll">
				<ul>
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."orders WHERE created_at >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
					if($sql->num_rows):
					while($rs = $sql->fetch_assoc()):
						$cart = json_decode($rs['order_cart'], true);
						$rsi  = db_rs("items WHERE id = '{$cart['item_id']}'");
						$item_size = isset($cart['item_size']) ? db_unserialize([$rsi['sizes'], $cart['item_size']]) : '';
					?>
					<li>
						<div class="media">
							<div class="media-left">
								<div class="pt-thumb"><img src="<?=$rsi['image']?>" onerror="this.src='<?=noimage?>'" /></div>
							</div>
							<div class="media-body">
								<a href="<?=path?>/restaurants.php?id=<?=$rsi['restaurant']?>&t=<?=fh_seoURL(db_get("restaurants", "name", $rsi['restaurant']))?>"><?=$rsi['name']?></a>

								<p>
									<span><i class="far fa-clock"></i> <?=fh_ago($rs['created_at'])?></span>
									<span><i class="fas fa-money-bill-wave"></i> <?=$cart['item_quantities']?> x <?=dollar_sign.($item_size ? $item_size['price'] : $rsi['selling_price'])?></span>
								</p>
							</div>
						</div>
					</li>
					<?php
					endwhile;
					else:
						echo '<li class="text-center">'.$lang['alerts']['no-data'].'</li>';
					endif;
					$sql->close();
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="pt-order-chart pt-box">
			<h3>24h Restaurantes</h3>
			<div class="pt-content pt-scroll">
				<ul>
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."restaurants WHERE created_at >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
					if($sql->num_rows):
					while($rs = $sql->fetch_assoc()):
					?>
					<li>
						<div class="media">
							<div class="media-left">
								<div class="pt-thumb"><img src="<?=$rs['photo']?>" onerror="this.src='<?=noimage?>'" /></div>
							</div>
							<div class="media-body">
								<a href="<?=path?>/restaurants.php?id=<?=$rs['id']?>&t=<?=fh_seoURL($rs['name'])?>"><?=$rs['name']?></a>

								<p>
									<span><i class="far fa-clock"></i> <?=fh_ago($rs['created_at'])?></span>
									<span><i class="fas fa-poll"></i> <?=db_rows("items WHERE restaurant = '{$rs['id']}'")?> Platillos</span>
								</p>
							</div>
						</div>
					</li>
					<?php
					endwhile;
					else:
						echo '<li class="text-center">'.$lang['alerts']['no-data'].'</li>';
					endif;
					$sql->close();
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="pt-order-chart pt-box">
			<h3>24h Platillos</h3>
			<div class="pt-content pt-scroll">
				<ul>
					<?php
					$sql = $db->query("SELECT * FROM ".prefix."items WHERE created_at >= '".(time() - 3600*24)."' ORDER BY id DESC") or die ($db->error);
					if($sql->num_rows):
					while($rs = $sql->fetch_assoc()):
					?>
					<li>
						<div class="media">
							<div class="media-left">
								<div class="pt-thumb"><img src="<?=$rs['image']?>" onerror="this.src='<?=noimage?>'" /></div>
							</div>
							<div class="media-body">
								<a href="<?=path?>/restaurants.php?id=<?=$rs['restaurant']?>&t=<?=fh_seoURL(db_get("restaurants", "name", $rs['restaurant']))?>"><?=$rs['name']?></a>

								<p>
									<span><i class="far fa-clock"></i> <?=fh_ago($rs['created_at'])?></span>
									<span><i class="fas fa-poll"></i> <?=db_rows("orders WHERE item = '{$rs['id']}'")?> Platillos</span>
								</p>
							</div>
						</div>
					</li>
					<?php
					endwhile;
					else:
						echo '<li class="text-center">'.$lang['alerts']['no-data'].'</li>';
					endif;
					$sql->close();
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
