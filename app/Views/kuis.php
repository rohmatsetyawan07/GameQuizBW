<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kuis 8-Bit Arcade</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #074E45; --bg-teal: #035C52; --bg-light-teal: #4B8D7F;
            --accent-orange: #F08519; --accent-red: #EA5B24;
            --black: #000000; --white: #FFFFFF;
        }
        * { box-sizing: border-box; user-select: none; }
        body { 
            margin: 0; font-family: 'Press Start 2P', cursive; background-color: var(--bg-dark); color: var(--white);
            display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 10px;
            background-image: linear-gradient(var(--bg-teal) 2px, transparent 2px), linear-gradient(90deg, var(--bg-teal) 2px, transparent 2px);
            background-size: 30px 30px;
        }
        .game-container { width: 100%; max-width: 500px; display: flex; flex-direction: column; gap: 15px; }
        
        .hud {
            display: flex; justify-content: space-between; align-items: flex-start;
            background: var(--black); padding: 15px; border: 4px solid var(--bg-light-teal);
            font-size: 10px; line-height: 1.8; box-shadow: inset -4px -4px 0px rgba(0,0,0,0.5);
        }
        .hud-left { display: flex; flex-direction: column; gap: 5px; }
        .hud-right { text-align: right; color: var(--accent-orange); }
        .score-value { color: var(--accent-orange); font-size: 12px; }

        .question-box {
            background-color: var(--bg-teal); border: 4px solid var(--black); padding: 25px 20px; text-align: center;
            box-shadow: inset 4px 4px 0px var(--bg-light-teal), inset -4px -4px 0px rgba(0,0,0,0.3), 0 6px 0 var(--black);
            border-radius: 15px 15px 4px 4px; margin-bottom: 10px;
        }
        
        .question-box h3 {
            font-family: 'VT323', monospace; 
            font-weight: normal; 
            font-size: 24px; 
            letter-spacing: 1px; 
            margin: 0; color: var(--white);
            text-shadow: 1px 1px 0 var(--black); 
            line-height: 1.3;
        }

        .btn-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .pixel-btn {
            font-family: 'Press Start 2P', cursive; background-color: var(--accent-red); color: #ffe600; 
            border: 4px solid var(--black); padding: 16px 10px; font-size: 10px; line-height: 1.5; cursor: pointer; text-align: center;
            box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 6px 0 var(--black);
            transition: transform 0.1s, box-shadow 0.1s, background-color 0.2s; position: relative; word-wrap: break-word;
        }
        .pixel-btn:hover {
            background-color: var(--accent-orange); color: var(--white);
            outline: 4px dotted var(--accent-orange); outline-offset: 2px; animation: pulse 1s infinite alternate;
        }
        @keyframes pulse { 0% { outline-color: var(--accent-orange); } 100% { outline-color: var(--white); } }
        .pixel-btn:active { transform: translateY(6px); box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 0px 0 var(--black); }
        .btn-system { grid-column: span 2; background-color: var(--bg-light-teal); color: var(--white); font-size: 12px;}
        .btn-system:hover { background-color: var(--bg-teal); }
        .footer-nav { margin-top: 10px; display: flex; justify-content: center; gap: 20px; color: var(--bg-light-teal); font-size: 18px; }
        .hide { display: none !important; }
        
        @media (max-width: 400px) {
            .hud { font-size: 8px; } .score-value { font-size: 10px; }
            .pixel-btn { font-size: 9px; padding: 12px 5px; } .question-box h3 { font-size: 20px; }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div id="start-screen" class="question-box" style="border-radius: 4px;">
            <h2 style="font-size:18px; margin-bottom: 20px; color: var(--accent-orange); text-shadow: 2px 2px 0 #000; line-height:1.5;">★ KUIS ARCADE ★</h2>
            <h3 style="margin-bottom: 30px; font-size:22px;">Jawab dengan cepat<br>kumpulkan skor tertinggi!</h3>
            <div class="btn-grid"><button class="pixel-btn btn-system" onclick="startQuiz()">PRESS START</button></div>
        </div>
        <div id="quiz-screen" class="hide">
            <div class="hud">
                <div class="hud-left"><div>SKOR: <span id="score" class="score-value">000000</span> ★</div></div>
                <div class="hud-right"><div>WAKTU</div><div id="timer" style="font-size: 14px; margin-top:5px;">00:00</div></div>
            </div>
            <div class="question-box">
                <div style="font-size: 10px; margin-bottom: 15px; color: var(--accent-orange); font-weight:bold; text-shadow: 1px 1px 0 #000;">STAGE <span id="current-question-num">1</span>/<span id="total-questions"></span></div>
                <h3 id="question-text">Loading...</h3>
            </div>
            <div id="answer-buttons" class="btn-grid"></div>
            <div class="footer-nav"><span>✚</span> <span>↻</span> <span>⚙</span></div>
        </div>
        <div id="end-screen" class="hide question-box" style="border-radius: 4px;">
            <h2 id="end-title" style="font-size:18px; color: var(--accent-orange); margin-bottom: 20px;">STAGE CLEAR!</h2>
            <h3 style="margin-bottom: 30px; font-size:22px;">Menyimpan rekaman...</h3>
        </div>
    </div>
    
    <script>
        // 10 Data Soal dari File Word
        const masterQuestions = [
            {
                question: "Dibawah ini harta yang memenuhi syarat wakaf, kecuali …",
                answers: ["A. Makanan", "B. Tanah", "C. Bangunan masjid", "D. Emas"],
                correct: "A. Makanan"
            },
            {
                question: "Orang yang memberikan atau mewakafkan hartanya disebut...",
                answers: ["A. Wakif", "B. Nadzir", "C. Miskin", "D. Musafir"],
                correct: "A. Wakif"
            },
            {
                question: "Menurut Undang-Undang Nomor 41 Tahun 2004 tentang Wakaf, apakah tanah yang sudah diwakafkan boleh ditarik kembali?",
                answers: [
                    "A. Boleh, asalkan ada persetujuan keluarga",
                    "B. Boleh, jika si wakif mengalami kesulitan ekonomi",
                    "C. Tidak boleh, karena harta wakaf tidak dapat ditarik kembali, dijual, atau diwariskan",
                    "D. Boleh dengan menggantinya dengan uang tunai"
                ],
                correct: "C. Tidak boleh, karena harta wakaf tidak dapat ditarik kembali, dijual, atau diwariskan"
            },
            {
                question: "Barang yang diwaqafkan harus bisa diambil manfaatnya dan keadaannya masih tetap, artinya benda tersebut tidak berkurang atau tidak habis jumlahnya adalah syarat dari …",
                answers: ["A. Waqif", "B. Mauquf", "C. Mauquf alaih", "D. Nazir"],
                correct: "B. Mauquf"
            },
            {
                question: "Wakaf merupakan salah satu amal ibadah yang pahalanya terus mengalir meskipun orang yang mengamalkannya telah meninggal dunia. Amal ibadah jenis ini disebut dengan...",
                answers: ["A. Amal Ibadah Insaniyah", "B. Amal Jariyah", "C. Sedekah Yaumiyah", "D. Zakat Maal"],
                correct: "B. Amal Jariyah"
            },
            {
                question: "Di dalam ketentuan syariat, harta yang sudah diwakafkan secara sah status kepemilikannya berubah menjadi milik...",
                answers: [
                    "A. Milik Nadzir (pengelola) sepenuhnya",
                    "B. Milik ahli waris dari keluarga wakif",
                    "C. Milik Allah SWT yang manfaatnya untuk kemaslahatan umum",
                    "D. Milik pemerintah atau negara"
                ],
                correct: "C. Milik Allah SWT yang manfaatnya untuk kemaslahatan umum"
            },
            {
                question: "Pihak atau badan hukum yang menerima harta wakaf untuk dikelola dan disalurkan sesuai tujuannya disebut...",
                answers: ["A. Wakif", "B. Muzakki", "C. Shahibul Maal", "D. Nadzir"],
                correct: "D. Nadzir"
            },
            {
                question: "Sebuah ruko wakaf disewakan dengan harga Rp30.000.000 per tahun. Biaya perawatan ruko dan pembayaran pajak per tahun menghabiskan dana sebesar Rp4.000.000. Berapakah nominal hak nadzir maksimal (10% dari keuntungan bersih) yang berhak diterima oleh pengelola?",
                answers: ["A. Rp400.000", "B. Rp2.600.000", "C. Rp3.000.000", "D. Rp5.600.000"],
                correct: "B. Rp2.600.000"
            },
            {
                question: "Pernyataan atau kehendak dari orang yang berwakaf yang diucapkan atau dituliskan secara resmi untuk mewakafkan harta bendanya disebut...",
                answers: ["A. Ikrar Wakaf", "B. Khotbah Wakaf", "C. Wasiat Harta", "D. Ijab Qabul Jual Beli"],
                correct: "A. Ikrar Wakaf"
            },
            {
                question: "Suatu yayasan mengelola wakaf uang produktif sebesar Rp200.000.000 dan diinvestasikan ke dalam sukuk negara (surat berharga syariah) dengan imbal hasil (yield) sebesar 6% per tahun. Berapakah total dana imbal hasil bersih yang didistribusikan untuk program sosial per tahun, jika nadzir mengambil hak operasional sebesar 10% dari total imbal hasil?",
                answers: ["A. Rp1.200.000", "B. Rp10.800.000", "C. Rp12.000.000", "D. Rp18.000.000"],
                correct: "B. Rp10.800.000"
            }
        ];

        // Fungsi untuk mengacak urutan elemen di dalam array (Fisher-Yates Shuffle)
        function shuffleArray(array) {
            let currentIndex = array.length, randomIndex;
            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
            }
            return array;
        }

        let questions = [];
        let currentQuestionIndex = 0; let score = 0; let timerSeconds = 0; let timerInterval;
        
        const startScreen = document.getElementById('start-screen'); 
        const quizScreen = document.getElementById('quiz-screen');
        const endScreen = document.getElementById('end-screen'); 
        const endTitle = document.getElementById('end-title');
        const questionText = document.getElementById('question-text'); 
        const answerButtonsElement = document.getElementById('answer-buttons');
        const scoreElement = document.getElementById('score'); 
        const timerElement = document.getElementById('timer');

        function play8BitBeep(type = 'correct') {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator(); const gainNode = ctx.createGain();
            osc.type = 'square';
            if (type === 'correct') {
                osc.frequency.setValueAtTime(600, ctx.currentTime); osc.frequency.exponentialRampToValueAtTime(1200, ctx.currentTime + 0.1);
            } else {
                osc.frequency.setValueAtTime(300, ctx.currentTime); osc.frequency.exponentialRampToValueAtTime(150, ctx.currentTime + 0.2);
            }
            gainNode.gain.setValueAtTime(0.1, ctx.currentTime); gainNode.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.1);
            osc.connect(gainNode); gainNode.connect(ctx.destination); osc.start(); osc.stop(ctx.currentTime + 0.15);
        }

        function formatTime(sec) {
            let m = Math.floor(sec / 60).toString().padStart(2, '0'); let s = (sec % 60).toString().padStart(2, '0'); return m + ':' + s;
        }

        function updateHUD() { scoreElement.innerText = (score * 1500).toString().padStart(6, '0'); }

        function startQuiz() {
            // Mengacak urutan dari masterQuestions dan memasukkannya ke variabel questions
            questions = shuffleArray([...masterQuestions]);
            document.getElementById('total-questions').innerText = questions.length;
            
            startScreen.classList.add('hide'); 
            quizScreen.classList.remove('hide'); 
            updateHUD();
            
            timerInterval = setInterval(() => { timerSeconds++; timerElement.innerText = formatTime(timerSeconds); }, 1000);
            setNextQuestion();
        }

        function setNextQuestion() {
            while (answerButtonsElement.firstChild) { answerButtonsElement.removeChild(answerButtonsElement.firstChild); }
            showQuestion(questions[currentQuestionIndex]);
        }

        function showQuestion(question) {
            document.getElementById('current-question-num').innerText = currentQuestionIndex + 1;
            questionText.innerText = question.question;
            question.answers.forEach(answer => {
                const button = document.createElement('button'); button.innerText = answer; button.classList.add('pixel-btn');
                button.addEventListener('click', () => selectAnswer(answer, question.correct));
                answerButtonsElement.appendChild(button);
            });
        }

        function selectAnswer(selectedAnswer, correctAnswer) {
            if (selectedAnswer === correctAnswer) { score++; play8BitBeep('correct'); } else { play8BitBeep('wrong'); }
            updateHUD(); currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) { setTimeout(setNextQuestion, 150); } else { finishQuiz(); }
        }

        function finishQuiz() {
            clearInterval(timerInterval);
            setTimeout(() => {
                quizScreen.classList.add('hide'); 
                endScreen.classList.remove('hide');
                
                endTitle.innerText = "STAGE CLEAR!";
                endTitle.style.color = "var(--accent-orange)";
                document.querySelector('#end-screen h3').innerText = "Menyimpan rekaman...";

                fetch('<?= base_url('home/submit_skor') ?>', {
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ skor: score, waktu_pengerjaan: timerSeconds })
                })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw new Error(err.message || 'Error Server'); });
                    return response.json();
                })
                .then(data => {
                    if(data.status === 'success') { window.location.href = '<?= base_url('leaderboard') ?>'; } 
                    else { throw new Error(data.message || 'Gagal mengirim data skor.'); }
                })
                .catch(error => {
                    endTitle.innerText = "SYSTEM ERROR";
                    endTitle.style.color = "red";
                    document.querySelector('#end-screen h3').innerHTML = error.message + "<br><br><button class='pixel-btn' onclick='location.reload()' style='font-size:12px; margin-top:20px;'>COBA LAGI</button>";
                });
            }, 500); 
        }
    </script>
</body>
</html>