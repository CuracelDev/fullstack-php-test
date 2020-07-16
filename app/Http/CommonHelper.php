<?php

namespace App\Http;
use Illuminate\Http\Request;
use DateTime;

trait CommonHelper
{
    public static function success($data) {
        return response()->json(['data' => $data], 200);
    }

    public static function error($data) {
        return response()->json(['data' => $data], 500);
    }

    public static function unauthorized($data) {
        return response()->json(['data' => $data], 401);
    }

    public static function created($data) {
        return response()->json(['data' => $data], 201);
    }

    public static function warning($message) {
        return response()->json(['warning' => $message], 403);
    }

    public static function notFound($message) {
        return response()->json(['error' => $message], 404);
    }

    public static function notCreated($data) {
        return response()->json(['warning' => $data], 422);
    }

    public static function decodeToken($token) {
        return json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));
    }

    public static function getUserIdFromToken(Request $request) {
        $token = $request->header('x-access-token');
        $user_id = self::decodeToken($token)->sub;
        return $user_id;
    }

    public static function getResourceDetails($data) {
        $details = json_encode($data);
        $resource = json_decode($details);
        return $resource;
    }

    public static function getRuntimeStats($endTime, $startTime, $memory_usage) {
        $runtime = $endTime - $startTime;
        return [
            'runtime' => $runtime." seconds",
            'memory-used' => round($memory_usage/1024)." bytes"
        ];
    }
    
    public static function createdOn($date) {
        $encoded_date = json_encode($date);
        $created_on = json_decode($encoded_date)->date;
        return $created_on;
    }

    public static function time_elapsed($datetime, $full = false) {
        $now = new \DateTime();
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function generateRandomChars($length) {
        $allowed_chars = "ABC0DEF1GHIJtwK2LMNOPQ3RSTU4VWXuvY5Zabc6def7ghijk8lmnop9qrsxyz";
        $length_chars = strlen($allowed_chars)-1;
        $shuffle_chars = str_shuffle($allowed_chars);
        $random_number = "";
        
        for($i = 0; $i < $length; $i++)
        {
            $random_int = mt_rand(0,$length);
            $random_number.= $shuffle_chars[$random_int % $length_chars];
        }
        return $random_number;
    }

}
