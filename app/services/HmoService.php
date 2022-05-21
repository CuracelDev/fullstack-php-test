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
       $dates = DB::table('orders')->select('batch_type')->where(['batch_type'=>$type,'hmo_id'=>$hmo_id])->get()->unique();

       $yearMonth = $dates->map(function($ele){
           return explode('-',$ele);
       });

       $group = [];

       $batch = $yearMonth->map(function($ele) use ($type,$hmo_id,&$group){
            $group[$ele] = DB::select("SELECT * FROM orders 
            WHERE YEAR($type) = $ele[0] 
            AND MONTH($type) = $ele[0] 
            AND hmo_id = $hmo_id");
            return $group;
       });

       return $group;

    }

}