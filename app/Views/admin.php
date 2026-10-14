<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kuis Arcade</title>
    
    <!-- TRIK REAL-TIME: Halaman ini akan otomatis me-refresh dirinya sendiri setiap 5 detik -->
    <meta http-equiv="refresh" content="5">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto; }
        h2 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; font-size: 14px; }
        th { background-color: #074E45; color: white; }
        tr:hover { background-color: #f9f9f9; }
        
        /* Gaya untuk gambar bukti IG */
        .img-proof { max-width: 80px; border-radius: 5px; cursor: pointer; transition: 0.2s; border: 2px solid #ccc; }
        .img-proof:hover { transform: scale(1.1); border-color: #F08519; }
        
        /* Badge Status */
        .badge { padding: 5px 10px; border-radius: 15px; font-weight: bold; font-size: 12px; }
        .badge-main { background-color: #ffe600; color: #000; }
        .badge-selesai { background-color: #4B8D7F; color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <h2>⚙️ Sistem Admin Kuis (Auto-Refresh Aktif)</h2>
    <p style="font-size: 12px; color: #666;">Halaman ini otomatis memperbarui data setiap 5 detik. Bukti IG bisa di-klik untuk memperbesar.</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No WhatsApp</th>
                <th>IP Address</th>
                <th>Bukti Follow IG</th>
                <th>Status</th>
                <th>Skor</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($peserta as $p): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td style="text-align: left; font-weight: bold;"><?= esc($p['nama']) ?></td>
                <td><?= esc($p['no_telp']) ?></td>
                <td><code style="background:#eee; padding:2px 5px;"><?= esc($p['ip_address']) ?></code></td>
                
                <!-- Menampilkan Gambar Bukti IG -->
                <td>
                    <?php if(!empty($p['bukti_ig'])): ?>
                        <!-- Gambar dibungkus tag <a> agar saat diklik akan terbuka ukuran aslinya di tab baru -->
                        <a href="<?= base_url('uploads/' . esc($p['bukti_ig'])) ?>" target="_blank">
                            <img src="<?= base_url('uploads/' . esc($p['bukti_ig'])) ?>" class="img-proof" alt="Bukti IG">
                        </a>
                    <?php else: ?>
                        <span style="color:red; font-size:12px;">Tidak Ada File</span>
                    <?php endif; ?>
                </td>

                <!-- Logika Cerdas untuk Status -->
                <td>
                    <?php if($p['skor'] === null || $p['skor'] === ''): ?>
                        <span class="badge badge-main">🎮 Sedang Bermain</span>
                    <?php else: ?>
                        <span class="badge badge-selesai">✅ Selesai</span>
                    <?php endif; ?>
                </td>

                <!-- Jika belum selesai, skor dan waktu tampilkan strip (-) -->
                <td><strong style="font-size: 18px;"><?= $p['skor'] !== null ? esc($p['skor']) : '-' ?></strong></td>
                <td><?= !empty($p['waktu_pengerjaan']) ? esc($p['waktu_pengerjaan']) . ' dtk' : '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>