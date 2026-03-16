
<?php if (count($pelunasan) > 0){?>

    <?php foreach($pelunasan as $p){?>
        <tr kode_pelunasan="<?php echo $p['kode'] ?>" pelunasan_id="<?php echo $p['id']?>" onclick="pk.show_detail(this, event)">
            <td style="white-space: nowrap;"><?php echo tglIndonesia($p['tgl_bayar'], '-', ' ') ?></td>
            <td style="white-space: nowrap;"><?php echo $p['kode'] ?></td>
            <td style="white-space: nowrap;"><?php echo $p['nama_perusahaan'] ?></td>
            <td style="white-space: nowrap;"><?php echo $p['merk_jenis'] ?></td>
            <td style="white-space: nowrap;"><?php echo $p['tahun'] ?></td>
            <td style="white-space: nowrap;"><?php echo $p['unit'] ?></td>
            <td style="white-space: nowrap;" class="text-right"><?php echo angkaDecimal($p['sisa_kredit']) ?></td>
            <td style="white-space: nowrap;" class="text-right"><?php echo angkaDecimal($p['jml_transfer']) ?></td>
        </tr>
    <?php } ?>  

<?php } else { ?>
    <tr>
        <td colspan="8" style="text-align:center;"><i>Tidak dad data</i></td>
    </tr>
<?php } ?>  
