<?php
/**
 * Created by PhpStorm.
 * User: atul
 * Date: 9/21/2016
 * Time: 11:33 PM
 */

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function find($userId)
    {
        $user=$this->user->findOrFail($userId);
        return $user;
    }
}