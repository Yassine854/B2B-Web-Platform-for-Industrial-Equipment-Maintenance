<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Typeindustrie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)) {
            $user = Auth::user(); //add
            $success = true;
            $message = "User login successfully";
        } else {
            $success = false;
            $message = "Unautorised";
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'user' => $user, // add

        ];

        return response()->json($response);
    }


    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = "User register successfully";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function get_all_users(){
        $users=User::all();
        return response()->json([
            'users'=>$users
        ],200);
    }


    public function createAdmin(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);


        $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role=2;
            $user->save();

        return response()->json([
            'message'=>'User created successfully'
        ]);
    }



    public function createClient(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'society'=>'required',
            'type_ind'=>'required',
            'responsable'=>'required',
            'N_responsable'=>'required',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
        ]);


        $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->society = $request->society;
            $user->type_ind = $request->type_ind;
            $user->responsable = $request->responsable;
            $user->N_responsable = $request->N_responsable;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->role=1;
            $user->email_verified_at = now();
            $user->save();

        return response()->json([
            'message'=>'User created successfully'
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
        ]);
        $user=User::find($id);
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->society = $request->society;
        $user->type_ind = $request->type_ind;
        $user->responsable = $request->responsable;
        $user->N_responsable = $request->N_responsable;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->update();
        return response()->json([
            'message'=>'User updated successfully'
        ]);
    }



    public function deleteUser($id){
        $user=User::find($id);
        $user->delete();
        return response()->json('User deleted');
    }

    public function search_user(Request $request) {
        $search = $request->get('s');

        if ($search != null) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhere('society', 'LIKE', "%$search%");
            })->get();
            return response()->json([
                'users' => $users
            ], 200);
        } else {
            return $this->get_all_users();
        }
    }

    public function verifyEmail($id)
{
    $user = User::find($id);
    if ($user) {
        if ($user->email_verified_at === null) { // Make sure not to overwrite if it's already verified
            $user->email_verified_at = now(); // Use the now() function to get the current date and time
            $user->save();
        }
        return response()->json('E-mail vérifié');
    } else {
        return response()->json('Utilisateur introuvable', 404);
    }
}

}
