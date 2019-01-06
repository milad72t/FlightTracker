<?php

use Illuminate\Database\Seeder;

class FormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = [
          ['name' => 'addFlight' , 'url'=>'setNewFlight' , 'description'=>'اضافه کردن پرواز'],
          ['name' => 'searchFlight' , 'url'=>'searchFlight' , 'description'=>'جستجوی پرواز'],
          ['name' => 'showAirports' , 'url'=>'airports/show' , 'description'=>'مشاهده فرودگاه ها'],
          ['name' => 'addAirports' , 'url'=>'airports/add' , 'description'=>'اضافه کردن فرودگاه'],
          ['name' => 'showAirlines' , 'url'=>'airlines/show' , 'description'=>'مشاهده ایرلاین ها'],
          ['name' => 'addAirlines' , 'url'=>'airlines/add' , 'description'=>'اضافه کردن ایرلاین'],
          ['name' => 'showUsers' , 'url'=>'users/show' , 'description'=>'مشاهده کاربران'],
          ['name' => 'addUser' , 'url'=>'users/create' , 'description'=>'اضافه کردن کاربر'],
          ['name' => 'loginLogs' , 'url'=>'loginLogs/show' , 'description'=>'مشاهده مراجعات'],
          ['name' => 'settings' , 'url'=>'/settings/show' , 'description'=>'تنظیمات'],
        ];
        foreach ($forms as $form)
            \App\Form::create($form);
    }
}
