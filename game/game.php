<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quiz Game: Kebudayaan Indonesia</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>
  <header>
    <h1>Quiz Kebudayaan Indonesia</h1>
  </header>
  <main role="main" aria-live="polite" aria-atomic="true">
    <div class="question-number" id="question-number"></div>
    <div class="question-text" id="question-text"></div>
    <div class="answers" id="answer-buttons"></div>
    <div class="feedback" id="feedback"></div>
    <button class="btn-next" id="next-btn" disabled>Next</button>
    <div class="score-section" id="score-section" hidden></div>
    <button class="btn-back" id="btn-back" hidden>Back to Game Dashboard</button>
  </main>
  <script>
    (function() {
      const questions = [
        {
          question: "Apa tarian tradisional yang berasal dari Bali?",
          answers: [
            { text: "Tari Saman", correct: false },
            { text: "Tari Kecak", correct: true },
            { text: "Tari Pendet", correct: true },
            { text: "Tari Jaipong", correct: false },
          ],
          multipleCorrect: true
        },
        {
          question: "Apa bahasa resmi negara Indonesia?",
          answers: [
            { text: "Bahasa Jawa", correct: false },
            { text: "Bahasa Indonesia", correct: true },
            { text: "Bahasa Sunda", correct: false },
            { text: "Bahasa Inggris", correct: false },
          ],
          multipleCorrect: false
        },
        {
          question: "Di pulau mana Rumah Gadang tradisional berada?",
          answers: [
            { text: "Sumatera Barat", correct: true },
            { text: "Jawa Tengah", correct: false },
            { text: "Bali", correct: false },
            { text: "Papua", correct: false },
          ],
          multipleCorrect: false
        },
        {
          question: "Apa alat musik tradisional Indonesia yang berasal dari Jawa dan berupa gong dan bilah logam?",
          answers: [
            { text: "Angklung", correct: false },
            { text: "Gamelan", correct: true },
            { text: "Kendang", correct: false },
            { text: "Sasando", correct: false },
          ],
          multipleCorrect: false
        },
        {
          question: "Upacara adat 'Sekaten' biasanya dirayakan untuk memperingati apa?",
          answers: [
            { text: "Hari Kemerdekaan", correct: false },
            { text: "Maulid Nabi Muhammad SAW", correct: true },
            { text: "Tahun Baru Imlek", correct: false },
            { text: "Hari Kartini", correct: false },
          ],
          multipleCorrect: false
        }
      ];

      function shuffleQuestions(array) {
        for (let i = array.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [array[i], array[j]] = [array[j], array[i]];
        }
      }

      // Properly shuffle answers for each question using Fisher-Yates shuffle
      function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [array[i], array[j]] = [array[j], array[i]];
        }
      }
      // Shuffle questions array as well
      shuffleArray(questions);
      questions.forEach(q => {
        shuffleArray(q.answers);
      });
      
      const questionNumberElement = document.getElementById('question-number');
      const questionTextElement = document.getElementById('question-text');
      const answerButtonsElement = document.getElementById('answer-buttons');
      const feedbackElement = document.getElementById('feedback');
      const nextButton = document.getElementById('next-btn');
      const scoreSection = document.getElementById('score-section');
      const backButton = document.getElementById('btn-back');

      let currentQuestionIndex = 0;
      let score = 0;
      
      let answered = false;

      function startQuiz() {
        currentQuestionIndex = 0;
        score = 0;
        answered = false;
        scoreSection.hidden = true;
        backButton.hidden = true;
        nextButton.hidden = false;
        nextButton.disabled = true;
        feedbackElement.textContent = '';
        showQuestion();
      }

      function showQuestion() {
        answered = false;
        nextButton.disabled = true;
        feedbackElement.textContent = '';
        answerButtonsElement.innerHTML = '';

        const currentQuestion = questions[currentQuestionIndex];
        questionNumberElement.textContent = `Pertanyaan ${currentQuestionIndex + 1} dari ${questions.length}`;
        questionTextElement.textContent = currentQuestion.question;

        currentQuestion.answers.forEach(answer => {
          const button = document.createElement('button');
          button.classList.add('answer-btn');
          button.textContent = answer.text;
          button.type = 'button';
          button.dataset.correct = answer.correct;
          button.addEventListener('click', selectAnswer);
          answerButtonsElement.appendChild(button);
        });
      }

      function selectAnswer(e) {
        if (answered) return;
        answered = true;
        const selectedButton = e.currentTarget;
        const correct = selectedButton.dataset.correct === 'true';
        const currentQuestion = questions[currentQuestionIndex];

        // Disable all buttons
        Array.from(answerButtonsElement.children).forEach(button => {
          button.disabled = true;
          if (button.dataset.correct === 'true') {
            button.classList.add('correct');
          } else {
            button.classList.remove('correct');
          }
        });

        if (correct) {
          selectedButton.classList.add('correct');
          feedbackElement.textContent = 'Benar!';
          feedbackElement.classList.remove('wrong');
          feedbackElement.classList.add('correct');
          score++;
        } else {
          selectedButton.classList.add('wrong');
          feedbackElement.textContent = 'Salah!';
          feedbackElement.classList.remove('correct');
          feedbackElement.classList.add('wrong');
        }

        nextButton.disabled = false;
      }

      function showScore() {
        questionNumberElement.textContent = '';
        questionTextElement.textContent = '';
        answerButtonsElement.innerHTML = '';
        feedbackElement.textContent = '';
        nextButton.hidden = true;
        scoreSection.hidden = false;
        backButton.hidden = false;
        scoreSection.textContent = `Kamu mendapatkan skor ${score} dari ${questions.length}.`;

        // Send score to server to save in database
        fetch('save_score.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'score=' + encodeURIComponent(score)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('Score saved successfully');
          } else {
            console.error('Failed to save score:', data.error);
          }
        })
        .catch(error => {
          console.error('Error saving score:', error);
        });
      }

      nextButton.addEventListener('click', () => {
        currentQuestionIndex++;
        if (currentQuestionIndex < questions.length) {
          showQuestion();
        } else {
          showScore();
        }
      });

      backButton.addEventListener('click', () => {
        window.location.href = '../game/game_dashboard.php';
      });

      startQuiz();
    })();
  </script>
