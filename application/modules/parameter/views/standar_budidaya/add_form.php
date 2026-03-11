<div class="col-lg-1 no-padding pull-left">
	<h6>Tgl Berlaku : </h6>
</div>
<div class="col-lg-2 no-padding action">
    <div class="input-group date" id="datetimepicker1" name="tanggal-berlaku">
        <input type="text" class="form-control text-center" data-required="1" />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>
<div class="col-lg-6">
	<button id="btn-add" type="button" class="btn btn-primary cursor-p" title="SAVE" onclick="sb.save(this)"> 
		<i class="fa fa-save" aria-hidden="true"></i> SAVE
	</button>
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
			<th class="text-center" style="width: 6.76%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<input class="form-control text-right" type="text" name="umur" value="" data-tipe="integer" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="bb" value="" data-tipe="integer" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="fcr" value="" data-tipe="decimal3" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="daya_hidup" value="" data-tipe="decimal" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="ip" value="" data-tipe="integer" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="kons_pakan_harian" value="" data-tipe="integer" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="suhu_experience" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="heat_offset" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="kons_min_vent" value="" data-tipe="decimal3" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="min_vent" value="" data-tipe="decimal" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="chill_factor" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="min_air_speed" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="max_air_speed" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td>
				<input class="form-control text-right" type="text" name="cooling_pad_start" value="" data-tipe="decimal1" isedit="1">
			</td>
			<td class="action text-center">
				<button type="button" class="btn btn-sm btn-danger" onclick="sb.removeRowTable(this)"><i class="fa fa-minus"></i></button>
				<button type="button" class="btn btn-sm btn-default" onclick="sb.addRowTable(this)"><i class="fa fa-plus"></i></button>
			</td>
		</tr>
	</tbody>
</table>