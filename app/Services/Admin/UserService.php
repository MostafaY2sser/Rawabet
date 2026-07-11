<?php
namespace App\Services\Admin;

use App\Repositories\Admin\UserRepositry;
use Illuminate\Http\Request;

class UserService{

    protected $userRepositry;
    public function  __construct(UserRepositry $userRepositry){

        $this->userRepositry = $userRepositry;
    }
  
  public function getAllUsers(){
        
    return $this->userRepositry->getAllUsers();
    }

    public function store(Request $request){
        $this->userRepositry->store($request);
    }
    public function update(Request $request , $id){
        $this->userRepositry->update($request , $id);
    }
}