<?php
namespace App\Controllers;
use App\Models\ParticipantModel;

class Home extends BaseController
{
    public function index()
    {
        // 1. BLOKIR MAIN ULANG: Jika sudah pernah main, paksa ke halaman leaderboard
        if (session()->get('sudah_main')) {
            // PERBAIKAN: Ubah dari home/leaderboard menjadi leaderboard
            return redirect()->to(base_url('leaderboard')); 
        }
        
        return view('register');
    }

    public function save()
    {
        $participantModel = new \App\Models\ParticipantModel();
        
        /* 1. Tangkap IP Address Pengguna */
        /* 1. Tangkap IP Address Pengguna (Diperbarui untuk Ngrok) */
        $ipAsli = $this->request->getHeaderLine('X-Forwarded-For');
        
        if (!empty($ipAsli)) {
            // Ngrok kadang mengirim lebih dari 1 IP, kita ambil yang pertama (IP user asli)
            $ipAddress = trim(explode(',', $ipAsli)[0]);
        } else {
            // Jika kosong (misal Anda sedang ngetes langsung pakai link localhost), gunakan cara biasa
            $ipAddress = $this->request->getIPAddress();
        }
        
        /* 2. Cek apakah IP ini sudah ada di database */
        $cekIP = $participantModel->where('ip_address', $ipAddress)->first();
        
        if ($cekIP) {
            return redirect()->back()->withInput()->with('errors', ['Kamu sudah pernah memainkan kuis!']);
        }

        /* 3. PROSES VALIDASI & UPLOAD GAMBAR */
        $rules = [
            'bukti_ig' => [
                'rules' => 'uploaded[bukti_ig]|ext_in[bukti_ig,png,jpg,jpeg]|mime_in[bukti_ig,image/jpg,image/jpeg,image/png]|max_size[bukti_ig,10240]',
                'errors' => [
                    'uploaded' => 'Bukti Follow IG wajib diunggah.',
                    'ext_in'   => 'Format file ditolak! Hanya boleh .png, .jpg, atau .jpeg',
                    'mime_in'  => 'File yang diunggah harus berupa gambar yang valid.',
                    'max_size' => 'Ukuran gambar maksimal 10MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileIG = $this->request->getFile('bukti_ig');
        $namaFile = $fileIG->getRandomName();
        $fileIG->move('uploads', $namaFile);

        /* 4. Simpan data awal */
        $dataAwal = [
            'nama'       => $this->request->getPost('nama'),
            'usia'       => $this->request->getPost('usia'),
            'no_telp'    => $this->request->getPost('no_telp'),
            'bukti_ig'   => $namaFile, 
            'ip_address' => $ipAddress
        ];
        $participantModel->insert($dataAwal);

        /* 5. Simpan ID peserta yang baru daftar ke Session */
        $idPesertaBaru = $participantModel->insertID();
        session()->set('peserta_id', $idPesertaBaru);

        return redirect()->to('/kuis');
    }

    public function siap()
    {
        if (!session()->get('peserta_id')) {
            return redirect()->to(base_url('/'));
        }
        
        if (session()->get('sudah_main')) {
            return redirect()->to(base_url('leaderboard'));
        }
        
        return view('kuis');
    }

    public function submit_skor()
    {
        $idPeserta = session()->get('peserta_id');

        // Balas dengan JSON error jika sesi hilang
        if (!$idPeserta) {
            return $this->response->setStatusCode(401)
                                  ->setJSON(['status' => 'error', 'message' => 'Sesi tidak valid.']);
        }

        // Ambil data dari payload JSON yang dikirim oleh fetch
        $json = $this->request->getJSON();
        
        // Pastikan JSON memiliki format skor dan waktu (Gunakan simbol || yang benar)
        if (!$json || !isset($json->skor) || !isset($json->waktu_pengerjaan)) {
            return $this->response->setStatusCode(400)
                                  ->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap.']);
        }

        $participantModel = new \App\Models\ParticipantModel();
        
        // Lakukan update database (Pastikan baris ini berada di bawah dan tidak terkomentar)
        $updateBerhasil = $participantModel->update($idPeserta, [
            'skor'             => $json->skor,
            'waktu_pengerjaan' => $json->waktu_pengerjaan
        ]);

        if ($updateBerhasil) {
            session()->set('sudah_main', true);
            session()->remove('peserta_id');
            // Kembalikan JSON 'success'
            return $this->response->setStatusCode(200)->setJSON(['status' => 'success']);
        } else {
            return $this->response->setStatusCode(500)
                                  ->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
        }
    }

    public function leaderboard()
    {
        $model = new ParticipantModel();
        $data['peserta'] =$model->orderBy('skor', 'DESC')
                                 ->orderBy('waktu_pengerjaan', 'ASC')
                                 ->findAll();
        return view('leaderboard', $data);
    }

    public function admin()
    {
        $model = new ParticipantModel();
        $data['peserta'] =$model->orderBy('skor', 'DESC')
                                 ->orderBy('waktu_pengerjaan', 'ASC')
                                 ->findAll();
        return view('admin', $data);
    }
    
    public function reset()
    {
        // Hapus ingatan sistem bahwa kamu sudah main
        session()->remove('peserta_id');
        session()->remove('sudah_main');
        
        // PERBAIKAN: Arahkan langsung ke halaman form registrasi utama (/)
        return redirect()->to(base_url('/'));
    }
}