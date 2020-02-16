<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Models\Ownable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;

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

                if ($class === Ownable::class) {
                    return;
                }

                $owner = \Auth::user();

                if (!$owner) {
                    return;
                }

                [$eventType, $class] = explode(': ', $event_name);

                $parameters = [
                    'owner_type'   => app('amethyst')->tableize($owner),
                    'owner_id'     => $owner->id,
                    'relation'     => 'author',
                    'ownable_type' => app('amethyst')->tableize($model),
                    'ownable_id'   => $model->id,
                ];

                $eventType === 'eloquent.created' ? Ownable::create($parameters) : Ownable::where($parameters)->delete();
            });
        }
    }
}
