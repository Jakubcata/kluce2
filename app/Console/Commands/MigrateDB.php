<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Group;
use App\Owner;
use App\Key;
use Illuminate\Support\Facades\DB;

class MigrateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrateDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old tables to the new one';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jakubcataGroup = new Group([
            "name"=>"jakubcata",
        ]);
        $jakubcataGroup->save();

        $users = DB::select("select id, name, surname, phone, facebook from potential_key_holders");
        foreach($users as $user){
          $fullName = explode(" ",$user->name);
          $newUser = new Owner(["id"=>$user->id, "name"=>$user->name, "surname"=>$user->surname, "phone"=>$user->phone, "facebook"=>$user->facebook]);
          $newUser->group()->associate($jakubcataGroup);
          $newUser->save();

        }

        $keys = DB::select("select id, name, booked_until, booked_by, reason, color from keys_in_circulation");
        foreach($keys as $key){
          $newKey = new Key(["name"=>$key->name, "color"=>$key->color, "reason"=>$key->reason, "booked_until"=>$key->booked_until]);
          $user = Owner::find($key->booked_by);
          $newKey->owner()->associate($user);
          $newKey->save();
        }


    }
}
