<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Notifications\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /** * Create token password reset. * * 
     * @param ResetPasswordRequest $request * 
     * @return JsonResponse 
     * */

    public function reset(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        if ($user) {
            if (strcmp(bcrypt($request->password), ($user->password))) {
                $newPassword = $request->resetPassword;
                $user->password = $newPassword;
                $user->save();
                return response()->json(['message' => 'Success',]);
            }
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
