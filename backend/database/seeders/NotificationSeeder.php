<?php


namespace Database\Seeders;


use App\Models\User;
use App\Modules\Notification\Notifications\CustomerNotification;
use Faker\Generator;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    function run(Generator $faker)
    {
        foreach (User::all() as $user)
            for($i = 0;$i < 5;$i++)
                $user->notifyNow(new CustomerNotification(
                    $faker->text(30),
                    $faker->realText()
                ));
    }
}
