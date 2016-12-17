<?php
/**
 * Created by PhpStorm.
 * User: atul
 * Date: 9/21/2016
 * Time: 11:00 PM
 */

namespace seeds\project\configuration;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Configuration\Group;
use App\Models\Person\Person;
use App\Models\Person\PersonData;
use App\Models\Person\Address\Address;
use App\Models\Person\Address\AddressData;
use App\Models\Person\Email\Email;
use App\Models\Person\Phone\Phone;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $users=[
            [
                "name"=>"Super User",
                "email"=>"superuser@demo.com",
                "scope"=>"superuser"
            ],
            [
                "name"=>"Admin User",
                "email"=>"admin@demo.com",
                "scope"=>"admin"
            ],
            [
                "name"=>"Normal User",
                "email"=>"user@demo.com",
                "scope"=>"user"
            ],
        ];

        $faker = Faker::create();

        foreach ($users as $userObj) {
            $user=User::create([
                "name"=>$userObj["name"],
                "email"=>$userObj["email"],
                "password"=>bcrypt("password"),
                "activation_code"=>$faker->bothify('??????????'),
                "is_active"=>1,
                "resent"=>0,
                "signup_ip_address"=>$faker->ipv4,
                "signup_confirmation_ip_address"=>$faker->ipv4,
                "signup_sm_ip_address"=>$faker->ipv4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Assign User To Group

            $group=Group::where('name',''.$userObj["scope"])->get();

            \DB::table('users_groups')->insert([
                'user_id' => $user->id,
                'group_id' => $group[0]->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Storing User Personal Details Record

            $person=Person::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $personData=new PersonData();

            $index=$faker->randomNumber(1);
            $gender = ($index%2==0?'male':'female');

            $personData->first_name=$faker->firstName($gender);
            $personData->middle_name="";
            $personData->last_name=$faker->lastName;
            $personData->title=$faker->title($gender);
            $personData->suffix=$faker->suffix;
            $personData->birth_date=Carbon::now();
            $personData->gender=$gender;
            $personData->nick_name=$faker->firstName($gender);
            $personData->created_at= Carbon::now();
            $personData->updated_at= Carbon::now();

            $person->data()->save($personData);
            $user->people()->save($person);

            // Storing User Address Details Record

            $contactPersonAddress=Address::create([
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $contactPersonAddressData=new AddressData();
            $contactPersonAddressData->street=$faker->streetAddress;
            $contactPersonAddressData->country=$faker->country;
            $contactPersonAddressData->state=$faker->state;
            $contactPersonAddressData->city=$faker->city;
            $contactPersonAddressData->postal_code=$faker->postcode;
            $contactPersonAddressData->created_at= Carbon::now();
            $contactPersonAddressData->updated_at= Carbon::now();

            $contactPersonAddress->data()->save($contactPersonAddressData);
            $person->address()->save($contactPersonAddress);

            // Storing User Personal Phone Details
            $phonePersonalPhone=Phone::create([
                "number"=>$faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $person->phones()->attach($phonePersonalPhone->id,['category' => 'personal']);

            // Storing User Person Email Record
            $email=Email::create([
                "email"=>$user->email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $person->emails()->attach($email->id);
        }
    }
}