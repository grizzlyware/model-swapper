<?php

namespace Grizzlyware\ModelSwapper\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait IsReplacementModel
{
    private Model $replacedModel;

    private function getReplacedModelInstance(): Model
    {
        if (! isset($this->replacedModel)) {
            $this->replacedModel = new (\get_parent_class($this));
        }

        return $this->replacedModel;
    }

    public static function getModelSwappingGlobalScopeName(): string
    {
        return 'swapModel';
    }

    public static function replacedModelQuery(): Builder
    {
        return (new static())
            ->getReplacedModelInstance()
            ->newQuery()
            ->withoutGlobalScope(
                static::getModelSwappingGlobalScopeName()
            )
        ;
    }

    public function getMorphClass(): string
    {
        $morphMap = Relation::morphMap();

        /**
         * Try to get the current classes morph
         */
        if (! empty($morphMap) && in_array(static::class, $morphMap)) {
            return array_search(static::class, $morphMap, true);
        }

        /**
         * Default back to the parents morph
         */
        return $this
            ->getReplacedModelInstance()
            ->getMorphClass()
        ;
    }

    public function joiningTableSegment(): string
    {
        return $this
            ->getReplacedModelInstance()
            ->joiningTableSegment()
        ;
    }

    public function getForeignKey(): string
    {
        return $this
            ->getReplacedModelInstance()
            ->getForeignKey()
        ;
    }

    public function getKeyName(): string
    {
        return $this
            ->getReplacedModelInstance()
            ->getKeyName()
        ;
    }

    public function getTable(): string
    {
        return $this
            ->getReplacedModelInstance()
            ->getTable()
        ;
    }

    public static function observe($class): void
    {
        $replacedModel = (new static())->getReplacedModelInstance();
        
        $replacedModel::observe($class);
    }

    protected function fireModelEvent($event, $halt = true)
    {
        // First, we will get the proper method to call on the event dispatcher, and then we
        // will attempt to fire a custom, object based event for the given event. If that
        // returns a result we can return that result, or we'll call the string events.
        $method = $halt ? 'until' : 'dispatch';

        $result = $this->filterModelEventResults(
            $this->fireCustomModelEvent($event, $method)
        );

        if ($result === false) {
            return false;
        }

        return ! empty($result) ? $result : static::$dispatcher->{$method}(
            "eloquent.{$event}: " . \get_parent_class($this), $this
        );
    }
}
