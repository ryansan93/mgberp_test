<?php 
	$disabled = null;
	if ( $resubmit == '' ) {
		$disabled = 'disabled';
	}
?>

<?php foreach ($data as $key => $v_data) { ?>
	<div class="col-lg-12 no-padding">
		<div class="col-lg-1 no-padding pull-left">
			<h5>Tgl Berlaku : </h5>
		</div>
		<div class="col-lg-2 no-padding action">
		    <!-- <input class="form-control text-center" type="text" value="" data-tipe="date"> -->
		    <div class="input-group date" id="datetimepicker1" name="tanggal-berlaku">
		        <input type="text" class="form-control text-center" data-required="1" <?php echo $disabled; ?> />
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-calendar"></span>
		        </span>
		    </div>
		</div>
		<div class="col-lg-9 align-items-center d-flex" style="font-size: 14px;">
			<div class="col-lg-4 no-padding">
				<?php 
					if ( $akses['a_edit'] == 1 ){
						if ( $resubmit != '' ){ 
				?>
							<button id="btn-add" type="button" class="btn btn-primary cursor-p" title="EDIT" onclick="sb.edit(this)"> 
								<i class="fa fa-edit" aria-hidden="true"></i> EDIT
							</button>
				<?php 
						}
					} 
				?>
			</div>
			<div class="col-lg-8 no-padding">
				<span class="pull-right dok_no" data-id="<?php echo $v_data['id']; ?>">Dok : <?php echo $v_data['nomor']; ?></span>
			</div>
		</div>
	</div>
	<table class="table table-bordered table-hover" id="tb_input_standar_budidaya" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th class="text-center" style="width: 6.66%;">Umur (hari)</th>
				<th class="text-center" style="width: 6.66%;">Berat Badan (g)</th>
				<th class="text-center" style="width: 6.66%;">FCR</th>
				<th class="text-center" style="width: 6.66%;">Daya Hidup (%)</th>
				<th class="text-center" style="width: 6.66%;">IP</th>
				<th class="text-center" style="width: 6.66%;">Kons. Pakan Perhari (g)</th>
				<th class="text-center" style="width: 6.66%;">Suhu Experience</th>
				<th class="text-center" style="width: 6.66%;">Heat Offset</th>
				<th class="text-center" style="width: 6.66%;">Kons. Min Vent</th>
				<th class="text-center" style="width: 6.66%;">Min Ventilasi</th>
				<th class="text-center" style="width: 6.66%;">Chill Factor</th>
				<th class="text-center" style="width: 6.66%;">Min Air Speed</th>
				<th class="text-center" style="width: 6.66%;">Max Air Speed</th>
				<th class="text-center" style="width: 6.66%;">Cooling Pad Start</th>
				<?php if ( $resubmit != '' ): ?>
					<th class="text-center" style="width: 6.76%;">Action</th>
				<?php endif ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($v_data['details'] as $key => $v_detail): ?>
				<tr>
					<td>
						<input class="form-control text-center" type="text" name="umur" value="<?php echo $v_detail['umur'] ?>" data-tipe="integer" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="bb" value="<?php echo angkaDecimal($v_detail['bb']); ?>" data-tipe="decimal" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="fcr" value="<?php echo angkaDecimalFormat($v_detail['fcr'], 3); ?>" data-tipe="decimal3" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="daya_hidup" value="<?php echo angkaDecimalFormat(($v_detail['daya_hidup'] * 100), 2); ?>" data-tipe="decimal" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="ip" value="<?php echo angkaRibuan($v_detail['IP']); ?>" data-tipe="integer" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="kons_pakan_harian" value="<?php echo angkaRibuan($v_detail['kons_pakan_harian']); ?>" data-tipe="integer" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="suhu_experience" value="<?php echo angkaDecimalFormat($v_detail['suhu_experience'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="heat_offset" value="<?php echo angkaDecimalFormat($v_detail['heat_offset'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="kons_min_vent" value="<?php echo angkaDecimalFormat($v_detail['kons_min_vent'], 3); ?>" data-tipe="decimal3" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="min_vent" value="<?php echo angkaDecimalFormat($v_detail['min_vent'], 2); ?>" data-tipe="decimal" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="chill_factor" value="<?php echo angkaDecimalFormat($v_detail['chill_factor'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="min_air_speed" value="<?php echo angkaDecimalFormat($v_detail['min_air_speed'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="max_air_speed" value="<?php echo angkaDecimalFormat($v_detail['max_air_speed'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<td>
						<input class="form-control text-right" type="text" name="cooling_pad_start" value="<?php echo angkaDecimalFormat($v_detail['cooling_pad_start'], 1); ?>" data-tipe="decimal1" <?php echo $disabled; ?> isedit="1" data-required="1">
					</td>
					<?php if ( $resubmit != '' ): ?>
						<td class="action text-center col-sm-1">
							<button id="btn-add" type="button" class="btn btn-sm btn-primary cursor-p" title="ADD ROW" onclick="sb.addRowTable(this)"><i class="fa fa-plus"></i></button>
							<button id="btn-remove" type="button" class="btn btn-sm btn-danger cursor-p" title="REMOVE ROW" onclick="sb.removeRowTable(this)"><i class="fa fa-minus"></i></button>
						</td>
					<?php endif ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<div class="col-lg-10 no-padding">
		<?php 
			$status = 'SUBMIT';
			if ( $v_data['g_status'] == 2 ) {
				$status = 'ACK';
			} else if ( $v_data['g_status'] == 3 ) {
				$status = 'APPROVE';
			} 
		?>
		<span><b>Status : <?php echo $status; ?></b></span>
	</div>
	<div class="col-lg-2">
		<?php if ( $akses['a_ack'] == 1 ){ 
				if ( $v_data['g_status'] == 1 ) { ?>
					<button id="btn-add" type="button" class="btn btn-primary cursor-p pull-right" title="ACK" onclick="sb.ack(this)" data-id="<?php echo $v_data['id']; ?>"> 
						<i class="fa fa-check" aria-hidden="true"></i> ACK
					</button>
		<?php } 
			} ?>
		<?php if ( $akses['a_approve'] == 1 ){
			if ( $v_data['g_status'] == 2 ) { ?>
			<button id="btn-add" type="button" class="btn btn-primary cursor-p pull-right" title="APPROVE" onclick="sb.approve(this)" data-id="<?php echo $v_data['id']; ?>"> 
				<i class="fa fa-check" aria-hidden="true"></i> APPROVE
			</button>
		<?php } 
			} ?>
	</div>
	<div class="col-sm-8 no-padding">
		<p>
			<b>Keterangan : </b>
			<?php
				foreach ($v_data['logs'] as $log) {
					$temp[] = '<li class="list">' . $log['deskripsi'] . ' pada ' . dateTimeFormat( $log['waktu'] ) . '</li>';
				}
				if ($temp) {
					echo '<ul>' . implode("", $temp) . '</ul>';
				}
			?>
		</p>
	</div>
<?php } ?>