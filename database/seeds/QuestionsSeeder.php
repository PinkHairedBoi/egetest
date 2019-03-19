<?php

use App\Test;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Test::all() as $test) {
            DB::table('questions')->insert([
                'test_id' => $test->id,
                'question' => 'Рассмотрите таблицу «Форма изменчивости» и заполните пустую ячейку, вписав соответствующий термин.<br /><table style="margin:auto" class="tablein"><tbody><tr><th style="text-align:center">Форма изменчивости</th><th style="text-align:center">Пример изменчивости</th></tr><tr><td style="text-align:left">комбинативная</td><td style="text-align:left">В результате случайной комбинации негомологичных хромосом в мейозе у потомков формируется новый фенотип</td></tr><tr><td style="text-align:left"></td><td style="text-align:left">рождение ребенка с синдромом Дауна</td></tr></tbody></table>',
                'answer' => 'верный',
            ]);
            DB::table('questions')->insert([
                'test_id' => $test->id,
                'question' => 'Второй вопрос теста ' . $test->name,
                'answer' => 'верный',
            ]);
            DB::table('questions')->insert([
                'test_id' => $test->id,
                'question' => 'Третий вопрос теста ' . $test->name,
                'answer' => 'верный',
            ]);
        }
    }
}
