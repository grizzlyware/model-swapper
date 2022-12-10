<?php

namespace Grizzlyware\ModelSwapper\Traits;

use Illuminate\Database\Eloquent\Model;

trait IsReplacementModel
{
    // TODO
    /*
     * This should force relationship methods to redirect to their parent
     */

    private Model $replacedModel;

    private function getReplacedModelInstance(): Model
    {
        if (! isset($this->replacedModel)) {
            $this->replacedModel = new (\get_parent_class($this));
        }

        return $this->replacedModel;
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
}
