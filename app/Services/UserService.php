<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserService
{
    public function createUser(array $data): ?User
    {
        try {
            $apiToken = $this->createApiToken();

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['name']);
            $user->rank_id = 1;
            $user->current_airport_id = 'AYMR';
            $user->api_token = $apiToken;
            $user->save();
        } catch (QueryException $exception) {
            return null;
        }
        return $user;
    }

    public function createApiToken(): string
    {
        return Uuid::uuid4();
    }
}
