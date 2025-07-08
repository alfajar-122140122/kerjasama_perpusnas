<?php

namespace App\Models;

use CodeIgniter\Model;

class KerjasamaModel extends Model
{
    protected $table            = 'kerjasama';
    protected $primaryKey       = 'id_kerjasama';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi, disesuaikan dengan migrasi
    protected $allowedFields    = [
        'nama_mitra',
        'ruang_lingkup',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis',
        'progress',
        'latitude',
        'longitude',
        'created_by_user_id',
        'lokasi_mitra',
        'lingkup', // nasional atau internasional
        'status', // aktif, berakhir, menunggu perpanjangan
        'implementasi', // JSON array dengan list implementasi
        'unit_kerja',
        'kontak_nama',
        'kontak_email',
        'kontak_telepon',
        'region', // untuk mitra internasional
        'masa_berlaku', // digunakan untuk tampilan implementasi
        'tanggal_pengajuan' // untuk tracking progress
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
