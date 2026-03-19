<?php defined('BASEPATH') or exit('No direct script access allowed');

class PelunasanKendaraan extends Public_Controller
{
    private $pathView = 'accounting/pelunasan_kendaraan/';
    private $url;
    private $akses;

    public function __construct()
    {
        parent::__construct();
        $this->url = $this->current_base_uri;
        $this->akses = hakAkses($this->url);
    }

    public function index()
    {
        if ( $this->akses['a_view'] == 1 ) {
            
            $this->add_external_js(array(
                'assets/select2/js/select2.min.js',
                'assets/accounting/pelunasan_kendaraan/js/pelunasan-kendaraan.js',
                'assets/toastr/js/toastr.min.js')
                
            );
            $this->add_external_css(array(
                'assets/select2/css/select2.min.css',
                'assets/accounting/pelunasan_kendaraan/css/pelunasan-kendaraan.css',
                'assets/toastr/css/toastr.min.css')
            );
            $data = $this->includes;

            $content['akses']          = $this->akses;
            $content['title_panel']    = 'Pelunasan Kendaraan';

            // $content['pelunasan']      = $this->get_data_pelunasan() || [];
            // echo "<pre>";
            // print_r($content['pelunasan']);
            // die;
            $content['title_menu']     = 'Pelunasan Kendaraan';
            $data['view']              = $this->load->view($this->pathView . 'v_index', $content, TRUE);

            $this->load->view($this->template, $data);
        } else {
            showErrorAkses();
        }
    }

    public function add_data_modal()
    {
        $data_sisa_kredit = $this->get_data_sisa_kredit() ?? [];
        $kode             = "'" . implode("','", array_column($data_sisa_kredit, 'kode')) . "'";
        $data_kredit      = $this->get_data($kode);

        $map_sisa = [];
        foreach ($data_sisa_kredit as $row) {
            $map_sisa[$row['kode']] = $row['sisa_kredit'];
        }

        $data = [];
        foreach ($data_kredit as $row) {
            $row['sisa_kredit'] = isset($map_sisa[$row['kode']]) ? $map_sisa[$row['kode']]: 0;
            $data[] = $row;
        }

        // echo "<pre>";
        // print_r($data);
        // die;

        $data['kode_kredit'] = $data;
        echo $this->load->view($this->pathView . 'v_add_form', $data, true);
    }

    public function get_data_sisa_kredit()
    {
        $sql = "select
                    kk.kode,
                    kk.perusahaan as kode_perusahaan,
                    isnull(kkd.tot_angsuran_terbayar, 0) - (isnull(kkp.jml_transfer, 0) + isnull(kkp.diskon, 0)) as sisa_kredit
                from kredit_kendaraan kk
                left join
                (
                    select kredit_kendaraan_kode,
                        sum(jumlah_angsuran) as tot_angsuran_terbayar
                    from kredit_kendaraan_det
                    where tgl_bayar is null
                    group by kredit_kendaraan_kode
                ) kkd
                on kk.kode = kkd.kredit_kendaraan_kode
                left join kredit_kendaraan_pelunasan kkp
                on kk.kode = kkp.kode
                where isnull(kkd.tot_angsuran_terbayar, 0) - (isnull(kkp.jml_transfer, 0) + isnull(kkp.diskon, 0)) > 0";


        $m_conf = new \Model\Storage\Conf();
        $d_conf = $m_conf->hydrateRaw( $sql );

        $data = null;
        if ( $d_conf->count() > 0 ) {
            $data = $d_conf->toArray();
        }

        return $data;
    }

    public function get_data($kode)
    {
        $sql = "select kk.*, kk.perusahaan as kode_perusahaan, p.perusahaan as nama_perusahaan from kredit_kendaraan kk
                OUTER APPLY (
                    SELECT TOP 1 *
                    FROM perusahaan p
                    WHERE p.kode = kk.perusahaan
                    ORDER BY p.id DESC
                ) p
                where kk.kode in (".$kode.")";

        // echo "<pre>";
        // print_r($sql);
        // die;

        $m_conf = new \Model\Storage\Conf();
        $d_conf = $m_conf->hydrateRaw( $sql );

        $data = null;
        if ( $d_conf->count() > 0 ) {
            $data = $d_conf->toArray();
        }

        return $data;
    }

