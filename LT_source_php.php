<?php

$parameter1 = trim(fgets(STDIN));
$parameter1 = str_replace(array("\r\n","\r","\n"), '', $parameter1);
$parameter1 = explode(" ", $parameter1);
$taxiNum = (int)$parameter1[0];
$rangeToDistance = (int)$parameter1[1];
$taxi_array = [];
$compareFare = [];

for($i = 0; $i < $taxiNum; $i++){
    $parameter2 = trim(fgets(STDIN));
    $parameter2 = str_replace(array("\r\n","\r","\n"), '', $parameter2);
    $parameter2 = explode(" ", $parameter2);

    $firstSquareDistance = (int)$parameter2[0];
    //初乗り運賃
    $firstSquareFare = (int)$parameter2[1];
    //加算距離
    $additionalDistance = (int)$parameter2[2];
    //加算運賃
    $additionalFare = (int)$parameter2[3];
      
    //インスタンス化
    $taxi_array[] = new Taxi($firstSquareDistance, $firstSquareFare, $additionalDistance, $additionalFare);
}

for($i = 0; $i < count($taxi_array); $i++){
    $compareFare[] = $taxi_array[$i]->AnswerFare($rangeToDistance);
}

//運賃比較用の配列から最高値を取り出す
$maxFare = max($compareFare);
//運賃比較用の配列から最安値を取り出す
$minFare = min($compareFare);

//最高値、最安値の表示
echo "{$minFare} {$maxFare}";

class Taxi{
    //フィールド
    //クラスの中に定義された変数のこと
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

    //コンストラクタ
    //インスタンス化されたときに、一番最初に実行されるメソッドのこと
    public function __construct($firstSquareDistance, $firstSquareFare, $additionalDistance, $additionalFare){
        //クラス変数にインスタンス時に受け取った引数を代入していく
        $this->firstSquareDistance = $firstSquareDistance;
        $this->firstSquareFare = $firstSquareFare;
        $this->additionalDistance = $additionalDistance;
        $this->additionalFare = $additionalFare;
        $this->resultFare = 0;
    }

    public function AnswerFare($rangeToDistance){
        if($rangeToDistance < $this->firstSquareDistance)
        {
            //運賃は初乗り運賃
            //運賃結果に初乗り運賃を代入
            $this->resultFare = $this->firstSquareFare;
            //目的地が初乗り距離未満の運賃結果を教える
            return $this->resultFare;
        }
        //それ以外（目的地が初乗り距離以上）だったら
        else
        {
            //運賃結果　＝　初乗り運賃　+　追加運賃

            //追加運賃を計算する　試行錯誤して下の計算式を出しました！
            //追加運賃　＝　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）

            //目的地までの残りの距離　＝　目的地までの距離　－　初乗り距離
            $remainDistance = $rangeToDistance - $this->firstSquareDistance;

            //運賃結果に初乗り運賃と追加運賃を足したものを代入
            //運賃結果　＝　初乗り料金　＋　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）
            $this->resultFare = $this->firstSquareFare + $this->additionalFare * (floor($remainDistance / $this->additionalDistance) + 1);
            //それ以外（目的地が初乗り距離以上）の運賃結果を教える
            return $this->resultFare;
        }
    }
}