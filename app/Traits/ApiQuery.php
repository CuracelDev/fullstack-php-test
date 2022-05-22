<?php


namespace App\Traits;


use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleType;


trait ApiQuery
{
//ensure that this query always return a collections

    protected function queryAll(Model $instance)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            $data = $instance::orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    /*
     * Note that for filter to work don't use filter all
     * in your model
     */
    protected function joinQueryAll(Model $instance, $joinTable, $tableOne, $tableTwo, $whereClause, $list = ["*"])
    {
        $data = [];
        $perPage = 5;
        $orderBy = $joinTable . ".created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            //>            join('annual_grades', 'employees.user_id', '=', 'annual_grades.user_id')
            $data = $instance::join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    protected function basicInsert(Model $instance, $data)
    {
        return $instance->create($data);
    }
    protected function basicInsertCheckUnique(Model $instance, array $controlFields,  $data)
    {
        return $instance->updateOrCreate($controlFields, $data);
    }

    protected function filterJoinQueryAll(Model $instance, $joinTable, $tableOne, $tableTwo, $whereClause, $list = ["*"])
    {
        $data = [];
        $perPage = 5;
        $orderBy = $joinTable . ".created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            //>            join('annual_grades', 'employees.user_id', '=', 'annual_grades.user_id')
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    protected function filterJoinQuerySearchAll(Model $instance, $joinTable, $tableOne, $tableTwo, $whereClause, $list = ["*"], $searchQuery, $fields)
    {
        $data = [];
        $perPage = 5;
        $orderBy = $joinTable . ".created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            //>            join('annual_grades', 'employees.user_id', '=', 'annual_grades.user_id')
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction);

            //$data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->join($joinTable, $tableOne, "=", $tableTwo)->select($list)->where($whereClause)->orderBy($orderBy, $direction);
        }
        $data = $data->where(function ($query) use ($fields, $searchQuery) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', "%" . $searchQuery . "%");
                $query->orWhere($field, 'REGEXP', $searchQuery);
            }
        })
        ->paginate($perPage);
        $data = collect($data);

        return $data;
    }

    protected function filterQueryAllNull(Model $instance, $nullValue)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->whereNull($nullValue)->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->whereNull($nullValue)->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    protected function filterQueryAll(Model $instance)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    protected function filterQueryAll2(Model $instance)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            $data = $instance::ignoreRequest(['per_page', 'department_id', 'sort_by', 'self', 'direction'])->filter()->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'department_id', 'sort_by', 'self', 'direction'])->filter()->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    protected function filterQueryAllWithWhere(Model $instance, $whereClause)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if (request()->get('page') == 'all' || request()->get('page') == '') {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()
                ->where($whereClause)->orderBy($orderBy, $direction)->get();

            $data = ['data' => $data];
        } else {
            $data = $instance::ignoreRequest(['per_page', 'sort_by', 'direction'])->filter()
                ->where($whereClause)->orderBy($orderBy, $direction)->paginate($perPage);
        }
        $data = collect($data);

        return $data;
    }

    public function getListByDoubleColumns($column1, $value1, $column2, $value2, $list, $object, $operator = "=", $take = 0)
    {
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";
        if (request()->has('per_page')) {
            $perPage = request()->get('per_page');
        }

        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }


        if ($take > 0) {
            return $object->select($list)
                ->where($column1, $value1)
                ->where($column2, $operator, $value2)
                ->take($take)->orderBy($orderBy, $direction)->get()->toArray();
        }


        return $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $operator, $value2)
            ->orderBy($orderBy, $direction)
            ->get()->toArray();

    }


    public function getAllList($list, $object)
    {

        $orderBy = "created_at";
        $direction = "desc";
        if (request()->has('sort_by')) {
            $orderBy = request()->get('sort_by');
        }

        if (request()->has('direction')) {
            $direction = request()->get('direction');
        }
        return $object->select($list)
            ->orderBy($orderBy, $direction)
            ->get();


    }

    protected function searchQuery(Model $instance, array $fields, $searchQuery)
    {
        $data = [];
        $perPage = 5;
        $orderBy = "created_at";
        $direction = "desc";

        $data = $instance->where('created_at', '!=', NULL)->where(function ($query) use ($fields, $searchQuery) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', "%" . $searchQuery . "%");
                $query->orWhere($field, 'REGEXP', $searchQuery);
            }
        })
            ->get();

        // ->orderBy($orderBy, $direction)->paginate($perPage);
        $data = collect($data);

        return $data;


    }

    public function getSingleQueryByColumn($column, $value, $list, $object, $operator = "=")
    {

        $data = $object->select($list)
            // ->where('deleted_at', null)
            ->where($column, $operator, $value)
            ->get()->toArray();
        if (!empty($data[0])) {
            return $data[0];
        }

        return [];

    }

    public function softDelete($instance,  $value,  $column  = 'deleted_at')
    {
       return $instance->where($column, $value)->update(['deleted_at' => now()]);
    }

    public function getSingleQueryByDualColumns($column1, $value1, $column2, $value2, $list, $object, $operator = "=")
    {


        $data = $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $operator, $value2)
            ->get()->toArray();
        if (!empty($data[0])) {
            return $data[0];
        }

        return [];

    }

    public function getListByColumn($column, $value, $list = "*", $object, $operator = "=", $orderBy = "id", $direction = "asc")
    {

        return $object->select($list)
            ->where($column, $operator, $value)
            ->orderBy($orderBy, $direction)
            ->get()->toArray();
    }

    public function countBySingleColumn($object, $column, $value, $countBy = "id", $operator = "=")
    {
        return $object->where($column, $operator, $value)->count($countBy);
    }

    public function countByDoubleColumn($object, $column1, $value1, $column2, $value2, $countBy = "id", $operator = "=")
    {
        return $object->where($column1, $operator, $value1)
            ->where($column2, $value2)
            ->count($countBy);
    }

    public function sumByDoubleColumn($object, $column1, $value1, $column2, $value2, $sumBy)
    {
        return $object->where($column1, $value1)
            ->where($column2, $value2)
            ->sum($sumBy);
    }

    public function getListByDoubleColumn($column1, $value1, $column2, $value2, $list, $object, $operator = "=", $take = 0, $orderBy = 'id', $direction = 'asc')
    {
        if ($take > 0) {
            return $object->select($list)
                ->where($column1, $value1)
                ->where($column2, $operator, $value2)
                ->take($take)->get()->toArray();
        }


        return $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $operator, $value2)
            ->orderBy($orderBy, $direction)
            ->get()->toArray();

    }


    public function updateSingleColumn($object, $column, $value, $updateColumn, $byValue)
    {

        $object->where($column, $value)->update([
            $updateColumn => $byValue,
        ]);
    }

    public function updateDoubleColumn($object, $column, $value, $updateColumn1, $byValue1, $updateColumn2, $byValue2)
    {

        $save = $object->where($column, $value)->update([
            $updateColumn1 => $byValue1,
            $updateColumn2 => $byValue2,
        ]);

        return $save;
    }

    public function updateDoubleDualColumns($object, $column1, $value1, $column2, $value2, $updateColumn1, $byValue1, $updateColumn2, $byValue2)
    {

        $object->where($column1, $value1)
            ->where($column2, $value2)
            ->update([
                $updateColumn1 => $byValue1,
                $updateColumn2 => $byValue2,
            ]);
    }

    public function updateSingleDualColumn($object, $column1, $value1, $column2, $value2, $updateColumn, $byValue)
    {

        $object->where($column1, $value1)
            ->where($column2, $value2)
            ->update([
                $updateColumn => $byValue,
            ]);
    }

    public function updateDoubleTriColumns($object, $column1, $value1, $column2, $value2, $column3, $value3, $updateColumn1, $byValue1, $updateColumn2, $byValue2, $operator = '=')
    {

        $status = $object->where($column1, $value1)
            ->where($column2, $value2)
            ->where($column3, $operator, $value3)
            ->update([
                $updateColumn1 => $byValue1,
                $updateColumn2 => $byValue2,
            ]);
        return $status;
    }

    public function updateDoubleFourColumns($object, $column1, $value1, $column2, $value2, $column3, $value3, $updateColumn1, $byValue1, $updateColumn2, $byValue2, $updateColumn3, $byValue3, $operator = '=')
    {

        $status = $object->where($column1, $value1)
            ->where($column2, $value2)
            ->where($column3, $operator, $value3)
            ->update([
                $updateColumn1 => $byValue1,
                $updateColumn2 => $byValue2,
                $updateColumn3 => $byValue3,
            ]);
        return $status;
    }


    public function getListByTriColumnPaginate($column1, $value1, $column2, $value2, $column3, $value3, $list, $object, $operator = "=")
    {

        return $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $value2)
            ->where($column3, $operator, $value3)
            ->latest()
            ->paginate(40);

    }

    public function getListByTriColumn($column1, $value1, $column2, $value2, $column3, $value3, $list, $object, $oderBy, $direction, $operator = "=")
    {

        return $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $value2)
            ->where($column3, $operator, $value3)
            ->orderBy($oderBy, $direction)->get()->toArray();


    }

    public function getListByColumnPaginate($column, $value, $list = "*", $object, $operator = "=", $orderBy = "id", $direction = "asc")
    {


        return $object->select($list)
            ->where($column, $operator, $value)
            ->orderBy($orderBy, $direction)
            ->paginate(40);
    }

    public function getBasicListPaginate($object, $list = "*", $orderBy = "id", $direction = "asc")
    {

        return $object->select($list)
            ->whereNull('deleted_at')
            ->orderBy($orderBy, $direction)
            ->paginate(40);
    }

    public function getListByDoubleColumnPaginate($column1, $value1, $column2, $value2, $list, $object, $operator = "=")
    {

        return $object->select($list)
            ->where($column1, $value1)
            ->where($column2, $operator, $value2)
            ->latest()
            ->paginate(40);

    }


    public function getReference() 
    {
        return Str::random(18);
    }

}
