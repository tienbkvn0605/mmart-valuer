<form action="/search/order_cart.php" method="post" onsubmit="return false;">
    <input type="hidden" name="ai_serial" id="ai_serial" value="<?php echo $item['ai_serial']?>">
	<input type="hidden" name="id" value="<?php echo $item['m_id']?>">
	<input type="hidden" name="no" value="<?php echo $item['m_serial']?>">
	<input type="hidden" name="mod" value="<?php echo $type?>">
	<input type="hidden" name="bn" value="<?php echo $g_banar?>">
	<input type="hidden" name="ichiba" value="">
	<input type="hidden" name="prev_page" value="item">
	<input type="hidden" name="zaiko" value="<?php echo $item["m_zaiko"]?>">
	<input type="hidden" name="chumon_cate" value="<?php echo $chumon_cate?>">
	<input type="hidden" name="large" value="1">
	<input type="hidden" name="m_tanka" value="<?php echo $item['m_tanka']?>">
	<input type="hidden" name="m_price_lot" value="<?php echo $item['m_price_lot']?>">

	<?php if($floating == true):?>
	<!-- Floating part -->
	<div class="moji_hako2">
        <?php ?>
        <?php echo number_format($item['m_price_lot'])?>円（<?php echo $item['m_lot_small'] ?>）×<input class="uk-input uk-form-width-xsmall" type="text" name="order_quantity" size="3" min="1" max="999" maxlength="3" value="1" inputmode="numeric" pattern="[0-9]*" oninput="value=value.replace(/[^0-9]+/i,''); required">				
		<input type="submit" class="uk-button-primary uk-button-small" value="買い物かごに入れる" onclick="F_check_next(this.form);">
	</div>
	<?php else:?>
	<div class="moji_hako2">
		ご注文の数をご記入願います。
		<span class="red">（半角数字）</span><br>

		<?php echo number_format($item['m_price_lot'])?>円（<?php echo $item['m_lot_small'] ?>）×<input class="uk-input uk-form-width-xsmall" type="text" name="order_quantity" size="3" min="1" max="999" maxlength="3" value="1" inputmode="numeric" pattern="[0-9]*" oninput="value=value.replace(/[^0-9]+/i,''); required">		
		<input type="submit" class="uk-button-primary uk-button-small" value="買い物かごに入れる" onclick="F_check_next(this.form);">
	</div>
	<?php endif?>

</form>

