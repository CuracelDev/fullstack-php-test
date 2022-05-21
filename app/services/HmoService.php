<?php
namespace app\Services;

use App\Models\Hmo;
use Illuminate\Support\Facades\DB;

class HmoService{

    public function create(Array $data)
    {
       return Hmo::create($data);
    }

    public function all()
    {
        return Hmo::all();
    }

    public function get($id)
    {
        return Hmo::find($id);
    }

    public function batch($type,$hmo_id)
    {
       $dates = DB::table('orders')->select($type)->where(['hmo_id'=>$hmo_id])->get()->unique();

       $yearMonth = $dates->map(function($ele) use ($type){
           $arr = explode('-',$ele->$type);
           return [$arr[0],$arr[1]];
       });

       $group = [];

       $batch = $yearMonth->map(function($ele) use ($type,$hmo_id,&$group){
            $group["$ele[0]-$ele[1]"] = 
                DB::select("SELECT items,total,encounter_date,created_at as sent_date FROM orders 
                WHERE YEAR($type) = '$ele[0]'
                AND MONTH($type) = '$ele[1]'
                AND hmo_id = $hmo_id")
             ;
            return $group;
       });

       info(['batches'=>$group]);

       if(env('testing')){

       }

       return $group;

    }

}