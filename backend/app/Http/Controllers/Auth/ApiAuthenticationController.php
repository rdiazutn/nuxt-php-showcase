<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Vyuldashev\LaravelOpenApi\Annotations as OA;
use App\OpenApi\Annotations\OARequest;

/**
 * Class UserController
 * @package App\Http\Controllers
 * @OA\PathItem()
 */
class ApiAuthenticationController extends Controller
{

    /**
     * Handle an incoming authentication request.
     *
     * @OA\Operation(tags="auth")
     * @OARequest(request="Auth\LoginRequest")
     * @OA\Response(factory="Unauthorized")
     * @App\OpenApi\Security\SanctumSecuritySchemeFactory
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->json('OK');
    }

    /**
     * Destroy an authenticated session.
     *
     * @OA\Operation(tags="auth")
     * @OA\Response(factory="Ok")
     * @OA\Response(factory="Unauthorized")
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json('OK');
    }

    /**
     * Get authenticated user
     *
     * @OA\Operation(tags="auth")
     * @OA\Response(factory="Ok")
     * @OA\Response(factory="Unauthorized")
     * @param Request $request
     * @return mixed
     */
    public function user(Request $request)
    {
        return $request->user();
    }
}
