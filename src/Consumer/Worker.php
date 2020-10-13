<?php

declare(strict_types=1);

namespace App\Consumer;

/**
 * Class Worker
 * https://github.com/krakjoe/pthreads-autoloading-composer
 */
class Worker extends \Worker
{
    public function run()
    {
        /* include autoloader for Tasks */
        require_once("vendor/autoload.php");
    }

    public function start($options = PTHREADS_INHERIT_ALL)
    {
        /* override default inheritance behaviour for the new threaded context */
        return parent::start(PTHREADS_INHERIT_NONE);
    }
}