<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Product;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\Typeindustrie;
use App\Notifications\Notify;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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


    //Notifications
    // $currentDate = Carbon::now();
    // $assignments = Assignment::all();
    // foreach ($assignments as $assignment) {
    //     $product = Product::where('id', $assignment->product_id)->first();
    //      $huile=intval($assignment->c_huile)/(intval($product->time_day)*365);
    //      if ($huile<0.1)
    //         if(round($huile/0.0033333)==10){
    //             $client = User::where('id', $assignment->client_id)->first();
    //             $message="il vous reste 10 jours";
    //             Notification::send($client,new Notify($message,"info"));
    //         }
    // }


        return response()->json($response);
    }

    public function check_email(Request $request)
    {
        $email = $request->input('email');

        // Check if the email already exists in the database
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['isUnique' => false]);
        } else {
            return response()->json(['isUnique' => true]);
        }
    }

    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users'),
        ],
        'password' => 'required|string|min:8',
    ]);

    try {
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        $success = true;
        $message = "User registered successfully";
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
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string|min:8',
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
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string|min:8',
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
            'name'=>'required|string',
            'email'=>'required|email',
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


    public function updateClientDetails(Request $request, $id)
    {
        $request->validate([
            'society'=>'required',
            'type_ind'=>'required',
            'responsable'=>'required',
            'N_responsable'=>'required',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
        ]);

        $user=User::find($id);
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

    public function requestVerification(Request $request, $id)
    {
        $request->validate([
            'society'=>'required',
            'type_ind'=>'required',
            'responsable'=>'required',
            'N_responsable'=>'required',
            'country'=>'required',
            'city'=>'required',
            'address'=>'required',
        ]);

        $user=User::find($id);
        $user->society = $request->society;
        $user->type_ind = $request->type_ind;
        $user->responsable = $request->responsable;
        $user->N_responsable = $request->N_responsable;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->update();

        $admins = User::where('role', 2)->get();
        $message="La société ".$user->society." a demandé la vérification de son adresse E-mail.";
        Notification::send($admins,new Notify($message,"info",$user->society));
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
            $user->role=1; //Become verified client
            $user->save();
        }
        return response()->json('E-mail vérifié');
    } else {
        return response()->json('Utilisateur introuvable', 404);
    }
}


public function verifyOldPassword( Request $request,$id)
{
    $this->validate($request, [
        'old_password' => 'required',
    ]);

    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
    }

    if (!Hash::check($request->old_password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['Le mot de passe précédent est incorrect.'],
        ]);
    }

    return response()->json(['success' => true]);
}


public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'new_password'=>'required|string|min:8',
        ]);

        $user=User::find($id);
        $user->password = Hash::make($request->new_password);
        $user->update();
        return response()->json([
            'message'=>'User updated successfully'
        ]);
    }

    //Admin Dashboard


    public function getClientCount()
{
    $clientCount = User::where('role', 1)->count();

    return response()->json(['clientCount' => $clientCount]);
}

}