    public function exec_save_data() {
    
        $response = ['message' => 0, 'error' => ''];

        // echo "<pre>";
        // print_r($_FILES);
        // die;

        try {
            $data = [
                'tgl_bayar'    => $this->input->post('tgl_bayar', true),
                'kode_kredit'  => $this->input->post('kode_kredit', true),
                'perusahaan'   => $this->input->post('perusahaan', true),
                'merk_jenis'   => $this->input->post('merk_jenis', true),
                'warna'        => $this->input->post('warna', true),
                'tahun'        => $this->input->post('tahun', true),
                'unit'         => (float) ($this->input->post('unit') ?? 0),
                'sisa_kredit'  => (float) str_replace('.', '', $this->input->post('sisa_kredit') ?? 0),
                'jml_transfer' => (float) str_replace('.', '', $this->input->post('jml_transfer') ?? 0),
                'diskon'       => (float) str_replace('.', '', $this->input->post('diskon') ?? 0),
                'denda'        => (float) str_replace('.', '', $this->input->post('denda') ?? 0)
            ];

            $uploadedFileName = null;

            if(isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] === 0) {
                $uploadDir = FCPATH . "uploads/";
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $file               = $_FILES['file_attachment'];
                $ext                = pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadedFileName   = ubahNama($file['name']);
                $targetFile         = $uploadDir . $uploadedFileName;

                if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
                    throw new \Exception("Gagal upload file '{$file['name']}'");
                }
            }
  
            $dataInsert = [
                'tgl_bayar'    => $data['tgl_bayar'],
                'kode'         => $data['kode_kredit'],
                'sisa_kredit'  => $data['sisa_kredit'],
                'jml_transfer' => $data['jml_transfer'],
                'diskon'       => $data['diskon'],
                'denda'        => $data['denda'],
                'attachment'   => $uploadedFileName 
            ];

            

            $pelunasanModel = new \Model\Storage\KreditKendaraanPelunasan_model();
            $id = $pelunasanModel->insertPelunasan($dataInsert);

            $data_pelunasan = $pelunasanModel->find($id);
            $deskripsi_log  = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run('base/event/save', $data_pelunasan, $deskripsi_log);

            $config         = $this->set_status($id, 1);
            $lunas          = $this->set_lunas($data['kode_kredit'], 1);
            // echo "<pre>";
            // print_r($lunas);
            // die;

