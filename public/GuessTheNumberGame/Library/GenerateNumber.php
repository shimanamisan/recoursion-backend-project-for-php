<?php

namespace GuessTheNumberGame\Library;

/**
 * 乱数を生成して、ユーザーに答えを当てさせるクラス
 */
class GenerateNumber
{
    /** @var int 最小値 */
    private $min;

    /** @var int 最大値 */
    private $max;

    /** @var int 正解の値 */
    private $ans;

    /** @var int トライできる回数の制限 */
    private $input_limit;

    /**
     * ユーザーに最小値を入力させる
     */
    private function fetchMinInput(): void
    {
        while (true) {

            echo "最小値を入力してください: ";
            // STDIN: 事前に定義されたファイルハンドル
            // スクリプト終了時に自動的に閉じられるので、明示的に fclose を呼び出して閉じる必要が無い
            // 全角数字だった場合も半角数字に変換する
            $input_min = mb_convert_kana(fgets(STDIN), 'n', 'UTF-8');

            if(is_numeric($input_min)) {
                $this->min = (int)$input_min;
                break;
            } else {
                echo "※数字を入力して下さい！ \n";
            }
        }
    }

    /**
     * ユーザーに最大値を入力させる
     */
    private function fetchMaxInput(): void
    {
        while(true) {

            echo "入力した最小値より大きい数値を最大値に設定して下さい: ";
            $input_max = mb_convert_kana(fgets(STDIN), 'n', 'UTF-8');

            if(is_numeric($input_max)) {
                $this->max = (int)$input_max;

                if($this->min < $this->max) {

                    // 入力された値から乱数を生成
                    $this->ans = $this->generateRandomNumber();

                    break;
                }

            } else {
                echo "※数字を入力して下さい！ \n";
            }

        }
    }

    /**
     * 最小値と最大値を元に乱数を生成する
     *
     * @return int 生成された乱数
     */
    private function generateRandomNumber(): int
    {
        return mt_rand($this->min, $this->max);
    }

    /**
     * ユーザーがトライできる回数を制限する
     */
    private function limitInputAttempts()
    {
        // トライできる回数を1～10回で制限する
        $this->input_limit = mt_rand(1, 10);

        echo "あなたがトライできる回数は {$this->input_limit} 回です \n";
    }

    /**
     * ユーザーが正解するか制限回数に達するまで繰り返す
     */
    private function retryUntilSuccess(): void
    {
        while($this->input_limit > 0) {
            echo "正解の数字を当てて下さい！: ";
            $input_ans = mb_convert_kana(fgets(STDIN), 'n', 'UTF-8');

            if(is_numeric($input_ans)) {

                $input_ans = (int)$input_ans;

                if($this->ans === $input_ans) {
                    echo "おめでとうございます！正解です！\n";
                    exit;
                }

                if($this->ans > $input_ans) {
                    echo "答えは{$input_ans}より大きい値です！\n";

                    $this->input_limit--;

                } else {
                    echo "答えは{$input_ans}より小さい値です！\n";

                    $this->input_limit--;
                }

            } else {
                echo "※数字を入力して下さい！ \n";
            }
        }

        echo "上限回数に到達しました。またチャレンジしてください！ 答え: {$this->ans}\n";
    }

    /**
    * ゲームの初期設定を行う
    */
    public function initialize(): void
    {
        $this->fetchMinInput();

        $this->fetchMaxInput();

        $this->limitInputAttempts();

        $this->retryUntilSuccess();
    }
}
