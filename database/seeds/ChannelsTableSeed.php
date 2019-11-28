<?php

use Illuminate\Database\Seeder;
use App\Channel;

class ChannelsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $channel1 = ['title' => 'Laravel', 'slug' => str_slug('Laravel')];

        $channel2 = ['title' => 'Symfony', 'slug' => str_slug('Symfony')];

        $channel3 = ['title' => 'Yii', 'slug' => str_slug('Yii')];

        $channel4 = ['title' => 'Vue', 'slug' => str_slug('Vue')];

        $channel5 = ['title' => 'React', 'slug' => str_slug('React')];

        $channel6 = ['title' => 'Angular', 'slug' => str_slug('Angular')];

        $channel7 = ['title' => 'Testing', 'slug' => str_slug('Testing')];

        $channel8 = ['title' => 'Love', 'slug' => str_slug('Love')];


        Channel::create($channel1);

        Channel::create($channel2);

        Channel::create($channel3);

        Channel::create($channel4);

        Channel::create($channel5);

        Channel::create($channel6);

        Channel::create($channel7);

        Channel::create($channel8);

    }
}
