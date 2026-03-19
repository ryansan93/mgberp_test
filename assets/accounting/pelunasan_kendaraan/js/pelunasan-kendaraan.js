
let pk = {

    start_up : () => {
        pk.load_data(kode = null);
    }, 

    format_ribuan_input: (elm) => {
        let angka = $(elm).val();
        if(!angka) return;

        angka = angka.replace(/[^0-9]/g,'');
        let format = angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        $(elm).val(format);
    },

    format_ribuan_db: (angka) => {
        if(!angka) return "0";

        angka = angka.toString().split('.')[0]; // buang .00
        angka = angka.replace(/[^0-9]/g,'');

        return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    add_data: (elm,e) => {

        $.ajax({
            url : 'accounting/PelunasanKendaraan/add_data_modal',
            dataType : 'html',
            beforeSend : function(){
                 showLoading(); 
            },
            success : function(resp){
                hideLoading();
                bootbox.dialog({
                    title: "Tambah Data",
                    message: resp,
                    size: 'large',
                    buttons: {
                        cancel: {
                            label: "Batal",
                            className: "btn-secondary"
                        },
                        ok: {
                            label: "Simpan",
                            className: "btn-simpan btn-primary",
                            callback: function(){
                                let fileInput = $("#file_lampiran")[0];
                                let fileAttachment = null;

                                if(fileInput && fileInput.files && fileInput.files.length > 0){
                                    fileAttachment = fileInput.files[0];
                                }

                                let params = {
                                    tgl_bayar     : $("#tgl_bayar").val(),
                                    kode_kredit   : $("#kode_kredit").val(),
                                    perusahaan    : $("#perusahaan").attr("kode_perusahaan"),
                                    merk_jenis    : $("#merk_jenis").val(),
                                    warna         : $("#warna").val(),
                                    tahun         : $("#tahun").val(),
                                    unit          : $("#unit").val(),
                                    sisa_kredit   : $("#sisa_kredit").val(),
                                    jml_transfer  : $("#jml_transfer").val() || 0,
                                    diskon        : $("#diskon").val() || 0,
                                    denda         : $("#denda").val() || 0,
                                    file_attachment: fileAttachment 
                                };

                                pk.exec_save_data(params);
                            }
                        }
                    }
                });

                $(".btn-simpan").prop("disabled", true);
            }
        });
    },

    show_detail: (elm, e) => {
        let params ={
            pelunasan_id : $(elm).attr("pelunasan_id"),
            kode_pelunasan : $(elm).attr("kode_pelunasan"),
        }
        $.ajax({
            url : 'accounting/PelunasanKendaraan/show_data_detail',
            data : params,
            dataType : 'html',
            type : 'POST',
            beforeSend : function(){
                 showLoading(); 
            },
            success : function(resp){
                hideLoading();
                bootbox.dialog({
                    title: "Detail Data",
                    message: resp,
                    size: 'large',
                    buttons: {
                        batal: {
                            label: "<i class='fa fa-close'></i> Batal",
                            className: "btn-secondary",
                            callback: function(){

                            }
                        },
                        edit: {
                            label: "<i class='fa fa-pencil-square-o'></i> Edit",
                            className: "btn-warning",
                            callback: function(){
                                pk.show_modal_edit(params.pelunasan_id, params.kode_pelunasan);
                            }
                        },
                        hapus: {
                            label: "<i class='fa fa-trash'></i> Hapus",
                            className: "btn-danger",
                            callback: function(){
                               pk.exec_delete_data(params.pelunasan_id, params.kode_pelunasan);
                            }
                        }
                    }
                });

                $(".btn-simpan").prop("disabled", true);
            }
        });

    },

    set_data_kredit: (elm, e) => {
        let sdk = $(elm).find("option:selected");
        let params = {
            merk_jenis : sdk.attr("merk_jenis"),
            kode_perusahaan : sdk.attr("kode_perusahaan"),
            nama_perusahaan : sdk.attr("nama_perusahaan"),
            warna : sdk.attr("warna"),
            tahun : sdk.attr("tahun"),
            unit : sdk.attr("unit"),
            sisa_kredit : sdk.attr("sisa_kredit")
        }

        $("#merk_jenis").val(params.merk_jenis);
        $("#perusahaan").val(params.nama_perusahaan);
        $("#perusahaan").attr("kode_perusahaan", params.kode_perusahaan);
        $("#warna").val(params.warna);
        $("#tahun").val(params.tahun);
        $("#unit").val(params.unit);
        $("#sisa_kredit").val(pk.format_ribuan_db(params.sisa_kredit));
        // console.log(params)
    },

    get_number: (selector) => {
        let val = $(selector).val() || "";
        return parseInt(val.replace(/[^0-9]/g,'')) || 0;
    },

    input_kosong: function(elm) {
        if ($(elm).val().trim() == '') {
            $(elm).val('0');
            // toastr.info("Kolom tidak boleh kosong")
        }
    },

    cek_transfer: (elm, e) => {

        let sisaKredit  = pk.get_number("#sisa_kredit");
        let jmlTransfer = pk.get_number("#jml_transfer");
        let diskon      = pk.get_number("#diskon");
        let denda       = pk.get_number("#denda");

        // console.log(sisaKredit)
        // console.log(jmlTransfer)

        let valid = true;

        if(diskon > 0 && denda > 0){
            toastr.info("Diskon dan Denda tidak boleh diisi bersamaan");
            valid = false;
        }

        if(diskon > 0){
            if(jmlTransfer !== (sisaKredit - diskon)){
                toastr.info("Jumlah Transfer harus sama dengan Sisa Kredit - Diskon");
                valid = false;
            }
        }
        else if(denda > 0){
            if(jmlTransfer !== (sisaKredit + denda)){
                toastr.info("Jumlah Transfer harus sama dengan Sisa Kredit + Denda");
                valid = false;
            }
        }
        else{

            if(jmlTransfer !== sisaKredit){
                toastr.info("Jumlah Transfer harus sama dengan Sisa Kredit");
                valid = false;
            }
            
        }

        if(diskon > 0){
            $("#denda").prop("disabled", true);
            $("#denda").css("background-color", "#eee");
            $("#denda").css("cursor", "not-allowed");
        }else{
            $("#denda").prop("disabled", false);
            $("#denda").css("background-color", "");
            $("#denda").css("cursor", "");
        }

        if(denda > 0){
            $("#diskon").prop("disabled", true);
            $("#diskon").css("background-color", "#eee");
            $("#diskon").css("cursor", "not-allowed");
        }else{
            $("#diskon").prop("disabled", false);
            $("#diskon").css("background-color", "");
            $("#diskon").css("cursor", "");
        
        }

        $(".btn-simpan").prop("disabled", !valid);
        return valid;
    },

    exec_save_data: (data) => {
      
        let formData = new FormData();

        formData.append('tgl_bayar', data.tgl_bayar);
        formData.append('kode_kredit', data.kode_kredit);
        formData.append('perusahaan', data.perusahaan);
        formData.append('merk_jenis', data.merk_jenis);
        formData.append('warna', data.warna);
        formData.append('tahun', data.tahun);
        formData.append('unit', data.unit);
        formData.append('sisa_kredit', data.sisa_kredit);
        formData.append('jml_transfer', data.jml_transfer);
        formData.append('diskon', data.diskon);
        formData.append('denda', data.denda);

        if(data.file_attachment){ 
            formData.append('file_attachment', data.file_attachment); 
        }

        $.ajax({
            url: 'accounting/PelunasanKendaraan/exec_save_data',
            data: formData,
            type: 'POST',
            dataType: 'json',
            processData: false, 
            contentType: false,  
            beforeSend: function(){
                showLoading();
            },
            success: function(resp){
                // hideLoading();
                if(resp.message == 1){
                    toastr.success("Data Berhasil Disimpan");
                    pk.load_data(data.kode_kredit)
                }
            }
        });
    },

    exec_delete_data : function(pelunasan_id, kode_pelunasan){

        bootbox.dialog({
            title: "Konfirmasi",
            message: "Yakin ingin menghapus data ini?",
            buttons: {
                batal: {
                    label: "<i class='fa fa-times'></i> Batal",
                    className: "btn-secondary",
                    callback: function(){

                    }
                },
                hapus: {
                    label: "<i class='fa fa-trash'></i> Ya, Hapus",
                    className: "btn-danger",
                    callback: function(){
                        $.ajax({
                            url : 'accounting/PelunasanKendaraan/exec_delete_data',
                            type : 'POST',
                            dataType : 'json',
                            data : {
                                pelunasan_id : pelunasan_id,
                                kode_pelunasan : kode_pelunasan,
                            },
                            beforeSend : function(){
                                showLoading(); 
                            },
                            success : function(resp){
                                hideLoading();
                                if(resp.message == 1){

                                    // bootbox.alert("");
                                    toastr.success("Data berhasil dihapus")
                                    pk.load_data(kode = null);

                                }else{
                                    bootbox.alert(resp.error);
                                }
                            }
                        });
                    }
                }
            }
        });
    },

    load_data : (kode) =>{
        let content_tbody = $('.spinner-wrapper');
        $.ajax({
            url : 'accounting/PelunasanKendaraan/load_data',
            dataType : 'html',
            beforeSend : function(){
        
                App.showLoaderInContent(content_tbody);
            },
            success : function(html){
                App.hideLoaderInContent(content_tbody);
                hideLoading();
                $(".table-body").html(html);

                console.log(kode)

                $(".table-area tbody tr").each(function(){
                    let row = $(this).find("td:eq(1)").text().trim();
                    if(row == kode){
                        $(this).css("background-color", "#F5FFD4");
                    }
                });
            }
        })
    },


    show_modal_edit: (pelunasan_id, kode_pelunasan) => {
        
        $.ajax({
            url : 'accounting/PelunasanKendaraan/show_modal_edit',
            data : {
                'pelunasan_id' : pelunasan_id,
            },
            dataType : 'html',
            type : 'POST',
            beforeSend : function(){
                showLoading(); 
            },
            success : function(resp){
                hideLoading();

                bootbox.dialog({
                    title: "Edit Data",
                    message: resp,
                    size: 'large',
                    buttons: {
                        batal: {
                            label: "<i class='fa fa-close'></i> Batal",
                            className: "btn-danger",
                            callback: function(){
                                // pk.show_modal_edit(params.pelunasan_id);
                            }
                        },
                        simpan: {
                            label: "<i class='fa fa-check'></i> Simpan",
                            className: "btn-simpan btn-primary",
                            callback: function(){

                                let fileInput = $("#file_lampiran")[0];
                                let fileAttachment = null;

                                if(fileInput && fileInput.files && fileInput.files.length > 0){
                                    fileAttachment = fileInput.files[0];
                                }

                                let params = {
                                    pelunasan_id : pelunasan_id,
                                    tgl_bayar : $("#tgl_bayar_val").val(),
                                    kode_kredit : $("#kode_kredit").val(),
                                    perusahaan : $("#perusahaan").attr("kode_perusahaan"),
                                    merk_jenis : $("#merk_jenis").val(),
                                    warna : $("#warna").val(),
                                    tahun : $("#tahun").val(),
                                    unit : $("#unit").val(),
                                    sisa_kredit : $("#sisa_kredit").val(),
                                    jml_transfer : $("#jml_transfer").val() || 0,
                                    diskon : $("#diskon").val() || 0,
                                    denda : $("#denda").val() || 0,
                                    file_attachment: fileAttachment 
                                }
                                
                               pk.exec_edit_data(params);
                            }
                        }
                    }
                });

                // $(".btn-simpan").prop("disabled", true);
                
                $('#kode_kredit').val(kode_pelunasan).trigger('change');
                // $('#sisa_kredit').trigger('input');
                $('#jml_transfer').trigger('input');
                $('#diskon').trigger('input');
                $('#denda').trigger('input');
            }
        });

        
    },

    exec_edit_data: (data) => {

        let formData = new FormData();

        formData.append('pelunasan_id', data.pelunasan_id);
        formData.append('tgl_bayar', data.tgl_bayar);
        formData.append('kode_kredit', data.kode_kredit);
        formData.append('perusahaan', data.perusahaan);
        formData.append('merk_jenis', data.merk_jenis);
        formData.append('warna', data.warna);
        formData.append('tahun', data.tahun);
        formData.append('unit', data.unit);
        formData.append('sisa_kredit', data.sisa_kredit);
        formData.append('jml_transfer', data.jml_transfer);
        formData.append('diskon', data.diskon);
        formData.append('denda', data.denda);

        if(data.file_attachment){
            formData.append('file_attachment', data.file_attachment);
        }

        $.ajax({
            url : 'accounting/PelunasanKendaraan/exec_edit_data',
            data : formData,
            type : 'POST',
            dataType : 'json',
            processData : false,
            contentType : false,
            beforeSend : function(){
                showLoading(); 
            },
            success : function(resp){
                if(resp.message == 1){
                    toastr.success("Data Berhasil Diedit");
                    pk.load_data(data.kode_kredit)
                }
            }
        });

    },

    search_data : (elm, e) =>{
        let keyword = $(elm).val().toLowerCase();
        let found   = false;
        $('.table-body tr').each(function(){
            let text = $(this).text().toLowerCase();

            if(text.indexOf(keyword) > -1){
                $(this).show();
                found = true;
            }else{
                $(this).hide();
            }
        });


        
        if(!found){
            toastr.info("Data tidak ditemukan");
        }
    },


    filter_periode : (elm, e) => {
        let content_tbody = $('.spinner-wrapper');

        let params = {
            startdate : $("#startdate").val(),
            enddate : $("#enddate").val(),
        }

        $(".table-body").html('');

        $.ajax({
            url : 'accounting/PelunasanKendaraan/filter_periode',
            type: 'POST',
            data : params,
            dataType : 'html',
        beforeSend : function(){        
            App.showLoaderInContent(content_tbody);
        },
        success : function(html){
            App.hideLoaderInContent(content_tbody);
            hideLoading();
            $(".table-body").html(html);
            }
        })
    },

    check_zero : (elm) =>{
        if($(elm).val() == 0){
            $(elm).val('')
        }
    },


    edit_lampiran: (elm, e) => {
        let input = $(elm).closest(".file-form").find(".file_lampiran")[0];
        input.click(); 
        $(elm).closest(".file-form").removeAttr("id_file");
    },

    get_lampiran: (elm, e) =>{
        let file = $(elm)[0].files[0];

        let html = file.name;
        $(elm).closest(".file-form").find(".name-file-button").html(html);
    },


   
   
}

pk.start_up();

$(document).ready(function(){

    let today = new Date();

    $("#startdate").datepicker({
        dateFormat: "dd M yy",
        changeMonth: true,
        changeYear: true,
        altFormat: "yy-mm-dd",
        onSelect: function() {
            let startDate = $(this).datepicker("getDate");
            let endDate = $("#enddate").datepicker("getDate");

            $("#enddate").datepicker("option", "minDate", startDate);

            if (endDate < startDate) {
                $("#enddate").datepicker("setDate", startDate);
            }
        }
    }).datepicker("setDate", today);

    $("#enddate").datepicker({
        dateFormat: "dd M yy",
        changeMonth: true,
        changeYear: true,
        altFormat: "yy-mm-dd"
    }).datepicker("setDate", today);

    $("#enddate").datepicker("option", "minDate", $("#startdate").datepicker("getDate"));
});
