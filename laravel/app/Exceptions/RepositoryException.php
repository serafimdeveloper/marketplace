<?php
namespace App\Exceptions;

use Exception;

class RepositoryException extends Exception
{
    protected $message = 'Error on CRUD';
    protected $code = 500;
}
