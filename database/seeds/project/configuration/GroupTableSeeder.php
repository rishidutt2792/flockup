<?php
/**
 * Created by PhpStorm.
 * User: atul
 * Date: 9/21/2016
 * Time: 10:56 PM
 */

namespace seeds\project\configuration;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Configuration\Group;

class GroupTableSeeder extends Seeder
{
    public function run()
    {
        $groups=[
            [
                "description"=>"Superuser",
                "access"=>"superuser"
            ],
            [
                "description"=>"Administrator",
                "access"=>"admin",
            ],
            [
                "description"=>"Normal",
                "access"=>"user",
            ]
        ];

        foreach ($groups as $group) {
            $groupObj=Group::create([
                "name"=>$group["access"],
                "description"=>$group["description"],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}