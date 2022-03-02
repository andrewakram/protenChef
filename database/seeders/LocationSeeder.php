<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = User::all();
        foreach ($users as $user) {
            $data['user_id'] = $user->id;
            $data['lat'] = '30.5764207';
            $data['lng'] = '31.5052933';
            $data['type'] = 'main';
            $data['title'] = 'المنزل';
            $data['body'] = 'هاشم الأشقر النزهة الجديدة القاهرة - مصر';
            $data['bulding_num'] = '15';
            $data['flat_num'] = '4';
            $data['notes'] = 'notes notes notes notes';
            Location::updateOrCreate($data);
            $data['user_id'] = $user->id;
            $data['lat'] = '30.5764207';
            $data['lng'] = '31.5052933';
            $data['type'] = 'main';
            $data['title'] = 'منزل الغشام';
            $data['body'] = 'هاشم الأشقر النزهة الجديدة - الغشام - الشرقية - مصر';
            $data['bulding_num'] = '1';
            $data['flat_num'] = '1';
            $data['notes'] = 'notes notes notes notes';
            Location::updateOrCreate($data);
            $data['user_id'] = $user->id;
            $data['lat'] = '30.5764207';
            $data['lng'] = '31.5052933';
            $data['type'] = 'main';
            $data['title'] = 'منزل القومية';
            $data['body'] = 'هاشم الأشقر النزهة الجديدة الزقازيق - مصر';
            $data['bulding_num'] = '25';
            $data['flat_num'] = '2';
            $data['notes'] = 'notes notes notes notes';
            Location::updateOrCreate($data);
        }
    }
}
