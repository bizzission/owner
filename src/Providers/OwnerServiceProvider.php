<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Models\Ownable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Railken\EloquentMapper\Contracts\Map as MapContract;

class OwnerServiceProvider extends CommonServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable(Config::get('amethyst.owner.data.ownable.table'))) {
            Event::listen(['eloquent.created: *', 'eloquent.deleted: *'], function ($event_name, $events) {
                $model = $events[0];
                $class = get_class($model);

                if ($class === Ownable::class || in_array($class, config('amethyst.owner.listener.unlist'))) {
                    return;
                }

                $owner = \Auth::user();

                if (!$owner || !$model->id || !$owner->id) {
                    return;
                }

                [$eventType, $class] = explode(': ', $event_name);

                $map = $this->app->make(MapContract::class);

                $parameters = [
                    'owner_type'   => $map->modelToKey($owner),
                    'owner_id'     => $owner->id,
                    'relation'     => 'author',
                    'ownable_type' => $map->modelToKey($model),
                    'ownable_id'   => $model->id,
                ];

                $eventType === 'eloquent.created' ? Ownable::create($parameters) : Ownable::where($parameters)->delete();
            });
        }
    }
}
