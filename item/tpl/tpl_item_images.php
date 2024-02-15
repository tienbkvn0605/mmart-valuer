<div class="clear" style="">
    <?php foreach($item['imgs'] as $img) :?>
        <div class="text_center"><img src="<?php echo $img?>" width="100%"></div>
    <?php endforeach?>
	
	<?php
		$item['contents'] = str_replace( '&quot;', "'", $item['contents'] );
	?>

	<div class="ck-content"><?php echo nl2br($item['contents'])?></div>
</div>
