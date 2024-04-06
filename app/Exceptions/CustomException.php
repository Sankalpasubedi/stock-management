<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $dontReport = [
        //\Illuminate\Auth\AuthenticationException::class,
        ///\Illuminate\Auth\Access\AuthorizationException::class,
        //\Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        //\Illuminate\Session\TokenMismatchException::class,
        //\Illuminate\Validation\ValidationException::class,
    ];
}
