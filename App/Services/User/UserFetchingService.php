<?php

namespace App\Services\User;

use Core\Response;
use App\Models\User;
use Core\Traits\Service;
use App\Controllers\BaseController;

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class UserFetchingService
{
    use Service;

    /**
     * Logging User In.
     * 
     * @since 1.2.0
     * 
     * @param array $request
     * 
     * @return string
     */
    public function login(array $request): string
    {
        $userModel = new User;

        $user = $userModel->where($this->prepareInput($request));
        $result = $this->verifyPassword($user, $request);

        return $result ? $userModel->login($user) : $this->abort();
    }

    /**
     * Unauthorized Action.
     * 
     * @since 1.2.0
     * 
     * @return void
     */
    private function abort(): void
    {
        die(
            (new BaseController)->error(
                Response::ERROR,
                'Username Or Password Is Wrong.',
                Response::HTTP_FORBIDDEN
            )
        );
    }

    /**
     * Verifying Input Password With Fetched User's Password.
     * 
     * @since 1.2.0
     * 
     * @param array $request
     * @param array $user
     * 
     * @return bool
     */
    private function verifyPassword(array $user, array $request): bool
    {
        return password_verify($request['password'], $user['password']);
    }

    /**
     * Preparing Input For Fetching User From Database.
     * 
     * @since 1.2.0
     * 
     * @param array $request
     * 
     * @return array
     */
    private function prepareInput(array $request): array
    {
        return [
            'email' => $request['email']
        ];
    }
}