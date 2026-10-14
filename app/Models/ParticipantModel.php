<?php
namespace App\Models;
use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table      = 'participants';
    protected $primaryKey = 'id';
    // PERBAIKAN: Tambahkan 'ip_address' di akhir array
    protected $allowedFields = ['nama', 'usia', 'no_telp', 'bukti_ig', 'skor', 'waktu_pengerjaan', 'ip_address'];
}