<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>QUIZ GAME</title>
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
            display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;
            background-image: linear-gradient(var(--bg-teal) 2px, transparent 2px), linear-gradient(90deg, var(--bg-teal) 2px, transparent 2px);
            background-size: 30px 30px;
        }
        .form-container { 
            background-color: var(--bg-teal); border: 4px solid var(--black); padding: 30px 25px;
            box-shadow: inset 4px 4px 0px var(--bg-light-teal), inset -4px -4px 0px rgba(0,0,0,0.3), 0 6px 0 var(--black);
            border-radius: 15px 15px 4px 4px; width: 100%; max-width: 450px; display: flex; flex-direction: column; gap: 15px;
        }
        h2 { text-align: center; margin: 0 0 10px 0; font-size: 20px; color: var(--accent-orange); text-shadow: 2px 2px 0 var(--black); line-height: 1.5; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-size: 10px; color: var(--white); text-shadow: 1px 1px 0 var(--black); }

        .logo-game {
            width: 100%; max-width: 180px; display: block; margin: 0 auto 15px auto;
        }
        
        input { 
            font-family: 'VT323', monospace; font-size: 20px; padding: 10px;
            background-color: #f0f0f0; border: 4px solid var(--black);
            box-shadow: inset 2px 2px 0px rgba(0,0,0,0.2); color: var(--black); outline: none;
        }
        input:focus { background-color: #fff; border-color: var(--accent-orange); }
        input[type="file"] { font-size: 16px; padding: 5px; cursor: pointer; }
        
        .pixel-btn {
            font-family: 'Press Start 2P', cursive; background-color: var(--accent-red); color: #ffe600; 
            border: 4px solid var(--black); padding: 15px 10px; font-size: 12px; margin-top: 15px;
            cursor: pointer; text-align: center;
            box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 6px 0 var(--black);
            transition: transform 0.1s;
        }
        .pixel-btn:hover { background-color: var(--accent-orange); color: var(--white); }
        .pixel-btn:active { transform: translateY(6px); box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 0px 0 var(--black); }
        
        /* Tombol Khusus Instagram */
        .btn-ig {
            display: inline-block; font-family: 'Press Start 2P', cursive; 
            background-color: var(--bg-light-teal); color: var(--white); 
            border: 4px solid var(--black); padding: 10px; font-size: 10px; 
            text-align: center; text-decoration: none;
            box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 4px 0 var(--black);
            transition: 0.1s; margin-bottom: 5px;
        }
        .btn-ig:hover { background-color: var(--bg-dark); color: var(--accent-orange); }
        .btn-ig:active { transform: translateY(4px); box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 0px 0 var(--black); }

        .error-box { background-color: var(--black); color: var(--accent-red); padding: 15px; border: 4px solid var(--accent-red); font-family: 'VT323', monospace; font-size: 18px; }
        .error-box ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <form action="<?= base_url('home/save') ?>" method="post" enctype="multipart/form-data" class="form-container">
        <img src="<?= base_url('QuizLogo.png') ?>" alt="Logo Game" class="logo-game">
        <h2>GET READY<br><span style="font-size:12px; color:var(--white);">GET PRIZES</span></h2>
        
        <?php if(session('errors')): ?>
            <div class="error-box">
                <ul><?php foreach (session('errors') as $error) : ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="nama">NAMA PLAYER</label>
            <input type="text" id="nama" name="nama" value="<?= old('nama') ?>" required>
        </div>
        <div class="form-group">
            <label for="usia">UMUR</label>
            <input type="number" id="usia" name="usia" value="<?= old('usia') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="no_telp">WHATSAPP NO.(WAJIB ANGKA)</label>
            <input type="tel" id="no_telp" name="no_telp" value="<?= old('no_telp') ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
        </div>
        
        <div class="form-group">
            <label for="bukti_ig">BUKTI FOLLOW IG (MAX 10MB)</label>
            <!-- Pengetatan format file di HTML -->
            <input type="file" id="bukti_ig" name="bukti_ig" accept=".png, .jpg, .jpeg, image/png, image/jpeg" required>

            <!-- Tombol Follow IG -->
            <a href="https://www.instagram.com/baitul_wakaf/" target="_blank" class="btn-ig">⭐ KLIK UNTUK FOLLOW IG</a>
        </div>
        
        <button type="submit" class="pixel-btn">PRESS START</button>
    </form>
</body>
</html>