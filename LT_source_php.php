<?php

//タクシー台数、　目的地までの距離
//入力された文字列を$parameter1に代入　ex："2 1000"
echo "タクシー台数と目的地までの距離を半角スペース区切りで入力してください\n";
$parameter1 = trim(fgets(STDIN));

//$parameter1をスペース区切りで配列にして$parameter1_arrayに代入　ex：[2, 1000]
$parameter1_array = explode(" ", $parameter1);

//タクシー台数
$taxiNum = (int)$parameter1_array[0];

//目的地までの距離
$rangeToDistance = (int)$parameter1_array[1];

//インスタンス化させたタクシークラスを格納する配列
$taxi_array = [];

//それぞれのタクシーから聞いた運賃をメモしておく配列
$compareFare = [];

//parameter2を受け取って、タクシー台数分のインスタンス化を行う
echo "タクシー台数分のパラメータ（初乗り距離、初乗り運賃、加算距離、加算運賃）を半角スペース区切りで入力します\n";
for($i = 0; $i < $taxiNum; $i++){
    //初乗り距離、 初乗り運賃、 加算距離、 加算運賃
    //入力された文字列を$parameter2に代入　ex："600 200 200 400"
    echo "{$i + 1}台目のタクシーのパラメータを入力してください\n";
    $parameter2 = trim(fgets(STDIN));

    //parameter2をスペース区切りで配列にして$parameter2_arrayに代入　ex：[600, 200, 200, 400]
    $parameter2_array = explode(" ", $parameter2);

    //初乗り距離
    $firstSquareDistance = (int)$parameter2_array[0];
    //初乗り運賃
    $firstSquareFare = (int)$parameter2_array[1];
    //加算距離
    $additionalDistance = (int)$parameter2_array[2];
    //加算運賃
    $additionalFare = (int)$parameter2_array[3];
      
    //インスタンス化
    $taxi_array[] = new Taxi($firstSquareDistance, $firstSquareFare, $additionalDistance, $additionalFare);
}

//それぞれのタクシーから目的地までの距離を聞く
for($i = 0; $i < count($taxi_array); $i++){
    //タクシーから聞いた運賃を、$compareFareの配列に追加していく
    $compareFare[] = $taxi_array[$i]->AnswerFare($rangeToDistance);
}

//運賃をメモした配列から最高値を見つける
$maxFare = max($compareFare);
//運賃をメモした配列から最安値を見つける
$minFare = min($compareFare);

//最高値、最安値の表示
echo "{$minFare} {$maxFare}";

//タクシークラス
class Taxi{
    //フィールド：　クラスの中で扱う変数
    //初乗り運賃
    protected $firstSquareFare;
    //初乗り距離
    protected $firstSquareDistance;
    //加算運賃
    protected $additionalFare;
    //加算距離
    protected $additionalDistance;
    //運賃結果
    protected $resultFare;

    //コンストラクタ：　インスタンス化されたときに、一番最初に実行されるメソッド
    public function __construct($firstSquareDistance, $firstSquareFare, $additionalDistance, $additionalFare){
        //インスタンス時に受け取った引数を各フィールドに代入していく
        $this->firstSquareDistance = $firstSquareDistance;
        $this->firstSquareFare = $firstSquareFare;
        $this->additionalDistance = $additionalDistance;
        $this->additionalFare = $additionalFare;
        //運賃結果はまだわからないので、0「ゼロ」を代入
        $this->resultFare = 0;
    }

    public function AnswerFare($rangeToDistance){
        if($rangeToDistance < $this->firstSquareDistance)
        {
            //運賃は初乗り運賃
            //運賃結果に初乗り運賃を代入
            $this->resultFare = $this->firstSquareFare;
        }
        //それ以外（目的地が初乗り距離以上）だったら
        else
        {
            //運賃結果　＝　初乗り運賃　+　追加運賃

            //追加運賃を計算する
            //追加運賃　＝　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）

            //目的地までの残りの距離　＝　目的地までの距離　－　初乗り距離
            $remainDistance = $rangeToDistance - $this->firstSquareDistance;

            //運賃結果に初乗り運賃と追加運賃を足したものを代入
            //運賃結果　＝　初乗り料金　＋　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）
            $this->resultFare = $this->firstSquareFare + $this->additionalFare * (floor($remainDistance / $this->additionalDistance) + 1);
        }
        //運賃結果を教える
        return $this->resultFare;
    }
}
