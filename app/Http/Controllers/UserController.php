<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('user.view')) {

            $search = $request->input('search');
            $users = User::search($search)->paginate(7);
            return view('users.index', compact('users', 'search'));

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        if (Auth::user()->can('user.create')) {

            $roles = Role::all();
            return view('users.create', compact('roles'));

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('user.create')) {

            $this->validate($request, [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users|max:255',
                'role' => 'required'

            ]);
            /*$user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt('12345678')
            ]);*/

            $random = 12345678;
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($random);

            $user->save();

            $user->roles()->sync($request->input('role'));

            $notification = [
                'message' => 'The User Add successfully!',
                'alert-type' => 'success'
            ];

            /*$email = $request->email;
            $pass = bcrypt('12345678');
            $messageData = ['email' => $request->email, 'name' => $request->name, 'code' => $random];

            Mail::send('mails.send_code', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Send password to user');
            });*/

            return redirect()->route('user.index')->with($notification);

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->can('user.show')) {


        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        if (Auth::user()->can('user.update')) {

            $roles = Role::all();
            $user = User::find($id);
            return view('users.edit', compact('roles', 'user'));

        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->can('user.update')) {
            $current_user_logged = Auth::user()->id;
            $is_superAdmin = 1;
            if ($current_user_logged == $id) {
                ;
                $notification = [
                    'message' => 'Can\'t update current user logged now!',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            } elseif ($is_superAdmin == $id) {
                $notification = [
                    'message' => 'Can\'t update super Administration!',
                    'alert-type' => 'error'
                ];

                return redirect()->back()->with($notification);
            } else {

                $this->validate($request, [
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'role' => 'required'

                ]);

                $user = User::find($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = '12345678';
                $user->save();

                $user->roles()->sync($request->input('role'));

                $notification = [
                    'message' => 'The User Update successfully!',
                    'alert-type' => 'success'
                ];
                return redirect()->route('user.index')->with($notification);
            }
        } else {

            $notification = [
                'message' => __('words.not_permission'),
                'alert-type' => 'warning'
            ];

            return redirect()->back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (Auth::user()->can('user.delete')) {
                $current_user_logged = Auth::user()->id;
                $is_superAdmin = 1;
                if ($current_user_logged == $id) {
                    ;
                    $notification = [
                        'message' => 'Can\'t delete current user logged now!',
                        'alert-type' => 'error'
                    ];

                    return redirect()->back()->with($notification);
                } elseif ($is_superAdmin == $id) {

                    $notification = [
                        'message' => 'Can\'t delete super Administration!',
                        'alert-type' => 'error'
                    ];

                    return redirect()->back()->with($notification);
                } else {

                    $user = User::find($id);
                    $user->delete();
                    $notification = [
                        'message' => 'The User Delete successfully!',
                        'alert-type' => 'success'
                    ];

                    return redirect()->back()->with($notification);
                }

            } else {

                $notification = [
                    'message' => __('words.not_permission'),
                    'alert-type' => 'warning'
                ];

                return redirect()->back()->with($notification);
            }
        } catch (QueryException $e) {
            $notification = [
                'message' => 'You are can\'t delete it! Now!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }
}
