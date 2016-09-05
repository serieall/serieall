<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('ajax', ['only' => 'changePassword']);
        $this->middleware('guest', ['except' => 'logout']);
        $this->middleware('auth', ['except' => 'register, login']);
        $this->userRepository = $userRepository;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:8',
            'password_new' => 'required|confirmed|min:8',
        ]);

    }


    public function getProfile($username){

        $user = $this->userRepository->getUserByUsername($username);

        return view('users.profile', compact('user'));
    }

    public function changePassword(Request $request, $username){

        $user = Auth::user()->username;
        $password_user = Auth::user()->password;
        $password_old = $request->input('password_old');
        $password_new = $request->input('password_new');
        $password_confirmation = $request->input('password_confirmation');

        if (Hash::check($password_old, $password_user)) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            return response()->json();
        }
        else {
            return view('/profil', $user->username);
        }


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
