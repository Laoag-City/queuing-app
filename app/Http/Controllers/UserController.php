<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\QueueType;
use Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
    	$this->request = $request;
    }

    public function index()
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('users_dashboard', [
	    		'title' => 'User Management',
	    		'users' => User::where('is_admin', false)->with(['queue_type'])->get(),
	    		'queues' => QueueType::all()
	    	]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
    		$validator = Validator::make($this->request->all(), [
    			'username' => 'bail|required|max:30|unique:users,username',
    			'password' => 'bail|required|confirmed',
    			'queue_type' => 'bail|required|exists:queue_types,queue_type_id',
    			'window_number' => 'bail|required|integer|min:1|max:99',
                'picture' => 'bail|required|image|dimensions:min_width=600,max_width=4200,min_height=600,max_height=4200,ratio=1/1'
    		]);

    		$validator->after(function($validator){
    			$window_numbers = User::select('window_number')
    									->where([
    										['queue_type_id' , '=', $this->request->queue_type],
    										['window_number', '=', $this->request->window_number]
    									])
    									->get();

    			if($window_numbers->isNotEmpty())
    				$validator->errors()->add('window_number', 'The window number you assigned is already taken.');
    		});

    		$validator->validate();

            $path = $this->request->file('picture')->store('');

    		$user = new User;
    		$user->queue_type_id = $this->request->queue_type;
    		$user->username = $this->request->username;
    		$user->password = bcrypt($this->request->password);
    		$user->window_number = $this->request->window_number;
            $user->picture_path = $path;
    		$user->save();

    		return back()->with('success', ['header' => 'Successfully added a new user.']);
    	}

    	else
    		return response([], 405);
    }

    public function editUser(User $user)
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('edit_user', [
    			'title' => 'Edit User Info',
    			'user' => $user,
    			'queues' => QueueType::all()
    		]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
    		$validator = Validator::make($this->request->all(), [
    			'username' => 'bail|required|max:30|unique:users,username,' . $user->user_id . ',user_id',
    			'password' => 'bail|nullable|confirmed',
    			'queue_type' => 'bail|required|exists:queue_types,queue_type_id',
    			'window_number' => 'bail|required|integer|min:1|max:99',
                'picture' => 'bail|nullable|image|dimensions:min_width=600,max_width=4200,min_height=600,max_height=4200,ratio=1/1'
    		]);

    		$validator->after(function($validator) use($user){
    			$window_numbers = User::select('window_number')
    									->where([
    										['queue_type_id' , '=', $this->request->queue_type],
    										['window_number', '=', $this->request->window_number],
    										['user_id', '!=', $user->user_id]
    									])
    									->get();

    			if($window_numbers->isNotEmpty())
    				$validator->errors()->add('window_number', 'The window number you assigned is already taken.');
    		});

    		$validator->validate();

            if($user->queue_type_id != $this->request->queue_type)
            {
                $user->queue_type_id = $this->request->queue_type;
                $user->current_regular_queue_number = null;
                $user->current_pod_queue_number = null;
                $user->is_currently_serving_regular = null;
            }

    		$user->username = $this->request->username;
    		$user->password = $this->request->password != null ? bcrypt($this->request->password) : $user->password;
    		$user->window_number = $this->request->window_number;

            if($this->request->picture != null)
            {
                Storage::delete($user->picture_path);
                $user->picture_path = $this->request->file('picture')->store('');
            }

    		$user->save();

    		return back()->with('success', ['header' => 'Successfully updated user.']);
    	}

    	else
    		return response([], 405);
    }

    public function removeUser(User $user)
    {
        Storage::delete($user->picture_path);
    	$user->delete();
    	return back();
    }

    public function getPicture(User $user)
    {
        return response()->file(storage_path('app/' . $user->picture_path));
    }
}
