<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->delete();
        DB::table('teams')->delete();
        DB::table('users')->where('role', 3)->delete();
        $h = 1;
        $makeBlock = 11;
        $i = 0;
        $cnt = 4*16;
        // 64
        while ($h < $makeBlock) {
            while ($i < $cnt) {
                $num = $i + 1;

                $memberName = 'メンバー('.$h.'/'.$num.')';
                $param = [
                    ['name' => $memberName.'_1', 'created_at' => now()],
                    ['name' => $memberName.'_2', 'created_at' => now()],
                    ['name' => $memberName.'_3', 'created_at' => now()],
                    ['name' => $memberName.'_4', 'created_at' => now()],
                ];
                DB::table('users')->insert($param);

                $event = DB::table('events')->first();
                $teamName = 'チーム'.$h.'/'.$num;

                DB::table('teams')->insert([
                    [
                      'event_id' => $event->id,
                      'name'=> $teamName,
                      'friend_code' => '111122223333',
                      'approval' => 1,
                      'created_at' => now(),
                    ],
                ]);

                $team = DB::table('teams')->where('name', $teamName)->first();
                $users = DB::table('users')->where('name', 'LIKE', $memberName.'%')->get();
                foreach ($users as $key => $value) {
                    DB::table('members')->insert([
                        [
                            'team_id' => $team->id,
                            'user_id' => $value->id,
                            'name' => $value->name,
                            'xp' => 2000,
                            'created_at' => now(),
                        ],
                    ]);
                    if ($key == 0) {
                        $member = DB::table('members')->where('user_id', $value->id)->first();
                        DB::table('teams')->where('id', $team->id)->update(['member_id' => $member->id]);
                    }
                }

                $i++;
            }
            $h++;
        }
    }
}