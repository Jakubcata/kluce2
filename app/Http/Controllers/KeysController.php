<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use App\Key;
use App\History;
use Carbon\Carbon;

class KeysController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function getKeys(Request $request)
    {
        $keys = Key::all();
        return response()->json($keys->map(function ($key) {
            $key['owner'] = $key->owner;
            return $key;
        }));
    }

    public function getOwners(Request $request)
    {
        $owners = Owner::all();
        return response()->json($owners);
    }

    public function newOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|max:255',
            'facebook' => 'required|max:255',
        ]);

        Owner::create($request->all());
        return response()->json(["status"=>"ok"]);
    }

    public function changeKey(Request $request)
    {
        $key = Key::find($request->id);
        $oldOwner = $key->owner;
        $newOwner = Owner::find($request->bookedBy);

        $history = new History([
            "reason"=>$key->reason,
            "needed_date"=>$key->booked_until,
            "start_time"=>is_null($key->updated_at) ? Carbon::now() : $key->updated_at,
            "end_time"=>Carbon::now(),
        ]);
        $history->owner()->associate($oldOwner);
        $history->key()->associate($key);
        $history->save();

        $key->owner()->associate($newOwner);
        $key->reason = $request->reason;
        $key->booked_until = $request->booked_until;
        $key->save();
    }
}
