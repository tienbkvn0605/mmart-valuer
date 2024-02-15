<div class="product_item_photo">
	<div uk-slideshow="min-height: false; max-height: false" id="slider">
		<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

			<ul class="uk-slideshow-items" >
                <?php foreach($item['imgs'] as $img):?>
                    <li><img src="<?php echo $img?>" alt="<?php echo $item['m_item']?>" title="" class="uk-position-center"></li>
                <?php endforeach?>
			</ul>

			<a class="uk-position-center-left uk-position-small uk-visible slidenav" href uk-slidenav-previous uk-slideshow-item="previous"></a>
			<a class="uk-position-center-right uk-position-small uk-visible slidenav" href uk-slidenav-next uk-slideshow-item="next"></a>

		</div>
		<ul class="uk-slideshow-nav uk-dotnav uk-margin">
            <?php foreach($item['imgs'] as $i => $img):?>
                <li uk-slideshow-item="<?php echo $i?>" href=""><a><img src="<?php echo $img?>" alt="<?php echo $item['m_item']?>" ></a></li>
            <?php endforeach?>
		</ul>
	</div>
</div>
