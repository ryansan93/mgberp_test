<div class="form-area">

    <div class="input-data">
        <label for="" style="width:150px">Tgl. Bayar</label>
        <i class="icon fa fa-calendar"></i>
        <input type="text" value="<?php echo tglIndonesia($detail['tgl_bayar']) ?>" style="padding-left: 40px; cursor:pointer;" class="form form-control" disabled name="" id="tgl_bayar">
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Kode Kredit</label>
        <input type="text" value="<?php echo $detail['kode'] ?>" class="form form-control" name="" disabled >
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Perusahaan</label>
        <input type="text" value="<?php echo $detail['nama_perusahaan'] ?>" class="form form-control" name="" disabled >
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Merk & Jenis</label>
        <input type="text" value="<?php echo $detail['merk_jenis'] ?>" class="form form-control" name="" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Warna</label>
        <input type="text" value="<?php echo strtoupper($detail['warna']) ?>" class="form form-control" name="" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Tahun</label>
        <input type="text" value="<?php echo $detail['tahun'] ?>" class="form form-control" name="" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Unit</label>
        <input type="text" value="<?php echo $detail['unit'] ?>" class="form form-control" name="" disabled>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Sisa Kredit</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo angkaDecimal($detail['sisa_kredit']) ?>" disabled style="background-color:#eee; cursor: not-allowed;"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Jml. Transfer</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo angkaDecimal($detail['jml_transfer']) ?>" disabled style="background-color:#eee; cursor: not-allowed;"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Diskon</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo angkaDecimal($detail['diskon']) ?>" disabled style="background-color:#eee; cursor: not-allowed;"></div>
    </div>
    <div class="input-data">
        <label for="" style="width:150px">Denda</label>
        <div class="rupiah-input"><span>Rp</span><input type="text" value="<?php echo angkaDecimal($detail['denda']) ?>" disabled style="background-color:#eee; cursor: not-allowed;"></div>
    </div>

    <div class="input-data">
        <label for="" style="width:150px">Attachment</label>
        
        <div class="file-form" style="display:flex; flex-direction:row; gap:10px;">
            <input type="file" id="file_lampiran" class="file_lampiran" onchange="pk.get_lampiran(this, event)" style="display:none;">
            <div class="name-file-button" style="background-color:#eee; cursor: not-allowed; width:100%; font-size:12px; border-radius:5px; border: 1px solid #D6D6D6; padding:5px; color:#9E9E9E;">
                <a href="uploads/<?php echo $detail['attachment'] ?>" target="_blank">
                    <i class="fa fa-paperclip"></i> <?php echo $detail['attachment'] ?>
                </a>
            </div>
            
            
        </div>
    </div>


</div>

