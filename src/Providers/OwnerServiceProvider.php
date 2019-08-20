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
                $owner = Auth::user();

                if (!$owner) {
                    return;
                }

                $model = $events[0];

                $loggable = Collection::make(Config::get('amethyst.owner.listener.models'))->filter(function ($class) use ($model) {
                    return is_object($model) && get_class($model) === $class || $model instanceof $class;
                })->count();

                if ($loggable === 0) {
                    return;
                }

                /** @var \StdClass */
                $owner = Auth::user();

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
