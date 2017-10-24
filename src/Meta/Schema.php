<?php

/**
 * Created by Cristian.
 * Date: 02/10/16 07:56 PM.
 */

namespace shishao\Laramodel\Meta;

/**
 * Created by Cristian.
 * Date: 18/09/16 06:50 PM.
 */
interface Schema
{
    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function connection();

    /**
     * @return string
     */
    public function schema();

    /**
     * @return \shishao\LaramodelMeta\Blueprint[]
     */
    public function tables();

    /**
     * @param string $table
     *
     * @return bool
     */
    public function has($table);

    /**
     * @param string $table
     *
     * @return \shishao\LaramodelMeta\Blueprint
     */
    public function table($table);

    /**
     * @param \shishao\LaramodelMeta\Blueprint $table
     *
     * @return array
     */
    public function referencing(Blueprint $table);
}
