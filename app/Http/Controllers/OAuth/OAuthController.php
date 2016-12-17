<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests;

use Authorizer;
use League\OAuth2\Server\Exception\InvalidCredentialsException;
use Mockery\CountValidator\Exception;
use Validator;
use Config;
use App\Models\User;

use Illuminate\Support\Facades\Password;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\OAuth\OAuthClient;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class OAuthController extends BaseController
{
    public function getLoginValidationRules()
    {
        return [
            'grant_type'    => 'required',
            'client_id'     => 'required',
            'client_secret' => 'required',
            'username'      => 'required|email',
            'password'      => 'required',
            'scope'         => 'required',
        ];
    }

    public function login(Request $request)
    {
        $clientData=DB::table('oauth_clients')->where('name', 'api')->first();

        $userScope=$this->checkUserScope(Input::get('username'));

        Input::merge([
            'client_id'     => "".$clientData->id,
            'client_secret' => "".$clientData->secret,
            'scope'         => $userScope
        ]);

        $credentials = $request->only(['grant_type', 'client_id', 'client_secret', 'username', 'password','scope']);


        $validationRules = $this->getLoginValidationRules();

        $credentials["client_id"]="".$clientData->id;
        $credentials["client_secret"]="".$clientData->secret;

        $this->validateOrFail($credentials, $validationRules);

        try {
            if (! $accessToken = Authorizer::issueAccessToken()) {
                return $this->response->errorUnauthorized();
            }
        }
        catch (\League\OAuth2\Server\Exception\OAuthException $e)
        {
            throw $e;
            return $this->response->error('could_not_create_token', 500);
        }

        $accessToken["groups"][]=$userScope;
        return response()->json(compact('accessToken'));
    }

    public function getUserIdByEmail($email)
    {
        try
        {
            $user=User::where('email',$email)->firstOrFail();
            return $user;
        }
        catch(ModelNotFoundException $mnfex)
        {
            return $this->response->error('User Does Not Exists !', 404);
        }
        catch(\Exception $ex)
        {
            return $this->response->error('Error Occurred !', 500);
        }
    }

    public function checkUserScope($email)
    {
        try
        {
            if((User::where('email', '=', $email)->exists()))
            {
                $userId=User::where('email', '=', $email)->pluck('id');
                $user=User::find($userId);
                $groups=$user->groups;
                return $groups[0]->name;
            }
            else
            {
                return "empty";
            }
        }
        catch(\Exception $ex)
        {
            return $this->response->error('Error Occurred : '.$ex->getMessage(), 404);
        }
    }
}
