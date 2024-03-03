<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CurrentUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        if (auth()->check()) {
            $user = auth()->user();

            $builder->when($user->isHmo(), function ($query) use ($user) {
                $query->whereHas('hmo', function ($sub) {
                    $sub->whereUserId(auth()->id());
                });
            });

            $builder->when($user->isProvider(), function ($query) {
                $query->whereUserId(auth()->id());
            });
        }
    }
}