</body>
<style>
    :root {
      --color-bg: #ffffff;
      --color-text: #374151;
      --color-primary: rgb(218, 141, 0);
      --color-primary-hover: rgb(218, 141, 0) ;
      --color-correct: #22c55e;
      --color-wrong: #ef4444;
      --color-card-bg: #f9fafb;
      --border-radius: 0.75rem;
      --shadow-card: 0 2px 8px rgba(0,0,0,0.05);
      --transition-speed: 0.3s;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
        Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      background-color: var(--color-bg);
      color: var(--color-text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1rem;
      line-height: 1.5;
      user-select: none;
    }

    header {
      width: 100%;
      max-width: 600px;
      padding-bottom: 2rem;
      text-align: center;
    }

    header h1 {
      font-weight: 700;
      font-size: 2.5rem;
      margin: 0;
      color: var(--color-primary);
      letter-spacing: 0.05em;
    }

    main {
      width: 100%;
      max-width: 600px;
      background: var(--color-card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-card);
      padding: 2rem 2.5rem;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .question-number {
      font-weight: 600;
      font-size: 1rem;
      color: var(--color-primary);
      letter-spacing: 0.06em;
      user-select: none;
    }

    .question-text {
      font-size: 1.375rem;
      font-weight: 600;
      margin: 0 0 1rem 0;
      color: var(--color-text);
      min-height: 72px;
      display: flex;
      align-items: center;
    }

    .answers {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    button.answer-btn {
      background: white;
      border: 2px solid var(--color-primary);
      border-radius: var(--border-radius);
      padding: 0.75rem 1rem;
      font-size: 1rem;
      font-weight: 600;
      color: var(--color-primary);
      cursor: pointer;
      transition:
        background-color var(--transition-speed),
        color var(--transition-speed),
        transform var(--transition-speed);
      display: flex;
      justify-content: center;
      align-items: center;
      user-select: none;
    }

    button.answer-btn:hover,
    button.answer-btn:focus-visible {
      background-color: var(--color-primary);
      color: white;
      outline: none;
      transform: scale(1.05);
      box-shadow: rgb(218, 141, 0);
      z-index: 1;
    }

    button.answer-btn.correct {
      background-color: var(--color-correct);
      color: white;
      border-color: var(--color-correct);
      cursor: default;
    }

    button.answer-btn.wrong {
      background-color: var(--color-wrong);
      color: white;
      border-color: var(--color-wrong);
      cursor: default;
    }

    .feedback {
      font-weight: 600;
      font-size: 1.125rem;
      min-height: 28px;
      color: var(--color-text);
      user-select: none;
      margin-top: -0.5rem;
      margin-bottom: 0.5rem;
      height: 28px;
    }

    .feedback.correct {
      color: var(--color-correct);
    }

    .feedback.wrong {
      color: var(--color-wrong);
    }

    .btn-next {
      background-color: var(--color-primary);
      color: white;
      font-weight: 700;
      font-size: 1rem;
      padding: 0.75rem 2rem;
      border: none;
      border-radius: var(--border-radius);
      cursor: pointer;
      align-self: flex-end;
      transition: background-color var(--transition-speed), transform var(--transition-speed);
      user-select: none;
      margin-top: 0.5rem;
    }

    .btn-next:disabled {
      background-color: rgb(186, 132, 31);
      cursor: default;
      transform: none;
      box-shadow: none;
    }

    .btn-next:hover:not(:disabled),
    .btn-next:focus-visible:not(:disabled) {
      background-color: var(--color-primary-hover);
      outline: none;
      transform: scale(1.05);
      box-shadow: rgb(218, 141, 0);
      z-index: 1;
    }

    .score-section {
      text-align: center;
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      margin-top: 1.5rem;
      color: var(--color-primary);
      user-select: none;
    }

    .btn-back {
      margin-top: 1rem;
      background-color: var(--color-primary);
      color: white;
      font-weight: 700;
      font-size: 1rem;
      padding: 0.75rem 2rem;
      border: none;
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: background-color var(--transition-speed), transform var(--transition-speed);
      user-select: none;
    }

    .btn-back:hover,
    .btn-back:focus-visible {
      background-color: var(--color-primary-hover);
      outline: none;
      transform: scale(1.05);
      box-shadow: rgb(153, 99, 0);
      z-index: 1;
    }

    @media (max-width: 440px) {
      main {
        padding: 1.5rem 1.5rem;
      }

      .answers {
        grid-template-columns: 1fr;
      }
    }
  </style>
</html>