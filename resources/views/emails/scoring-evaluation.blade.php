<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>スコア評価レポート</title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700|Lato:300,400,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: #f6f7fb;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            padding: 35px 30px;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSgzMCkiPjxjaXJjbGUgY3g9IjIwIiBjeT0iMjAiIHI9IjEiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.6;
            z-index: 0;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .header h1 {
            margin: 0;
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 1px 2px 3px rgba(0,0,0,0.2);
        }
        .header p {
            margin: 10px 0 0;
            font-weight: 300;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 35px 40px;
            color: #444;
            line-height: 1.8;
        }
        .content p {
            margin-bottom: 20px;
        }
        .highlight {
            background: #f8f2ff;
            border-left: 4px solid #6d28d9;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 0 4px 4px 0;
        }
        .pdf-section {
            text-align: center;
            background: #f9f9fb;
            padding: 25px;
            border-radius: 6px;
            margin: 25px 0;
            border: 1px dashed #ddd;
        }
        .pdf-icon {
            font-size: 36px;
            color: #e53e3e;
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(to right, #4338ca, #6d28d9);
            color: #fff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 50px;
            margin-top: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(109, 40, 217, 0.3);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(109, 40, 217, 0.4);
        }
        .button .icon {
            margin-right: 8px;
            vertical-align: middle;
        }
        .footer {
            background: #f5f5f7;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #eaeaea;
        }
        .company-info {
            margin-top: 15px;
            font-size: 12px;
        }
        .divider {
            height: 1px;
            background: #eaeaea;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <h1>スコア評価レポート</h1>
                <p>2025年03月期 四半期分析</p>
            </div>
        </div>
        <div class="content">
            <p>お世話になっております。</p>
            
            <div class="highlight">
                <p>添付ファイルにて、<strong>最新のスコア評価レポート</strong>をお送りいたします。<br>
                ご多忙のところ恐れ入りますが、ご確認いただけますようお願い申し上げます。</p>
            </div>
            
            <p>今回のレポートでは前四半期と比較して<strong>20%の改善</strong>が見られました。詳細については添付のPDFをご覧ください。</p>
            
            <div class="pdf-section">
                <div class="pdf-icon">📊</div>
                <h3>スコア評価レポート.pdf</h3>
                <p>ファイルサイズ: 2.4MB</p>
                <a href="{{ $pdfFileName }}" class="button" download>
                    <span class="icon">📥</span>レポートを開く
                </a>
            </div>
            
            <p>ご不明点やご質問がございましたら、お気軽にお問い合わせください。</p>
            <p>今後ともよろしくお願い申し上げます。</p>
        </div>
        <div class="footer">
            <p>このメールは自動送信されています。</p>
            <div class="divider"></div>
            <div class="company-info">
            <p>INDEPENDENCE<br>
            株式会社インデペンデンス<br>
            〒541-0042 大阪市中央区今橋2丁目3-21 今橋藤浪ビルディング4階<br>
            Tel: 06-4706-6070</p>
            <p>インデペンデンスは証券業務全般をサポートします。<br>
            お気軽にご相談ください。</p>
            <p>&copy; 2025 INDEPENDENCE. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>