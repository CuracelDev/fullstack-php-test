<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CurrentUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        if (auth()->check()) {

            $builder->when(user()->isHmo(), function ($query) {
                $query->whereHas('hmo', function ($sub) {
                    $sub->whereUserId(auth()->id());
                });
            });

            $builder->when(user()->isProvider(), function ($query) {
                $query->whereUserId(auth()->id());
            });
        }
    }
}
