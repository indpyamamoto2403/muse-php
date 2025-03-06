<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //最初にQuestionのレコードを全削除
        DB::table('questions')->delete();

        DB::table('questions')->insert([
            [
                'title' => '印象派の絵画に惹かれますか？',
                'body' => 'モネやルノワールなどの印象派画家の作品についてのあなたの感想を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'クラシック音楽を聴くことはありますか？',
                'body' => 'バッハ、モーツァルト、ベートーベンなどのクラシック音楽についてのあなたの意見を共有してください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '現代アートは「芸術」だと思いますか？',
                'body' => '現代アートの価値や意義についてあなたはどのように考えていますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '抽象画より具象画を好みますか？',
                'body' => 'あなたは写実的な絵画と抽象的な絵画のどちらに魅力を感じますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '映画館で映画を見るのが好きですか？',
                'body' => '映画鑑賞の体験について、映画館と自宅での視聴を比較してどう思いますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '美術館に行くことはありますか？',
                'body' => '美術館訪問の頻度や、最近感銘を受けた展示について教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '演劇鑑賞は好きですか？',
                'body' => '劇場での生の演技を見ることについて、あなたの体験や感想を共有してください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '詩を読むことはありますか？',
                'body' => '詩についてのあなたの興味や好きな詩人について教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ジャズ音楽に親しみを感じますか？',
                'body' => 'ジャズの即興性や表現力についてどのように感じますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '写真芸術は他の視覚芸術と同等だと思いますか？',
                'body' => '写真と絵画や彫刻などの伝統的な芸術形態を比較してどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '建築物を鑑賞することはありますか？',
                'body' => '建築を芸術として見た時に、どのような点に注目しますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'バレエやコンテンポラリーダンスを鑑賞しますか？',
                'body' => 'ダンスパフォーマンスについてのあなたの印象や好みを教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '小説を読む時、文体と物語どちらを重視しますか？',
                'body' => '文学作品を評価する際に、どのような要素を大切にしていますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'デジタルアートは従来の芸術と比べて価値があると思いますか？',
                'body' => 'デジタル技術を用いた芸術作品についてのあなたの見解を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ストリートアートは公共空間にあるべきだと思いますか？',
                'body' => 'グラフィティやストリートアートの社会的意義についてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'オペラは魅力的だと感じますか？',
                'body' => 'オペラの音楽性や演劇性についてのあなたの印象を聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '彫刻作品に触れることができるとしたら、触りたいですか？',
                'body' => '視覚だけでなく触覚で芸術を体験することについてどう思いますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '実験的な映画やアート映画に興味はありますか？',
                'body' => '一般的な商業映画と比較して、実験映画についてどのように感じますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ファッションはアートだと思いますか？',
                'body' => 'ファッションデザインを芸術として捉えることについて、あなたの見解を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '博物館と美術館、より頻繁に訪れるのはどちらですか？',
                'body' => '歴史的展示と芸術展示、どちらにより興味を持ちますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '伝統工芸は現代でも価値がありますか？',
                'body' => '伝統的な技術と現代のデジタル技術を比較して、どのように考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ミュージカルは好きですか？',
                'body' => '歌と演技が組み合わさったミュージカル形式についての感想を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品の価格は妥当だと思いますか？',
                'body' => '芸術市場での作品の値付けについて、あなたの見解を聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '漫画やアニメは芸術だと思いますか？',
                'body' => '日本のマンガやアニメーションを芸術として捉えることについてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品は政治的メッセージを含むべきですか？',
                'body' => '芸術と政治の関係性について、あなたの考えを共有してください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '民族音楽や世界の伝統音楽に興味はありますか？',
                'body' => '様々な文化の音楽についてのあなたの関心度を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術は感情を表現するべきだと思いますか？',
                'body' => '芸術における感情表現の重要性について、あなたの見解を聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '舞台照明やサウンドデザインは芸術だと思いますか？',
                'body' => '舞台芸術における技術的要素の芸術性について考えを共有してください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'インスタレーション作品は体験する価値がありますか？',
                'body' => '空間全体を使った芸術表現についての印象を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'コンセプチュアルアートは理解できますか？',
                'body' => '概念や思想を重視する芸術について、どのように感じますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品の複製品は原作と同じ価値を持つと思いますか？',
                'body' => 'レプリカやプリントと原作の関係について、あなたの考えを教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ビデオゲームは芸術形式だと思いますか？',
                'body' => 'インタラクティブなメディアとしてのビデオゲームの芸術性をどう評価しますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '料理は芸術だと思いますか？',
                'body' => '食の審美性や創造性について、あなたの視点を共有してください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '美しさは芸術の必須要素だと思いますか？',
                'body' => '芸術において美の概念はどれほど重要だと考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'ライブ音楽とレコーディングされた音楽、どちらが好きですか？',
                'body' => '音楽体験における生演奏と録音の違いについてどう感じますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '公共空間にある芸術作品は重要だと思いますか？',
                'body' => '公共アートが社会や地域に与える影響について考えを聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術教育は学校カリキュラムに必要だと思いますか？',
                'body' => '子供の発達における芸術教育の役割についてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品を自宅に飾っていますか？',
                'body' => '日常生活の中で芸術とどのように関わっていますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '光と影を意識的に使った芸術作品に惹かれますか？',
                'body' => '光の表現や活用が効果的な作品について、あなたの印象を教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '文学作品を原作とした映画は原作を超えることはあると思いますか？',
                'body' => '異なるメディア間での芸術作品の翻案についてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品の解釈は作者の意図に忠実であるべきですか？',
                'body' => '鑑賞者による自由な解釈と作者の意図の関係についてどう思いますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '合唱音楽は心に響きますか？',
                'body' => '複数の声が重なる合唱の効果について、あなたの感想を聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'モノクロ写真とカラー写真、どちらに芸術性を感じますか？',
                'body' => '色彩の有無が写真表現にどのような違いをもたらすと思いますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '対称性と非対称性、芸術においてどちらが魅力的ですか？',
                'body' => 'バランスと不均衡の美学について、あなたの好みを教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術の商業化についてどう思いますか？',
                'body' => '芸術の価値と市場原理の関係について、あなたの見解を聞かせてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'AIが生成した芸術は本物の芸術だと思いますか？',
                'body' => '人工知能による創作物の芸術的価値についてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'あなたは何か芸術的な活動を行っていますか？',
                'body' => '創作活動や芸術的表現への参加について教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '映画音楽は単独で鑑賞する価値がありますか？',
                'body' => '映像から切り離された映画音楽の芸術性についてどう思いますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '風景画と抽象画、どちらにより魅力を感じますか？',
                'body' => '自然の描写と抽象的表現についての好みを教えてください。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '芸術作品は社会を変える力を持つと思いますか？',
                'body' => '芸術が社会や文化に与える影響力についてどう考えますか？',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
