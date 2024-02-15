<h1 class="heading">
	<span class="width_50p">
		<?php echo $item['m_item']?>
		<?php if($item['m_kanbai'] == DF_sold_out ) :?>
			<label class="red">【品切れ中】</label>
		<?php endif?>
	</span>
	<span class="width_50p text_right">
		<?php if($item['m_kanbai'] == DF_sold_out):?>
			<div class="red bold"><?php echo DF_soldout_mess;?></div>
		<?php else: ?>
			<div class="display-table">
				<label class="width_88p table-cell">
					<?php 
						$floating = true;
						include("tpl_item_cart.php");
					?>
				</label>
				<label class="width_12p table-cell"><a href="#soryo" class="hasso-button uk-button uk-button-primary uk-button-small">送料表</a></label>
			</div>
		<?php endif?>
	</span>
</h1>
<div class="detail_product clearfix">
	<div class="detail_half_left">
		<?php if(!empty($sns_info['sns_button'])):?>		
			<div><?php echo $sns_info['sns_button']?></div>
		<?php endif?>
		<?php include_once('tpl_item_slide.php')?>
		<div class="product_comment">
			<p>◆商品説明◆<br>
				<?php echo $item['m_setsumei']?>
			</p>
		</div>
	</div><!-- detail_half_left -->

	<div class="detail_half_right">
		<div class="product_info">
			<table class="margin-bottom_20px">
				<tr>
					<th>商品名</th>
					<td><?php echo $item['m_item']?>
						<br />
						<p style="text-align:left"><img src="https://www.m-mart.co.jp/img/card_ichiran.png"></p>					
					</td>
				</tr>
				<tr>
					<th>単価</th>
					<td>
						<?php echo sprintf("%s円/%s",number_format($item['m_tanka']), $item['m_tanka_tani']); ?>
						<?php if($item['m_teikan'] == 'futei'):?>
							<br><span class="futei_price">不定貫商品(重量は個体によって違います)（税込）</span>
						<?php endif?>
					</td>
				</tr>
				<tr>
					<th>販売最小ロット</th>
					<td>
						<?php echo sprintf('%s円/%s（税込）', number_format($item['m_price_lot']), $item['m_lot_small'] ) ?>
					</td>
				</tr>
				<tr>
					<th>生(原)産地</th>
					<td><?php echo $item['m_sanchi']?></td>
				</tr>
				<tr>
					<th>加工地</th>
					<td><?php echo $item['m_kakouchi']?></td>
				</tr>
				<?php if($item['m_zaiko_disp_flg'] == 1):?>
				<tr>
					<th>提供数量</th>
					<td>
						現在残り(<?php echo $item['m_zaiko'] - $item['m_teikyo']?>)
						<?php if($item['m_kanbai'] == DF_sold_out) :?>
							<img src="<?php echo DF_kanbai_img ?>" alt="完売">
						<?php endif?>
					</td>
				</tr>
				<?php endif?>
				<tr>
					<th>形態</th>
					<td><?php echo $item['m_keitai']?></td>			
				<tr/>
				<tr>
					<th>荷姿</th>
					<td><?php echo $item['m_nisugata']?></td>
				</tr>
				<tr>
					<th>サイズ</th>
					<td><?php echo $item['disp_size_weight']?></td>
				</tr>
				<tr>
					<th>賞味期限</th>
					<td><?php echo $item['m_shoumi']?></td>
				</tr>
				<tr>
					<th>解凍方法</th>
					<td><?php echo $item['m_hozon']?></td>
				</tr>
				<?php if($item['m_hozon'] == DF_reitou):?>
				<tr>
					<th>解凍方法</th>
					<td><?php echo $item['m_kaitou']?></td>
				</tr>
				<?php endif?>
				<tr>
					<th>納期/発送体制</th>
					<td><?php echo $item['m_nouki']?></td>
				</tr>
				<tr>
					<th>運送費</th>
					<td><?php echo $item['m_souryou']?><a href="#soryo" class="hasso-button uk-button uk-button-primary uk-button-small">送料表</a></td>
				</tr>
				<tr>
					<th>納入実績</th>
					<td><?php echo $item['m_jisseki']?></td>
				</tr>
				<tr>
					<th>参考メニュー</th>
					<td><?php echo $item['m_menu']?></td>
				</tr>
				<?php if($item['m_bikou']):?>
				<tr>
					<th>備考</th>
					<td><?php echo $item['m_bikou'];?></td>
				</tr>
				<?php endif?>
				<tr>
					<th>原材料、食品添加物</th>
					<td><?php echo $item['m_zairyou']?></td>
				</tr>
				
				<?php if($item['m_eiyou']):?>
				<tr>
					<th>栄養成分表示</th>
					<td>
						<?php echo nl2br($item['m_eiyou']);?>

						<?php if($item['m_pic_eiyo']):?>
							<br/>
							<a href="<?php echo sprintf("/%s/ireg/tmp/%s", $item["m_id"], $item['m_pic_eiyo']) ?>" rel="lightbox" title="栄養成分表示" target="_blank">栄養成分表示写真を見る</a>
						<?php endif?>
					</td>
				</tr>
				<?php endif?>
				<tr>
					<th>この商品の評価</th>
					<td>
						{!! $item->item_point !!}
						<br><a target="_blank" href="/kitchen/search/voice.php?type=qcc&amp;no={{$item->item_no}}">お客様の声</a>
					</td>
				</tr>
				<tr>
					<th>当該企業<br>
						過去出品全品<br>
						評価自動集計
					</th>
					<td>
						{!! $item->shop_point !!}

						<div class="button-hyoka">
							{{-- <div class="fb-like" target="_top" data-href="{{route('item_detail',['item_no' => $item->item_no])}}" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div> --}}
							<button type="button" class="voice-b" onclick="window.open('/kitchen/search/company_voice.php?type=qcc&no={{$item->item_no}}')">出店社評価</button>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" scope="row">
						<div id="order_btn_area" class="padding_10px order_area">
						<?php if($item['m_kanbai'] == DF_sold_out):?>
							<div class="red bold"><?php echo DF_soldout_mess;?></div>
						<?php else: ?>
							<div class="display-table">
								<label class="width_88p table-cell">
									<?php 
										$floating = false;
										include("tpl_item_cart.php");
									?>
								</label>
								
							</div>
						<?php endif?>
						</div>
					</td>
				</tr>


			</table>
		</div><!-- /product_info -->
		<div class="addtobasket">
			<div class="attention">
				<div class="fav_item_box_in_item_detail">
					@if ($item->fav_item_no)
					<a href="#" class="btn_fav_item_detail_active" data-item-serial="{{$item->item_no}}" data-process-type="unfav"><span class="icon_fav">&#10084;</span>Myページのお気に入りリストから外す</a>
					@else
					<a href="#" class="btn_fav_item_detail" data-item-serial="{{$item->item_no}}" data-process-type="fav"><span class="icon_fav">❤</span>Myページのお気に入りリストに追加</a>
					@endif
				</div>
			</div>
			<div class="margin-top_10px margin-bottom_10px">
				<form action="/invoice/index/item_no/{{$item_no}}" method="GET">
					<input type="submit" id="pre_next_button" value="お問い合せへ" class="width_100p">
				</form>
			</div>
		</div>
	</div><!-- /detail_half_right -->
</div><!-- /detail_product -->

