using System;
using System.Linq;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        //入力値の受け取り
        string[] config1 = Console.ReadLine().Trim().Split(' ');
        //比較するタクシーの数
        int taxiNum = int.Parse(config1[0]);
        //目的地までの距離
        int rangeToDestance = int.Parse(config1[1]);

        //タクシークラスの配列（リスト）を定義
        //タクシークラスをいくつインスタンス化させるか
        Taxi[] taxi = new Taxi[taxiNum];
        //料金比較用の配列（リスト）を定義　※compare：比較　fare：運賃
        int[] compareFare = new int[taxiNum];

        //入力値の受け取りとタクシークラスのインスタンス化をタクシー台数分繰り返す
        for(int i = 0; i < taxiNum; i++)
        {
            //入力値の受け取り
            //初乗り距離 a_i、 初乗り運賃 b_i、 加算距離 c_i、 加算運賃 d_i 
            string[] config2 = Console.ReadLine().Trim().Split(' ');
            //初乗り距離
            int firstSquareDistance = int.Parse(config2[0]);
            //初乗り運賃
            int firstSquareFare = int.Parse(config2[1]);
            //加算距離
            int additionalDistance = int.Parse(config2[2]);
            //加算運賃
            int additionalFare = int.Parse(config2[3]);
            
            //インスタンス化
            taxi[i] = new Taxi(rangeToDestance, firstSquareDistance, firstSquareFare, additionalDistance, additionalFare);
        }

        //それぞれのタクシーの運賃を計算して運賃比較用の配列に代入
        for(int i = 0; i < compareFare.Length; i++)
        {
            compareFare[i] = taxi[i].FareCalc();
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
    //クラス変数
    //目的地までの距離
    private int rangeToDistance;
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
    public Taxi(int rangeToDistance, int firstSquareDistance, int firstSquareFare, int additionalDistance, int additionalFare)
    {
        //クラス変数にインスタンス時に受け取った引数を代入していく
        this.rangeToDistance = rangeToDistance;
        this.firstSquareFare = firstSquareFare;
        this.firstSquareDistance = firstSquareDistance;
        this.additionalFare = additionalFare;
        this.additionalDistance = additionalDistance;
    }
    
    //メソッド　目的地までの運賃を計算する
    public int FareCalc()
    {
        //目的地が初乗り距離未満だったら
        if(rangeToDistance < firstSquareDistance)
        {
            //運賃は初乗り料金
            return firstSquareFare;
        }
        //それ以外（目的地が初乗り距離以上）だったら
        else
        {
            //運賃結果　＝　初乗り運賃　+　追加運賃
            //運賃結果に初乗り運賃を代入
            resultFare = firstSquareFare;

            //追加運賃を計算する
            //追加運賃　＝　加算運賃　＊　（（（目的地までの残りの距離　÷　加算距離）の端数切り捨て）　+　１）

            //目的地までの残りの距離
            int remainDistance = rangeToDistance - firstSquareDistance;

            //追加運賃
            resultFare = resultFare + additionalFare * (Math.Floor(remainDistance / additionalDistance) + 1);

            return resultFare;
        }
    }
}