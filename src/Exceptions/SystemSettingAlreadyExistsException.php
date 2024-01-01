<?php

namespace Hankz\LaravelSystemSettings\Exceptions;

use Exception;

/**
 * When creating, inform that the System Setting already exists.
 */
class SystemSettingAlreadyExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('System Setting already exists.');
    }
}
