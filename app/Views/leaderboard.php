<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>High Scores</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #074E45; --bg-teal: #035C52; --bg-light-teal: #4B8D7F;
            --accent-orange: #F08519; --accent-red: #EA5B24;
            --black: #000000; --white: #FFFFFF;
        }
        * { box-sizing: border-box; }
        body { 
            margin: 0; font-family: 'Press Start 2P', cursive;
            background-color: var(--bg-dark); color: var(--white);
            display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; padding: 20px;
            background-image: linear-gradient(var(--bg-teal) 2px, transparent 2px), linear-gradient(90deg, var(--bg-teal) 2px, transparent 2px);
            background-size: 30px 30px;
        }
        
        /* Disamakan persis dengan tampilan form/kuis */
        .board-container { 
            background-color: var(--bg-teal); 
            border: 4px solid var(--black); 
            padding: 30px 25px;
            box-shadow: inset 4px 4px 0px var(--bg-light-teal), inset -4px -4px 0px rgba(0,0,0,0.3), 0 6px 0 var(--black);
            border-radius: 15px 15px 4px 4px; /* Sudut lengkung atas */
            width: 100%; max-width: 600px; text-align: center; margin-top: 20px;
            display: flex; flex-direction: column; gap: 15px;
        }
        
        .logo-game {
            width: 100%; max-width: 180px; 
            display: block; margin: 0 auto 5px auto;
        }

        h2 { color: var(--accent-orange); font-size: 22px; text-shadow: 2px 2px 0 var(--black); margin-top: 0; margin-bottom: 10px; line-height: 1.5; }
        
        .table-responsive { overflow-x: auto; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; min-width: 450px; background-color: #f0f0f0; } /* Latar tabel terang agar kontras dengan hijau */
        th, td { padding: 12px; text-align: center; border: 4px solid var(--black); font-size: 10px; line-height: 1.4; color: var(--black); }
        
        th { background-color: var(--accent-red); color: #ffe600; text-shadow: 1px 1px 0 var(--black); }
        
        /* Kolom nama menggunakan VT323 agar nama panjang muat dan mudah dibaca */
        td:nth-child(2) { font-family: 'VT323', monospace; font-size: 20px; text-align: left; text-shadow: 1px 1px 0px rgba(0,0,0,0.2); letter-spacing: 1px; font-weight: bold; }
        
        /* Highlight Peringkat 1 */
        tr:nth-child(1) td { background-color: #ffe600; color: var(--black); text-shadow: none; }
        tr:nth-child(1) td:first-child::before { content: '👑 '; } /* Diganti mahkota agar lebih terlihat di background kuning */

        /* Gaya Tombol Disamakan dengan Form */
        .pixel-btn {
            display: inline-block; text-decoration: none;
            font-family: 'Press Start 2P', cursive; background-color: var(--accent-red); color: #ffe600; 
            border: 4px solid var(--black); padding: 15px 20px; font-size: 12px; margin-top: 5px;
            box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 6px 0 var(--black);
            transition: transform 0.1s;
        }
        .pixel-btn:hover { background-color: var(--accent-orange); color: var(--white); }
        .pixel-btn:active { transform: translateY(6px); box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 0px 0 var(--black); }

        @media (max-width: 500px) {
            .board-container { padding: 20px 15px; border-width: 4px; }
            h2 { font-size: 16px; }
            th, td { padding: 8px; font-size: 8px; border-width: 4px; }
            td:nth-child(2) { font-size: 16px; }
            .pixel-btn { font-size: 10px; }
        }
    </style>
</head>
<body>
    <div class="board-container">
        
        <!-- Tambahan Logo agar seragam -->
        <img src="<?= base_url('QuizLogo.png') ?>" alt="Logo Game" class="logo-game">

        <h2>★ HIGH SCORES ★</h2>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>RANK</th>
                        <th style="text-align: left;">PLAYER</th>
                        <th>SCORE</th>
                        <th>TIME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rank = 1; ?>
                    <?php foreach($peserta as $p): ?>
                    <tr>
                        <td><?= $rank++; ?></td>
                        <td><?= esc(strtoupper($p['nama'])); ?></td>
                        <td><?= esc($p['skor'] * 1500); ?></td>
                        <td><?= esc($p['waktu_pengerjaan']); ?>s</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="<?= base_url('home/reset') ?>" class="pixel-btn">START NEW GAME</a>
    
    </div>
</body>
</html>