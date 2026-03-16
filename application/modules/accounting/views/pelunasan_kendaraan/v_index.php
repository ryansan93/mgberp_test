

<div class="body">

    <fieldset style="margin-bottom: 15px;">
        <legend>
            <div class="col-xs-12 no-padding">
                <b>Filter Data</b>
            </div>
        </legend>
        <div class="col-xs-12 no-padding notifContain">
                        
            <div class="filter-area">
                <div class="filter-input">
                    <label for="">Periode</label>
                    <div class="input-date">
                        <i class="icon fa fa-calendar"></i>
                        <input type="text" class="form form-control" id="startdate" style="cursor:pointer;" readonly>
                    </div>
                    <i>s/d</i>
                    <div class="input-date">
                        <i class="icon fa fa-calendar"></i>
                        <input type="text" class="form form-control" id="enddate" style="cursor:pointer;" readonly>
                        <button class="btn btn-secondary" onclick="pk.filter_periode(this, event)"><i class="fa fa-search"></i> Filter</button>
                    </div>

                </div>
                <button class="btn btn-primary" onclick="pk.add_data(this, event)">
                    <i class="fa fa-plus"></i> Tambah Data</button>
            </div>

        </div>
    </fieldset>
    

    <hr>

    <fieldset style="margin-bottom: 15px;">
        <legend>
            <div class="col-xs-12 no-padding">
                <b>Riwayat Data</b>
            </div>
        </legend>
        <div class="col-xs-12 no-padding notifContain" style="position:relative;">
                        
           <div style="display:flex; justify-content:flex-end; margin-bottom:10px; position:relative">
                <i class="fa fa-search" style="position:absolute; margin-top:10px; margin-right:130px; color:grey"></i>
                <input type="text" class="form-control form-control-sm " placeholder="Seacrh data" style="width:150px; padding-left:30px;" oninput="pk.search_data(this, event)">
            </div>
            <div class="table-area">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tgl. Bayar</th>
                            <th>Kode Kredit</th>
                            <th>Perusahaan</th>
                            <th>Merk  & Jenis</th>
                            <th>Tahun</th>
                            <th>Unit</th>
                            <th>Sisa Kredit</th>
                            <th>Transfer</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        
                    </tbody>
                </table>

                <div class="spinner-wrapper">
                    <div class="spinner-load"></div>
                </div>
            </div>

        </div>
    </fieldset>
    
</div>

