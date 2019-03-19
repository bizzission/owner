<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Models\Ownable;

class OwnerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.owner.data.ownable.table'))) {
            Event::listen(['eloquent.created: *'], function ($event_name, $events) {
                if (!Auth::user()) {
                    return;
                }

                $model = $events[0];

                $loggable = Collection::make(Config::get('amethyst.owner.listener.models'))->filter(function ($class) use ($model) {
                    return is_object($model) && get_class($model) === $class || $model instanceof $class;
                })->count();

                if ($loggable === 0) {
                    return;
                }

                Ownable::create([
                    'owner_type'   => get_class(Auth::user()),
                    'owner_id'     => Auth::id(),
                    'relation'     => 'author',
                    'ownable_type' => get_class($model),
                    'ownable_id'   => $model->id,
                ]);
            });
        }
    }
}
