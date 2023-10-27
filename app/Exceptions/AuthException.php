<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace App\Exceptions;

use CodeIgniter\Exceptions\DebugTraceableTrait;
use OutOfBoundsException;

class AuthException extends OutOfBoundsException
{
    use DebugTraceableTrait;

    /**
     * Error code
     *
     * @var int
     */
    protected $code = 403;

    public static function noAccess(?string $message = null)
    {
        return new static($message ?? 'no access');
    }


}
