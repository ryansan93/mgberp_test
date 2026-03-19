<div class="form-area">

    <div class="input-data">
        <label for="" style="width:150px">Tgl. Bayar</label>
        <i class="icon fa fa-calendar"></i>
        <input type="text" style="padding-left: 40px; cursor:pointer;" class="form form-control" readonly name="" id="tgl_bayar">
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Kode Kredit</label>
        <select name="" id="kode_kredit" class="form form-control" onchange="pk.set_data_kredit(this, event)">
            <option disabled selected>-- Pilih Kode --</option>
            <?php foreach($kode_kredit as $k) { ?>

                <option sisa_kredit="<?php echo $k['sisa_kredit'] ?>"  unit="<?php echo $k['unit'] ?>" tahun="<?php echo $k['tahun'] ?>" warna="<?php echo $k['warna'] ?>" nama_perusahaan="<?php echo $k['nama_perusahaan'] ?>" kode_perusahaan="<?php echo $k['perusahaan'] ?>" merk_jenis="<?php echo $k['merk_jenis'] ?>" value="<?php echo $k['kode'] ?>">
                    <?php echo $k['kode'] ?>
                </option>

            <?php } ?>
        </select>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Perusahaan</label>
        <input type="text" class="form form-control" name="" id="perusahaan" disabled >
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Merk & Jenis</label>
        <input type="text" class="form form-control" name="" id="merk_jenis" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Warna</label>
        <input type="text" class="form form-control" name="" id="warna" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Tahun</label>
        <input type="text" class="form form-control" name="" id="tahun" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Unit</label>
        <input type="text" class="form form-control" name="" id="unit" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Sisa Kredit</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="0" id="sisa_kredit" style="background-color:#eee; cursor: not-allowed;"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Jml. Transfer</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="0" onclick="pk.check_zero(this);" onblur="pk.input_kosong(this)" oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="jml_transfer"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Diskon</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="0" onclick="pk.check_zero(this);" onblur="pk.input_kosong(this)" oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="diskon"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Denda</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="0" onclick="pk.check_zero(this);" onblur="pk.input_kosong(this)" oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="denda"></div>
    </div>

    <div class="input-data">
        <label for="" style="width:150px">Attachment</label>
        
        <div class="file-form" style="display:flex; flex-direction:row; gap:10px;">
            <input type="file" id="file_lampiran" class="file_lampiran" onchange="pk.get_lampiran(this, event)" style="display:none;">
            <div class="name-file-button" style="width:75%; font-size:12px; border-radius:5px; border: 1px solid #D6D6D6; padding:5px; color:#9E9E9E;">Upload File Attachment</div>
            <button class="btn btn-warning" onclick="pk.edit_lampiran(this, event)"><i class="fa fa-paperclip"></i></button>
            <!-- <button class="btn btn-danger"><i class="fa fa-trash"></i></button> -->
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){

        $("#tgl_bayar").datepicker({
            dateFormat: "dd M yy",
            changeMonth: true,
            changeYear: true,
            altFormat: "yy-mm-dd"
        }).datepicker("setDate", new Date());
        
        $("#kode_kredit").select2({
            placeholder: "Pilih Kode Kredit",
            width: '100%'
        });

    });
</script>