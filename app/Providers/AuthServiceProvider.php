<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('custom-jwt', function ($request) {
            $token = $request->bearerToken();
            if ($token && strlen($token) > 0) {
                try {
                    $decoded = JWT::decode($token, config('auth.jwt_secret'), ['HS256']);
                    if (!$decoded) throw new \Exception;
                } catch (ExpiredException $e) {
                    abort(401, 'Token expired');
                } catch (SignatureInvalidException | \Exception $e) {
                    abort(401, 'Invalid token');
                }
                return User::find($decoded);
            }
            return null;
        });
    }
}
