<?php


include __DIR__."/header.php";

?>

<div class="pt-breadcrumb-p">
	<div class="container">
		<h3><?=$lang['cart']['title']?></h3>
		<p><?=$lang['cart']['desc']?></p>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="col-8">
		<div class="pt-cart-body">
			<?php
			if(isset($_COOKIE['addtocart'])):
			foreach(json_decode($_COOKIE['addtocart'], true) as $cart_id => $carts):
				foreach($carts as $it_id => $cart):
					if(!empty(str_replace('[]','', $cart))):
					$cart = json_decode($cart, true);
					$rs = db_rs("items WHERE id = '{$cart_id}'");

					$item_size = isset($cart['item_size']) ? db_unserialize([$rs['sizes'], $cart['item_size']]) : '';
			?>
			<div class="pt-cart-body">
				<div class="media">
					<div class="media-left"><div class="pt-thumb"><img src="<?=path?>/<?=$rs['image']?>" alt="<?=$rs['name']?>" onerror="this.src='<?=noimage?>'"></div></div>
					<div class="media-body">
						<div class="pt-dtable">
							<div class="pt-vmiddle">
								<div class="pt-title"><h3><a href="#"><?=$rs['name']?></a></h3></div>
								<div class="pt-extra"><small><?=str_replace("+", " ", $cart['item_note'])?></small></div>
								<?php if ($rs['delivery_price']): ?>
								<div class="d-none pt-deliveryprice"><?=$rs['delivery_price']?></div>
								<?php endif; ?>
								<div class="pt-extra">
									<?php if($item_size): ?>
									<strong>Size: <a><?=$item_size['name']?></a></strong> -
									<?php endif; ?>
									<strong>Price: <a class="checked"><?=dollar_sign.($item_size ? $item_size['price'] : $rs['selling_price'])?></a></strong>
								</div>
								<div class="pt-extra">
									<?php
									if($cart['item_extra']):
									foreach($cart['item_extra'] as $k => $extra):
										$extra = db_unserialize([$rs['extra'], $extra]);
									?>
										<span>
											<?=$extra['name']?> <b class="pt-extraprice"><?=$extra['price']?></b>
											<i class="fas fa-times pt-removeexratoitem" data-price="<?=$extra['price']?>" data-id="<?=$k?>" data-iid="<?=$it_id?>" data-iiid="<?=$cart_id?>"></i>
										</span>
									<?php
									endforeach;
									endif;
									?>
								</div>
								<div class="pt-options">
									<a href="#" class="pt-removefromcart" data-iid="<?=$it_id?>" data-iiid="<?=$cart_id?>"><i class="fas fa-trash"></i></a>
									<div class="pt-quantity">
										<i class="fas fa-minus pt-minus" data-i="<?=$it_id?>" data-a="<?=$cart_id?>"></i>
										<input type="text" name="item_quantity" value="<?=$cart['item_quantities']?>" disabled>
										<i class="fas fa-plus pt-plus" data-i="<?=$it_id?>" data-a="<?=$cart_id?>"></i>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
			<?php endforeach; ?>
			<?php else: ?>
				<div class="text-center"><?=$lang['alerts']['no-data']?></div>
			<?php endif; ?>
		</div>
		</div>
		<div class="col-4">
			<div class="pt-cart-body">

				<div id="checkout">

		      <form id="payment-form" method="POST" action="stripe.php">
						<h2><?=$lang['cart']['order_summary']?></h2>
						<div class="fieldset mb-4">
							<p class="mt-2"><span><?=$lang['cart']['subtotal']?></span><b class="float-right pt-totalprice"><?=dollar_sign?>0.00</b></p>
							<p><span><?=$lang['cart']['shipping_fees']?></span><b class="float-right pt-deliverytotalprice"><?=dollar_sign?>0.00</b></p>
							<hr />
							<p><span><?=$lang['cart']['total']?></span><b class="float-right pt-alltotalprice"><?=dollar_sign?>0.00</b></p>
						</div>

	          <h2><?=$lang['cart']['billing']?></h2>
						<div class="fieldset">
	            <label class="label">
	              <span><?=$lang['cart']['name']?></span>
	              <input name="name" value="<?=us_firstname?> <?=us_lastname?>" class="field" placeholder="Jenny Rosen" required>
	            </label>
	            <label class="label">
	              <span><?=$lang['cart']['email']?></span>
	              <input name="email" value="<?=us_email?>" type="email" class="field" placeholder="jenny@example.com" required>
	            </label>
	            <label class="label">
	              <span><?=$lang['cart']['phone']?></span>
	              <input name="phone" value="<?=us_phone?>" type="text" class="field phone" placeholder="0000-000-000"required>
	            </label>
	            <label class="label">
	              <span><?=$lang['cart']['address']?></span>
	              <input name="address" value="<?=us_address?>" class="field" placeholder="185 Berry Street Suite 550"required>
	            </label>
	            <label class="label">
	              <span><?=$lang['cart']['city']?></span>
	              <input name="city" value="<?=us_city?>" class="field" placeholder="San Francisco"required>
	            </label>
	            <label class="state label">
	              <span><?=$lang['cart']['state']?></span>
	              <input name="state" value="<?=us_state?>" class="field" placeholder="CA"required>
	            </label>
	            <label class="zip label">
	              <span><?=$lang['cart']['zip']?></span>
	              <input name="postal_code" class="field" placeholder="94107"required>
	            </label>
	            <label class="select label">
	              <span><?=$lang['cart']['country']?></span>
	              <div id="country" class="field US">
									<select class="selectpicker" data-live-search="true" data-width="100%" name="country" title="<?=$lang['cart']['country']?>"required>
										<?php foreach($countries as $k => $c): ?>
											<option data-tokens="<?=$k?> <?=$c?>" value="<?=$k?>"<?=(!empty(us_country) && us_country == $k ? "selected" : ($k == 'US' ? ' selected' : ''))?>><?=$c?></option>
										<?php endforeach; ?>
									</select>
	              </div>
	            </label>
							<label class="select label">
	              <span><?=$lang['cart']['gender']?></span>
								<div id="gender" class="field US">
								<select name="gender" class="selectpicker" data-width="100%" title="<?=$lang['cart']['gender_s']?>"required>
									<option value="1"<?=(us_gender == 1 ? "selected" : "")?>><?=$lang['cart']['male']?></option>
									<option value="2"<?=(us_gender == 2 ? "selected" : "")?>><?=$lang['cart']['female']?></option>
								</select>
								</div>
							</label>
						</div>
						<div class="fieldset mt-4">
							<label>
								<span><?=$lang['cart']['card']?></span>
								<div id="card-element" class="field"></div>
								<div id="card-errors" role="alert"></div>
								<input type="hidden" name="amount" class="hidamount" value="" />
							</label>
						</div>
						<button class="payment-button" type="submit"><?=$lang['cart']['pay']?></button>
      		</form>
					<form id="sendpaypalitem">
			      <input type="hidden" name="item_number" value="<?=time()?>" />
						<?php if(us_level): ?>
						<button class="paypal-button" type="submit" name="button">
							<span class="paypal-button-title"><?=$lang['cart']['pay_with']?> </span>
							<span class="paypal-logo"><i>Pay</i><i>Pal</i></span>
						</button>
						<?php else: ?>
							<a class="paypal-button" data-toggle="modal" href="#loginModal">
								<span class="paypal-button-title"><?=$lang['cart']['pay_with']?> </span>
								<span class="paypal-logo"><i>Pay</i><i>Pal</i></span>
							</a>
						<?php endif; ?>
			    </form>
    		</div>

			</div>
		</div>
	</div>

</div>

<?php
include __DIR__."/footer.php";
