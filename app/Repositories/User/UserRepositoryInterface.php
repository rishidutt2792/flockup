<?php namespace App\Repositories\User;

/**
 * Created by PhpStorm.
 * User: atul
 * Date: 9/21/2016
 * Time: 11:32 PM
 */
interface UserRepositoryInterface
{
    public function find($userId);
}