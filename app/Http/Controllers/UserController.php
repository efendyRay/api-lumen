<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\IndexUser;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        // set auth
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'search' => 'string|string|max:200|min:2|regex:/^[a-zA-Z0-9]+$/',
            'skip' => 'numeric|max:10',
            'take' => 'numeric|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $q                = $request->search;
        $take             = $request->take;
        $skip             = $request->skip;
        
        if ($q || ($take && $skip)){
            $users = User::when($q, function($query, $q) {
                $query->where('name', 'like', '%'.$q.'%')
                ->orWhere('phone', 'like', '%'.$q.'%')
                ->orWhere('status', 'like', '%'.$q.'%');
            })->when($take, function($query, $take) {
                $query->take($take);
            })->when($skip, function($query, $skip) {
                $query->skip($skip-1);
            })->orderBy('created_at', 'ASC')->get();

            return $this->return_success("Success Menampilkan Semua User", $users, Response::HTTP_OK);
        } else {
            $users = User::orderBy('created_at', 'ASC')->get();

            return $this->return_success("Success Menampilkan Semua User", $users, Response::HTTP_OK);
        }

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'        => 'required|string|email',
            'name'         => 'required|string',
        ]);
        try {

            $user               = new User;
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->phone        = $request->phone;
            $user->password     = ' ';
            $user->status       = 'Aktif';
            $user->save();

        } catch (\Exception $e) {
            
            return $this->return_badrequest("Gagal Simpan User", $e->getMessage(), Response::HTTP_OK);
        }
        return $this->return_success("Success Simpan User", null, Response::HTTP_OK);
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);

        return $this->return_success("Success Detail User", $user, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'email'        => 'required|string|email',
            'name'         => 'required|string|min:3',
        ]);
        try {

            $user->name   = $request->name;
            $user->email  = $request->email;
            $user->phone  = $request->phone;
            $user->update();

        } catch (\Exception $e) {
            return $this->return_badrequest("Gagal Update User", $e->getMessage(), Response::HTTP_OK);
        }

        return $this->return_success("Success Update User", null, Response::HTTP_OK);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->return_success("Success Delete User", null, Response::HTTP_OK);
    }
}
