<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スコア評価レポート</title>
    <style>
        body {
            font-family: ipag, 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
            margin: 0;
        }
        .subtitle {
            font-size: 16px;
            color: #6B7280;
            margin-top: 5px;
        }
        .date {
            font-size: 14px;
            color: #6B7280;
            margin-top: 10px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            color: #4F46E5;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .score-summary {
            background-color: #F9FAFB;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .score-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .score-item {
            display: flex;
            justify-content: space-between;
            padding: 8px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .score-label {
            font-weight: 500;
            color: #4B5563;
        }
        .score-value {
            font-weight: bold;
            color: #4F46E5;
        }
        .chart-container {
            width: 100%;
            height: 400px;
            margin: 0 auto;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .container {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <div class="header">

            <h1 class="title">スコア評価レポート</h1>
            <p class="subtitle">{{ $userName ?? 'ユーザー' }}様の芸術作品★評価</p>
            <p class="date">作成日: {{ date('Y年m月d日') }}</p>
            <p>タイムスタンプ: {{ $timestamp }}</p>
        </div>

        <div class="section">
            <h2 class="section-title">スコア評価概要</h2>
            <div class="score-summary">
                <p>このスコアはあなたの芸術作品の特徴を生成AIが評価したものです。<br>
                各項目のスコアが高いほど、その特徴が強調されています。</p>
                
                <div class="score-grid">
                    <div class="score-item">
                        <span class="score-label">スタイル:</span>
                        <span class="score-value">{{ $score->style ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">伝統と革新:</span>
                        <span class="score-value">{{ $score->tradition_innovation ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">内省と感情:</span>
                        <span class="score-value">{{ $score->introspective_emotional ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">色彩感覚:</span>
                        <span class="score-value">{{ $score->color_sense ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">構図:</span>
                        <span class="score-value">{{ $score->composition ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">技術:</span>
                        <span class="score-value">{{ $score->technique ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">テーマ:</span>
                        <span class="score-value">{{ $score->theme ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">エネルギー:</span>
                        <span class="score-value">{{ $score->energy ?? 3 }}</span>
                    </div>
                    <div class="score-item">
                        <span class="score-label">独自性:</span>
                        <span class="score-value">{{ $score->uniqueness ?? 3 }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="footer">
            <p>このレポートは {{ config('app.name', 'アート評価システム') }} によって自動生成されました。</p>
            <p>&copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('scoreRadarChart').getContext('2d');
            
            // データの設定
            const data = {
                labels: [
                    'スタイル', 
                    '伝統と革新', 
                    '内省と感情', 
                    '色彩感覚', 
                    '構図', 
                    '技術', 
                    'テーマ', 
                    'エネルギー', 
                    '独自性'
                ],
                datasets: [{
                    label: 'スコア評価',
                    data: [
                        {{ $score->style ?? 3 }},
                        {{ $score->tradition_innovation ?? 3 }},
                        {{ $score->introspective_emotional ?? 3 }},
                        {{ $score->color_sense ?? 3 }},
                        {{ $score->composition ?? 3 }},
                        {{ $score->technique ?? 3 }},
                        {{ $score->theme ?? 3 }},
                        {{ $score->energy ?? 3 }},
                        {{ $score->uniqueness ?? 3 }}
                    ],
                    fill: true,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    pointBackgroundColor: 'rgb(79, 70, 229)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(79, 70, 229)'
                }]
            };

            // チャートの設定
            const config = {
                type: 'radar',
                data: data,
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                            suggestedMax: 5,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            };

            // チャートの描画
            new Chart(ctx, config);
        });
    </script>
</body>
</html>