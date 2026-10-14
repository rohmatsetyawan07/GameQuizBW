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
        
        /* PERBAIKAN FONT: Menghilangkan Bold bawaan dan menipiskan shadow agar sangat jelas dibaca */
        .question-box h3 {
            font-family: 'VT323', monospace; 
            font-weight: normal; /* Menghilangkan efek tebal bertumpuk */
            font-size: 26px; /* Sedikit diperbesar */
            letter-spacing: 1px; /* Jarak antar huruf */
            margin: 0; color: var(--white);
            text-shadow: 1px 1px 0 var(--black); /* Shadow ditipiskan */
            line-height: 1.3;
        }

        .btn-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .pixel-btn {
            font-family: 'Press Start 2P', cursive; background-color: var(--accent-red); color: #ffe600; 
            border: 4px solid var(--black); padding: 20px 10px; font-size: 12px; cursor: pointer; text-align: center;
            box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 6px 0 var(--black);
            transition: transform 0.1s, box-shadow 0.1s, background-color 0.2s; position: relative;
        }
        .pixel-btn:hover {
            background-color: var(--accent-orange); color: var(--white);
            outline: 4px dotted var(--accent-orange); outline-offset: 2px; animation: pulse 1s infinite alternate;
        }
        @keyframes pulse { 0% { outline-color: var(--accent-orange); } 100% { outline-color: var(--white); } }
        .pixel-btn:active { transform: translateY(6px); box-shadow: inset -4px -4px 0px rgba(0,0,0,0.2), inset 4px 4px 0px rgba(255,255,255,0.2), 0 0px 0 var(--black); }
        .btn-system { grid-column: span 2; background-color: var(--bg-light-teal); color: var(--white); }
        .btn-system:hover { background-color: var(--bg-teal); }
        .footer-nav { margin-top: 10px; display: flex; justify-content: center; gap: 20px; color: var(--bg-light-teal); font-size: 18px; }
        .hide { display: none !important; }
        
        @media (max-width: 400px) {
            .hud { font-size: 8px; } .score-value { font-size: 10px; }
            .pixel-btn { font-size: 10px; padding: 15px 5px; } .question-box h3 { font-size: 22px; }
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
        const questions = [
            { question: "Bahasa pemrograman apa yang digunakan untuk logika web di sisi client?", answers: ["A. PHP", "B. Python", "C. JavaScript", "D. C++"], correct: "C. JavaScript" },
            { question: "Singkatan dari CSS adalah?", answers: ["A. Cascading Style", "B. Creative Style", "C. Computer Style", "D. Colorful System"], correct: "A. Cascading Style" },
            { question: "Framework PHP yang sedang kita gunakan saat ini adalah?", answers: ["A. Laravel", "B. CodeIgniter", "C. Symfony", "D. Yii"], correct: "B. CodeIgniter" }
        ];
        let currentQuestionIndex = 0; let score = 0; let timerSeconds = 0; let timerInterval;
        const startScreen = document.getElementById('start-screen'); const quizScreen = document.getElementById('quiz-screen');
        const endScreen = document.getElementById('end-screen'); const endTitle = document.getElementById('end-title');
        const questionText = document.getElementById('question-text'); const answerButtonsElement = document.getElementById('answer-buttons');
        const scoreElement = document.getElementById('score'); const timerElement = document.getElementById('timer');
        document.getElementById('total-questions').innerText = questions.length;

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
            startScreen.classList.add('hide'); quizScreen.classList.remove('hide'); updateHUD();
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
                
                // Ubah teks saat menunggu
                endTitle.innerText = "STAGE CLEAR!";
                endTitle.style.color = "var(--accent-orange)";
                document.querySelector('#end-screen h3').innerText = "Menyimpan rekaman...";

                fetch('<?= base_url('home/submit_skor') ?>', {
                    method: 'POST', 
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-Requested-With': 'XMLHttpRequest' 
                    },
                    body: JSON.stringify({ skor: score, waktu_pengerjaan: timerSeconds })
                })
                .then(response => {
                    // PERBAIKAN: Cek apakah respons dari server adalah 200 (OK)
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.message || 'Error Server'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.status === 'success') { 
                        // Jika sukses, baru arahkan ke leaderboard yang benar
                        window.location.href = '<?= base_url('leaderboard') ?>'; 
                    } else {
                        throw new Error(data.message || 'Gagal mengirim data skor.');
                    }
                })
                .catch(error => {
                    // PERBAIKAN: Tampilkan pesan error di layar jika pengiriman gagal (tidak macet)
                    endTitle.innerText = "SYSTEM ERROR";
                    endTitle.style.color = "red";
                    document.querySelector('#end-screen h3').innerHTML = 
                        error.message + "<br><br><button class='pixel-btn' onclick='location.reload()' style='font-size:12px; margin-top:20px;'>COBA LAGI</button>";
                });
            }, 500); 
        }
    </script>
</body>
</html>