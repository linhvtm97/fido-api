<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Notifications\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

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
            if (Hash::check($request->password, $user->password))
            {
                $newPassword = $request->resetPassword;
                $user->password = $newPassword;
                $user->save();
                return response()->json(['status_code' => 200, 'message' => 'Success',], 200);
            }
        }
        return response()->json(['status_code' => 404, 'message' => 'User not found'], 404);
    }
}
