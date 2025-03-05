<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
   
    public function index(){
        {
            // Tambah data user dengan Eloquent Model
           /* $data = [
                'level_id' => 2,
                'username' => 'manager_tiga',
                'nama' => 'Manager 3',
                'password' => Hash::make('12345'),
                
            ];
              UserModel::where('username', 'customer-1')->update($data);
               UserModel::create($data);*/
            // Coba akses model UserModel
            $user = UserModel::firstOrNew(
              [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
              ],
            );
            $user->save();

            return view('user', ['data' => $user]);
    }
    }
}
