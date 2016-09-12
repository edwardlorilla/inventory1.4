<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Photo;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();

        return view('admin.users.index',compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $roles=Role::lists('name', 'id')->all();
        return view('admin.users.create', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
//        dd($request);
        
        $input = $request->all();
        if (trim($request->password)==''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }

        if ($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file ->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }
        $input['password'] = bcrypt($request->password);
        User::create($input);
        return redirect(route('admin.users.index'));
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
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (trim($request->password)==''){
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }
        if ($file = $request->file('photo_id')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }
        $input['password'] = bcrypt($request->password);
        $user->update($input);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource f'admin.users.index'rom storage.
     *
     * @param  int  $id'admin.users.index'
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!(empty($user->photo->file))){
            unlink(public_path().  $user->photo->file);
        }

        $user ->delete();
        Session::flash('Do you want to delete?', 'The user has been deleted');
        return redirect()->route('admin.users.index');
    }
   


}
