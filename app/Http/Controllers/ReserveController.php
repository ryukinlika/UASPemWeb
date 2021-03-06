<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($screeningid)
    {
        $audi = DB::table('screening')->where('id', $screeningid)->value('auditorium_id');
        $seats_d = DB::table('seat')->where('auditorium_id', $audi)->get();
        $seats = [];
        foreach ($seats_d as $seat) {
            $result = [
                'id' => $seat->id,
                'row' => $seat->row,
                'available' => true
            ];
            array_push($seats, $result);
        }
        // var_dump($seats);
        $reserved_seat_id = DB::table('reservation')->where('screening_id',$screeningid)->get('seat_id');
        for ($i = 0; $i < count($seats); $i++) {
            for ($j = 0; $j < count($reserved_seat_id); $j++)
                if ($seats[$i]["id"] == $reserved_seat_id[$j]->seat_id)
                    $seats[$i]["available"] = false;
        }
        return view('reserve.index', ['seats' => $seats, 'screeningid' => $screeningid]);
    }
    public function store(Request $req)
    {
        $uid = Auth::id();
        $screening_id = $req->data['screeningid'];
        $data = $req->data['seat'];
        foreach ($data as $d) {
            DB::table('reservation')->insert(['screening_id' => $screening_id, 'seat_id' => $d, 'user_id' => $uid]);
        }
//        DB::table('reservation')->insert(['screening_id' => $screening_id, 'seat_id' => $data, 'user_id' => $uid]);
        return response(null, Response::HTTP_OK);
    }
    public function success($screening_id, $seatString)
    {
        $seatString = str_replace('+', ', ', $seatString);
        $username = Auth::user()->name;
        $screeningData = DB::table('screening')
                    ->join('auditorium', 'auditorium.id', '=', 'screening.auditorium_id')
                    ->join('movie', 'movie.id', '=', 'screening.movie_id')
                    ->select('auditorium.name',  'movie.title', 'movie.age', 'movie.time', 'movie.posterpath')->where('screening.id', $screening_id)
                    ->get();
        return view('reserve.success', ['screeningid'=>$screening_id, 'seats' => $seatString, 'name' => $username, 'data' => $screeningData[0]]);
    }
}
