<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

/**
 * global helpers
 */

namespace DecodeLabs\Cosmos
{
    use DecodeLabs\Cosmos;
    use DecodeLabs\Veneer;

    // Register the Veneer facade
    Veneer::register(Context::class, Cosmos::class);
}
