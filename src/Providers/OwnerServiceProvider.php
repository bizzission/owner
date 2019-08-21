<?php

namespace Amethyst\Providers;

use Amethyst\Common\CommonServiceProvider;
use Amethyst\Models\Ownable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        if (Schema::hasTable(Config::get('amethyst.owner.data.ownable.table'))) {
            Event::listen(['eloquent.created: *'], function ($event_name, $events) {
                

                $class = explode(": ", $event_name)[1];

                if ($class === Ownable::class) {
                    return;
                }

                $model = $events[0];

                $owner = null;
                
                try {
                    $manager = app('amethyst')->newManagerByModel($class);
                    $owner = $manager->getHistory($model->id);
                } catch (\Exception $e) {

                }

                if (!$owner) {
                    return;
                }

                Ownable::create([
                    'owner_type'   => app('amethyst')->tableize($owner),
                    'owner_id'     => $owner->id,
                    'relation'     => 'author',
                    'ownable_type' => app('amethyst')->tableize($model),
                    'ownable_id'   => $model->id,
                ]);
            });
        }
    }
}
