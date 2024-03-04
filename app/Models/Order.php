<?php

namespace App\Models;

use App\Scopes\CurrentUserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'items' => 'collection',
        'encounter_date' => 'datetime'
    ];

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hmo that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hmo(): BelongsTo
    {
        return $this->belongsTo(Hmo::class);
    }

    /**
     * Filter the query by the given filter parameters
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $filter
     * @return void
     */
    public function scopeFilterBy(Builder $builder, array $filter)
    {
        $filterBy = $filter['filter_by'];
        $dateField = $filterBy === 'created_at' ? 'submission' : 'encounter';

        $builder->select($this->formattedSelectFields($filterBy, $dateField))
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->orderBy("{$dateField}_month")
            ->orderBy("{$dateField}_year")
            ->whereYear("orders.$filterBy", $filter['year'])
            ->whereMonth("orders.$filterBy", date('m', strtotime($filter['month'])));
    }

    /**
     * Format the select fields for the query
     *
     * @param string $filterBy
     * @param string $dateField
     * @return array
     */
    private function formattedSelectFields(string $filterBy, string $dateField): array
    {
        return [
            DB::raw("CONCAT(users.name, ' ', MONTHNAME(orders.$filterBy), ' ', YEAR(orders.$filterBy)) as user_month_year"),
            'orders.*',
            'users.name as user_name',
            DB::raw("MONTH(orders.$filterBy) as {$dateField}_month"),
            DB::raw("YEAR(orders.$filterBy) as {$dateField}_year")
        ];
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CurrentUserScope);
    }
}
