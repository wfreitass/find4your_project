<?php

namespace App\Http\Controllers;

use App\DTOs\ApiResponseDTO;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\AuthCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;


class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request): JsonResponse
    {
        try {
            if (User::ofEmail($request->email)->first()) {
                return ApiResponseDTO::error(500, message: "Email cadastrado na base, escolha outro")->toJson();
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return ApiResponseDTO::success(200, data: new AuthCollection(
                [
                    'user' => $user,
                    'status' => true,
                    'message' => 'Usuário Criado com sucesso',
                    'token' => $user->createToken('API TOKEN')->accessToken,
                ]
            ))->toJson();
        } catch (Throwable $th) {
            return ApiResponseDTO::error(500, message: $th->getMessage(), errors: $th)->toJson();
        }
    }

    public function loginUser(LoginUserRequest $request): JsonResponse
    {
        try {
            if (! Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email ou senha inválidos',
                ], 401);
            }

            $user = User::ofEmail($request->email)->first() ?? null;

            return ApiResponseDTO::success(200, data: new AuthCollection(
                [
                    'user' => $user,
                    'token' => $user->createToken('API_TOKEN')->accessToken,
                ]
            ))->toJson();
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function user(Request $request)
    {
        return new AuthCollection(
            [$request->user()],
        );
        // return ApiResponseDTO::success(200, data: new AuthCollection(
        //     [$request->user()],
        // ))->toJson();
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged out',
        ]);
    }
}