            $response['message'] = 1;

        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        echo json_encode($response);
    }

    public function exec_edit_data() {
    
        $response = ['message' => 0, 'error' => ''];

     
        try {
            $pelunasan_id = $this->input->post('pelunasan_id', true);

            $data = [
                'tgl_bayar'    => $this->input->post('tgl_bayar', true),
                'kode_kredit'  => $this->input->post('kode_kredit', true),
                'perusahaan'   => $this->input->post('perusahaan', true),
                'merk_jenis'   => $this->input->post('merk_jenis', true),
                'warna'        => $this->input->post('warna', true),
                'tahun'        => $this->input->post('tahun', true),
                'unit'         => $this->input->post('unit', true),
                'sisa_kredit'  => (float) str_replace('.', '', $this->input->post('sisa_kredit') ?? 0),
                'jml_transfer' => (float) str_replace('.', '', $this->input->post('jml_transfer') ?? 0),
                'diskon'       => (float) str_replace('.', '', $this->input->post('diskon') ?? 0),
                'denda'        => (float) str_replace('.', '', $this->input->post('denda') ?? 0),
            ];


            $pelunasanModel = new \Model\Storage\KreditKendaraanPelunasan_model();
            $dataLama       = $pelunasanModel->getPelunasanById($pelunasan_id);
            // echo "<pre>";
            // print_r($pelunasan_id);
            // die;
            $attachment     = $dataLama ? $dataLama->attachment : '';

            if(isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] === 0){

                $uploadDir = FCPATH . "uploads/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $file = $_FILES['file_attachment'];

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadedFileName = ubahNama($file['name']);
                $targetFile = $uploadDir . $uploadedFileName;

                if(move_uploaded_file($file['tmp_name'], $targetFile)){
                    if(!empty($attachment)){
                        $oldFile = $uploadDir . $attachment;
                        if(file_exists($oldFile)){
                            unlink($oldFile);
                        }
                    }

                    $attachment = $uploadedFileName;

                } else {
                    throw new Exception("Gagal upload file baru");
                }
            }

                

            $dataUpdate = [
                'tgl_bayar'    => date("Y-m-d", strtotime($data['tgl_bayar'])),
                'kode'         => $data['kode_kredit'],
                'sisa_kredit'  => $data['sisa_kredit'],
                'jml_transfer' => $data['jml_transfer'],
                'diskon'       => $data['diskon'],
                'denda'        => $data['denda'],
                'attachment'   => $attachment
            ];
       

            $where = [
                'id' => $pelunasan_id
            ];

            $config         = $this->set_status($pelunasan_id, 2);
            $pelunasanModel->updatePelunasan($dataUpdate, $where);

            $data_pelunasan = $pelunasanModel->find($pelunasan_id);
            $deskripsi_log  = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            Modules::run('base/event/update', $data_pelunasan, $deskripsi_log);

            $lunas          = $this->set_lunas($dataUpdate['kode_kredit'], 1);

            $response['message'] = 1;

        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        echo json_encode($response);
    }



    public function load_data()
    {
        $data['pelunasan'] = $this->get_data_pelunasan() ?: [];
        echo $this->load->view($this->pathView . 'v_list_data', $data, true);
    }


    public function filter_periode()
    {
        $data['pelunasan'] = $this->get_filter_data($_POST) ?: [];
        echo $this->load->view($this->pathView . 'v_list_data', $data, true);
    }



    public function get_filter_data($data)
    {
        $stardate = date("Y-m-d", strtotime($data['startdate']));
        $enddate  = date("Y-m-d", strtotime($data['enddate']));

        $sql = "SELECT kkp.*, kk.tahun , kk.unit, kk.merk_jenis, kk.warna, kk.perusahaan as kode_perusahaan, p.perusahaan as nama_perusahaan
                FROM kredit_kendaraan_pelunasan kkp
                JOIN kredit_kendaraan kk 
                    ON kkp.kode = kk.kode
                OUTER APPLY (
                    SELECT TOP 1 *
                    FROM perusahaan p
                    WHERE p.kode = kk.perusahaan
                    ORDER BY p.id DESC
                ) p ";

        if(!empty($data)){
            $sql .= " where kkp.tgl_bayar between '". $stardate ."' and '". $enddate ."' ";
        }

        $sql .= " order by kkp.id desc ";

        // echo "<pre>";
        // print_r($sql);
        // die;
        $m_conf = new \Model\Storage\Conf();
        $d_conf = $m_conf->hydrateRaw( $sql );

        $list_data = null;
        if ( $d_conf->count() > 0 ) {
            $list_data = $d_conf->toArray();
        }

        return $list_data;
    }

    public function get_data_pelunasan($pelunasan_id = null)
    {
        $sql = "SELECT kkp.*, kk.tahun , kk.unit, kk.merk_jenis, kk.warna, kk.perusahaan as kode_perusahaan, p.perusahaan as nama_perusahaan
                FROM kredit_kendaraan_pelunasan kkp
                JOIN kredit_kendaraan kk 
                    ON kkp.kode = kk.kode
                OUTER APPLY (
                    SELECT TOP 1 *
                    FROM perusahaan p
                    WHERE p.kode = kk.perusahaan
                    ORDER BY p.id DESC
                ) p ";

        if(!empty($pelunasan_id)){
            $sql .= " where kkp.id = '". $pelunasan_id."' ";
        }

        $sql .= " order by kkp.id desc ";

        // echo "<pre>";
        // print_r($sql);
        // die;


        $m_conf = new \Model\Storage\Conf();
        $d_conf = $m_conf->hydrateRaw( $sql );

        $list_data = null;
        if ( $d_conf->count() > 0 ) {
            $list_data = $d_conf->toArray();
        }

        return $list_data;
    }

    public function show_data_detail()
    {

        $data_detail    = $this->get_data_pelunasan($_POST['pelunasan_id']);
        $data['detail'] = $data_detail[0];
        // echo "<pre>";
        // print_r($data);
        // die;

        echo $this->load->view($this->pathView . 'v_detail_form', $data, true);

    }

    public function show_modal_edit()
    {

        $data_sisa_kredit = $this->get_data_sisa_kredit() ?? [];
        $kode             = "'" . implode("','", array_column($data_sisa_kredit, 'kode')) . "'";
        $data_kredit      = $this->get_data($kode);

        $map_sisa = [];
        foreach ($data_sisa_kredit as $row) {
            $map_sisa[$row['kode']] = $row['sisa_kredit'];
        }

        $data_temp = [];
        foreach ($data_kredit as $row) {
            $row['sisa_kredit'] = isset($map_sisa[$row['kode']]) ? $map_sisa[$row['kode']]: 0;
            $data_temp[] = $row;
        }

        $data_edit    = $this->get_data_pelunasan($_POST['pelunasan_id']);
     
        $data['edit'] = $data_edit[0];
        $data['kode_kredit'] = $data_temp;


       
     
        echo $this->load->view($this->pathView . 'v_edit_form', $data, true);

    }

    public function exec_delete_data(){

        $response = ['message' => 0, 'error' => ''];

        try {
            $pelunasan_id   = $this->input->post('pelunasan_id', true);
            $kode_pelunasan = $this->input->post('kode_pelunasan', true);

       
            
            if(!$pelunasan_id){
                throw new Exception("ID tidak ditemukan");
            }

            $pelunasanModel = new \Model\Storage\KreditKendaraanPelunasan_model();

            $data = $pelunasanModel->getPelunasanById($pelunasan_id);
            if(!$data){
                throw new Exception("Data tidak ditemukan");
            }

            if(!empty($data['attachment'])){
                $filePath = FCPATH . 'uploads/' . $data['attachment'];
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }

            $where = [
                'id' => $pelunasan_id
            ];

            $config = $this->set_status($pelunasan_id, 3);

            if($config){
                $data_pelunasan = $pelunasanModel->find($pelunasan_id);
                $delete         = $pelunasanModel->deletePelunasan($where);
                $deskripsi_log  = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
                Modules::run('base/event/delete', $data_pelunasan, $deskripsi_log);

                $lunas          = $this->set_lunas($kode_pelunasan, 0);

                if(!$delete){
                    throw new Exception("Data gagal dihapus");
                }
            }

            $response['message'] = 1;

        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
        }

        echo json_encode($response);
    }



    public function set_status($id, $status)
    {
        $config = false;

        $m_conf = new \Model\Storage\Conf();
        $sql = "EXEC insert_jurnal null, null, null, null, 'kredit_kendaraan_pelunasan', ?, ?, ?";
        $d_conf = $m_conf->hydrateRaw($sql, [$id, $id, $status]);

        if ($d_conf) {
            $config = true;
        }

        return $config;
    }


    public function set_lunas($kode, $status)
    {
        $m_kk = new \Model\Storage\KreditKendaraan_model();

        $update = $m_kk->where('kode', $kode)->update([
            'lunas' => $status
        ]);

        return $update ? true : false;
    }

}