<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
          ['name'=>'finishFlightTimeout','description'=>'ترشولد زمانی خاتمه اعلام کردن پرواز','value'=>30,'type'=>'integer'],
          ['name'=>'numberOfTaleLog','description'=>'نمایش تعداد لاگ های پرواز به عنوان دنباله','value'=>20,'type'=>'integer'],
        ];
        foreach ($records as $record){
            \App\Setting::create($record);
        }
    }
}
