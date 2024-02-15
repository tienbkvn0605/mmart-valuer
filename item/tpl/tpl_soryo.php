<div class="margin-bottom_50px" id="soryo">
	<h3 class="heading3">送料について</h3>
    <table class="tbl_normal">
        <tr>
            <th>地域</th>
            <th>送料</th>
            <th>重量</th>
        </tr>
        <?php foreach($soryo_info as $master_serial => $soryo):?>
            <?php foreach($soryo['soryo_table'] as $region_serial => $value):?>
                <tr>
                    <td>
                        <?php echo $region_master[$value['region_serial']]['region']?>
                        <?php echo $value['region_label'] ?? '';?>(<?php echo $value['pref'];?>)
                    </td>
                    <td><?php echo number_format($value['fee']);?>円</td>
                    <td><?php echo $value['size'];?>サイズ<?php echo $value['weight'];?>kg</td>
                </tr>
            <?php endforeach?>
        <?php endforeach?>

    </table>
</div>