<?php

/**
 * Created by Cristian.
 * Date: 11/09/16 09:26 PM.
 */

namespace shishao\laramodel\Model\Relations;

use shishao\laramodel\Support\Dumper;
use Illuminate\Support\Fluent;
use shishao\laramodel\Model\Model;
use shishao\laramodel\Model\Relation;

abstract class HasOneOrMany implements Relation
{
    /**
     * @var \Illuminate\Support\Fluent
     */
    protected $command;

    /**
     * @var \shishao\laramodel\Model\Model
     */
    protected $parent;

    /**
     * @var \shishao\laramodel\Model\Model
     */
    protected $related;

    /**
     * HasManyWriter constructor.
     *
     * @param \Illuminate\Support\Fluent $command
     * @param \shishao\laramodel\Model\Model $parent
     * @param \shishao\laramodel\Model\Model $related
     */
    public function __construct(Fluent $command, Model $parent, Model $related)
    {
        $this->command = $command;
        $this->parent = $parent;
        $this->related = $related;
    }

    /**
     * @return string
     */
    abstract public function hint();

    /**
     * @return string
     */
    abstract public function name();

    /**
     * @return string
     */
    public function body()
    {
        $body = 'return $this->'.$this->method().'(';

        $body .= $this->related->getQualifiedUserClassName().'::class';

        if ($this->needsForeignKey()) {
            $body .= ', '.Dumper::export($this->foreignKey());
        }

        if ($this->needsLocalKey()) {
            $body .= ', '.Dumper::export($this->localKey());
        }

        $body .= ');';

        return $body;
    }

    /**
     * @return string
     */
    abstract protected function method();

    /**
     * @return bool
     */
    protected function needsForeignKey()
    {
        $defaultForeignKey = $this->parent->getRecordName().'_id';

        return $defaultForeignKey != $this->foreignKey() || $this->needsLocalKey();
    }

    /**
     * @return string
     */
    protected function foreignKey()
    {
        return $this->command->columns[0];
    }

    /**
     * @return bool
     */
    protected function needsLocalKey()
    {
        return $this->parent->getPrimaryKey() != $this->localKey();
    }

    /**
     * @return string
     */
    protected function localKey()
    {
        return $this->command->references[0];
    }
}
