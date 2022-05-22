<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    protected function successResponse($data, $code, $message = '')
    {

        return response()->json(['data' => $data, 'success' => true, 'message' => $message, 'error' => false], $code);

    }

    protected function errorResponse($message, $code, $success = false)
    {
        return response()->json(['errors' => $message, 'code' => $code, 'success' => $success, 'error' => !$success], $code);
    }

    protected function showAll($data, $code = 200, $message = '')
    {

        if (empty($data)) {
            return $this->successResponse([[]], $code, $message);
        }


        return $this->successResponse($data, $code, $message);
    }


    protected function showOne(Model $instance, $code = 200,$message="")
    {
        return $this->successResponse($instance, $code,$message);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code, $message);
    }

    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $query;

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;

            $collection = $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;

    }


    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }

}
