<div class="form-area">

    <div class="input-data">
        <label for="" style="width:150px">Tgl. Bayar</label>
        <i class="icon fa fa-calendar"></i>
        <input type="text" style="padding-left: 40px; cursor:pointer;" value="<?php echo $edit['tgl_bayar']?>" class="form form-control" readonly name="" id="tgl_bayar">
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Kode Kredit</label>
        <select name="" id="kode_kredit" class="form form-control" form_config="edit" onchange="pk.set_data_kredit(this, event), pk.cek_transfer(this, event)">
            <option disabled selected>-- Pilih Kode --</option>

            <?php if(count($kode_kredit) > 0){ ?>
                <?php foreach($kode_kredit as $k) { ?>
                    <option sisa_kredit="<?php echo $k['sisa_kredit'] ?>"  unit="<?php echo $k['unit'] ?>" tahun="<?php echo $k['tahun'] ?>" warna="<?php echo $k['warna'] ?>" nama_perusahaan="<?php echo $k['nama_perusahaan'] ?>" kode_perusahaan="<?php echo $k['kode_perusahaan'] ?>" merk_jenis="<?php echo $k['merk_jenis'] ?>" value="<?php echo $k['kode'] ?>">
                        <?php echo $k['kode'] ?>
                    </option>
                <?php } ?>
            <?php  } ?>
            <option sisa_kredit="<?php echo $edit['sisa_kredit'] ?>" selected  unit="<?php echo $edit['unit'] ?>" tahun="<?php echo $edit['tahun'] ?>" warna="<?php echo $edit['warna'] ?>" nama_perusahaan="<?php echo $edit['nama_perusahaan'] ?>" kode_perusahaan="<?php echo $edit['kode_perusahaan'] ?>" merk_jenis="<?php echo $edit['merk_jenis'] ?>" value="<?php echo $edit['kode'] ?>">
                    <?php echo $edit['kode'] ?>
            </option>
          
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
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo number_format((float)$edit['jml_transfer'],0,',','.') ?>" oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="jml_transfer"></div>
    </div>

    <?php 
        $diskon = $edit['diskon'] > 0 ? $edit['diskon'] : 0;
        $denda  = $edit['denda'] > 0 ? $edit['denda'] : 0;
    ?>
    <div class="input-data">
        <label for="" style="width:150px">Diskon</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo $diskon; ?>"  oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="diskon"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Denda</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo $denda; ?>"  oninput="pk.format_ribuan_input(this)" onchange="pk.cek_transfer(this, event)" id="denda"></div>
    </div>


    <div class="input-data">
        <label for="" style="width:150px">Attachment</label>
        
        <div class="file-form" style="display:flex; flex-direction:row; gap:10px;">
            <input type="file" id="file_lampiran" class="file_lampiran" onchange="pk.get_lampiran(this, event)" style="display:none;">
            <div class="name-file-button" style="width:75%; font-size:12px; border-radius:5px; border: 1px solid #D6D6D6; padding:5px; color:#9E9E9E;"><?php echo $edit['attachment'] ?></div>
            <button class="btn btn-warning" onclick="pk.edit_lampiran(this, event)"><i class="fa fa-paperclip"></i></button>
            <!-- <button class="btn btn-danger"><i class="fa fa-trash"></i></button> -->
        </div>
    </div>

    

</div>

<script>
    $(document).ready(function(){

        $("#tgl_bayar").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true
        }).datepicker("setDate", new Date());
        
        $("#kode_kredit").select2({
            placeholder: "Pilih Kode Kredit",
            width: '100%'
        });

    });
</script>