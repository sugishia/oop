using System;
using System.Linq;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        //入力値の受け取り　タクシーの数、目的地までの距離
        string[] parameter1 = Console.ReadLine().Trim().Split(' ');
        //比較するタクシーの数
        int taxiNum = int.Parse(parameter1[0]);
        //目的地までの距離
        int rangeToDistance = int.Parse(parameter1[1]);

        //タクシーの配列（リスト）を定義
        //タクシークラスのインスタンスを格納
        Taxi[] taxi = new Taxi[taxiNum];

        //料金比較用の配列（リスト）を定義　※compare：比較　fare：運賃
        int[] compareFare = new int[taxiNum];

        //入力値の受け取り、タクシークラスのインスタンス化をタクシーの台数分繰り返す
        for(int i = 0; i < taxiNum; i++)
        {
            //入力値の受け取り  初乗り距離、 初乗り運賃、 加算距離、 加算運賃
            string[] parameter2 = Console.ReadLine().Trim().Split(' ');
            //初乗り距離
            int firstSquareDistance = int.Parse(parameter2[0]);
            //初乗り運賃
            int firstSquareFare = int.Parse(parameter2[1]);
            //加算距離
            int additionalDistance = int.Parse(parameter2[2]);
            //加算運賃
            int additionalFare = int.Parse(parameter2[3]);
            
            //インスタンス化
            taxi[i] = new Taxi(firstSquareDistance, firstSquareFare, additionalDistance, additionalFare);
        }

        //それぞれのタクシーから教えてもらった運賃を運賃比較用の配列に代入
        for(int i = 0; i < compareFare.Length; i++)
        {
            compareFare[i] = taxi[i].AnswerFare(rangeToDistance);
        }

        //運賃比較用の配列から最高値を取り出す
        int maxFare = compareFare.Max();
        //運賃比較用の配列から最安値を取り出す
        int minFare = compareFare.Min();

        //最高値、最安値の表示
        Console.WriteLine("{0} {1}", minFare, maxFare);
    }
}

class Taxi
{
    //フィールド
    //クラスの中に定義された変数のこと
    //初乗り運賃
    private int firstSquareFare;
    //初乗り距離
    private int firstSquareDistance;
    //加算運賃
    private int additionalFare;
    //加算距離
    private int additionalDistance;
    //運賃結果
    private int resultFare;
    
    //コンストラクタ
    //インスタンス化されたときに、一番最初に実行されるメソッドのこと
    public Taxi(int firstSquareDistance, int firstSquareFare, int additionalDistance, int additionalFare)
    {
        //クラス変数にインスタンス時に受け取った引数を代入していく
        this.firstSquareFare = firstSquareFare;
        this.firstSquareDistance = firstSquareDistance;
        this.additionalFare = additionalFare;
        this.additionalDistance = additionalDistance;
        this.resultFare = 0;
    }
    
    //メソッド　目的地までの運賃を計算する
    //クラスの中に定義された関数のこと
    public int AnswerFare(int rangeToDistance)
    {
        //目的地が初乗り距離未満だったら
        if(rangeToDistance < this.firstSquareDistance)
        {
            //運賃は初乗り運賃
            //運賃結果に初乗り運賃を代入
            this.resultFare = firstSquareFare;
            //目的地が初乗り距離未満の運賃結果を教える
            return resultFare;
        }
        //それ以外（目的地が初乗り距離以上）だったら
        else
        {
            //運賃結果　＝　初乗り運賃　+　追加運賃

            //追加運賃を計算する　試行錯誤して下の計算式を出しました！
            //追加運賃　＝　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）

            //目的地までの残りの距離　＝　目的地までの距離　－　初乗り距離
            int remainDistance = rangeToDistance - this.firstSquareDistance;

            //運賃結果に初乗り運賃と追加運賃を足したものを代入
            //運賃結果　＝　初乗り料金　＋　加算運賃　×　（（（目的地までの残りの距離　÷　加算距離）の商）　+　１）
            this.resultFare = this.firstSquareFare + this.additionalFare * ((int)(remainDistance / this.additionalDistance) + 1);
            //それ以外（目的地が初乗り距離以上）の運賃結果を教える
            return this.resultFare;
        }
    }
}
