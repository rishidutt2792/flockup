<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Contracts\Validation\Validator;
use DB;

class BaseController extends Controller
{
    use Helpers;

    public $limit;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->limit = ($request->get('limit') ? $request->get('limit') : config('mm.page_limit'));
    }

    public function throwStoreResourceFailedException($message='Failed to store your requested resource.', Validator $validator=null)
    {
        if ($validator instanceof Validator) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException($message, $validator->error());
        } else {
            throw new \Dingo\Api\Exception\StoreResourceFailedException($message);
        }
    }

    public function throwResourceException($message='Failed to process your requested resource.')
    {
        throw new \Dingo\Api\Exception\ResourceException($message);
    }

    protected function socialValidateOrFail($data, $validationRules, $options=[])
    {
        $validator = app('validator')->make($data, $validationRules);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
    }

    protected function validateOrFail($data, $validationRules, $options=[])
    {
        if ($this->auth->user()) {
            $data['user_id'] = $this->auth->user()->id; // Get User id from User Resolver
        }

        $validator = app('validator')->make($data, $validationRules, $options);

        if ($validator->fails()) {
            $message = (isset($options['message']) ? $options['message']:'Could not process your request, following are the errors.');
            throw new ValidationHttpException($validator->errors()->all());
        }
    }

    protected function getAuthenticatedUserId()
    {
        if (null !== $this->auth->user() && isset($this->auth->user()->id)) {
            return $this->auth->user()->id;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Unable to get authenticated user info.', 'Unable to get authenticated user info.');
        }
    }

    public function debugQueries()
    {
        if (app()->environment('local')) {
            DB::listen(function($sql, $bindings) {
                var_dump($sql);
                var_dump($bindings);
            });
        }
    }
}
