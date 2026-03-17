<?php
namespace Model\Storage;

defined('BASEPATH') OR exit('No direct script access allowed');

use \Model\Storage\Conf as Conf;

class KreditKendaraanPelunasan_model extends Conf
{
    protected $table = 'kredit_kendaraan_pelunasan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tgl_bayar',
        'kode',
        'sisa_kredit',
        'jml_transfer',
        'diskon',
        'denda',
        'attachment'
    ];


    public function insertPelunasan(array $data)
    {
        try {
            $pelunasan = new KreditKendaraanPelunasan_model();
            $pelunasan->fill([
                'tgl_bayar'    => isset($data['tgl_bayar']) ? date("Y-m-d", strtotime($data['tgl_bayar'])) : '',
                'kode'         => $data['kode'] ?? null,
                'sisa_kredit'  => isset($data['sisa_kredit']) ? (float)$data['sisa_kredit'] : 0,
                'jml_transfer' => isset($data['jml_transfer']) ? (float)$data['jml_transfer'] : 0,
                'diskon'       => isset($data['diskon']) ? (float)$data['diskon'] : 0,
                'denda'        => isset($data['denda']) ? (float)$data['denda'] : 0,
                'attachment'   => isset($data['attachment']) ? $data['attachment'] : '',
            ]);
            
            $pelunasan->save();

            // $deskripsi_log = 'di-submit oleh ' . $this->userdata['detail_user']['nama_detuser'];
            // Modules::run( 'base/event/save', $pelunasan, $deskripsi_log );

            return $pelunasan->id; 

        } catch (\Exception $e) {
            log_message('error', 'Insert Pelunasan Error: ' . $e->getMessage());
            return false;
        }
    }

    public function updatePelunasan(array $data, array $where)
    {
        try {

            $pelunasan = KreditKendaraanPelunasan_model::where($where)->first();

            if (!$pelunasan) {
                return false;
            }

            $pelunasan->fill([
                'tgl_bayar'    => isset($data['tgl_bayar']) ? date("Y-m-d", strtotime($data['tgl_bayar'])) : $pelunasan->tgl_bayar,
                'kode'         => $data['kode'] ?? $pelunasan->kode,
                'sisa_kredit'  => isset($data['sisa_kredit']) ? (float)$data['sisa_kredit'] : $pelunasan->sisa_kredit,
                'jml_transfer' => isset($data['jml_transfer']) ? (float)$data['jml_transfer'] : $pelunasan->jml_transfer,
                'diskon'       => isset($data['diskon']) ? (float)$data['diskon'] : $pelunasan->diskon,
                'denda'        => isset($data['denda']) ? (float)$data['denda'] : $pelunasan->denda,
                'attachment'   => isset($data['attachment']) ? $data['attachment'] : '',
            ]);

            $pelunasan->save();

            // $deskripsi_log = 'di-update oleh ' . $this->userdata['detail_user']['nama_detuser'];
            // Modules::run( 'base/event/update', $pelunasan, $deskripsi_log );

            return $pelunasan->id;

        } catch (\Exception $e) {
            log_message('error', 'Update Pelunasan Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getPelunasanById($id)
    {
        try {
            $data = KreditKendaraanPelunasan_model::where('id', $id)->first();
            return $data;
        } catch (\Exception $e) {
            log_message('error', 'Get Pelunasan By ID Error: '.$e->getMessage());
            return null;
        }
    }

    public function getPelunasanByKode($kode)
    {
        try {
            $data = KreditKendaraanPelunasan_model::where('kode', $kode)->first();
            return $data;
        } catch (\Exception $e) {
            log_message('error', 'Get Pelunasan By ID Error: '.$e->getMessage());
            return null;
        }
    }


    public function deletePelunasan(array $where)
    {
        try {
            $pelunasan = KreditKendaraanPelunasan_model::where($where)->first();

            if(!$pelunasan){
                return false;
            }

            $pelunasan->delete();

            // $deskripsi_log = 'di-delete oleh ' . $this->userdata['detail_user']['nama_detuser'];
            // Modules::run( 'base/event/delete', $pelunasan, $deskripsi_log );
            return true;

        } catch (\Exception $e) {

            log_message('error', 'Delete Pelunasan Error: '.$e->getMessage());
            return false;
        }
    }


   
}