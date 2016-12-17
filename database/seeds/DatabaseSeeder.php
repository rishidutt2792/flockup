<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exclude = [
            //Add Tables Names Which Needs To Be excluded During seeding
        ];

        $tables = [];

        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        foreach (DB::select('SHOW TABLES') as $k => $v) {
            $tables[] = array_values((array)$v)[0];
        }
        foreach($tables as $table) {
            if (!in_array($table, $exclude)) {
                DB::table($table)->truncate();
            }
        }
        DB::statement( 'SET FOREIGN_KEY_CHECKS=1' );

        $this->call('seeds\project\configuration\OAuthSecuritySeeder');
        $this->call('seeds\project\configuration\GroupTableSeeder');
        $this->call('seeds\project\configuration\UserTableSeeder');

    }
}
