<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Models\Ownable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return;
        }

        app('amethyst')->getData()->map(function ($data, $key) {
            if ($key !== 'ownable') {
                app('amethyst')->pushMorphRelation('ownable', 'ownable', $key);
            }
        });

        if (Schema::hasTable(Config::get('amethyst.owner.data.ownable.table'))) {
            Event::listen(['eloquent.created: *', 'eloquent.deleted: *'], function ($event_name, $events) {
                $model = $events[0];
                $class = get_class($model);

                if ($class === Ownable::class) {
                    return;
                }

                $owner = null;

                try {
                    $manager = app('amethyst')->newManagerByModel($class);

                    $owner = $manager->getHistory();
                } catch (\Exception $e) {
                }

                if (!$owner || $owner instanceof \Railken\Lem\Agents\SystemAgent) {
                    return;
                }

                [$eventType, $class] = explode(": ", $event_name);


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
