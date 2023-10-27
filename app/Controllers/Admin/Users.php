<?php

/**
 * =====================================================================================
 *             VIPEmbed - Movies TV Shows Embed PHP Script (c) John Antonio
 * -------------------------------------------------------------------------------------
 *
 *  @copyright This software is exclusively sold at codester.com. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from https://www.codester.com
 *
 * ======================================================================================
 *
 * @author John Antonio
 * @link https://www.codester.com/jonty/
 * @license https://www.codester.com/items/35846/vipembed-movies-tv-shows-embed-php-script
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $users = $this->model->where('role !=', UserModel::ROLE_ADMIN)
                             ->orderBy('created_at', 'desc')
                             ->findAll();

        $topBtnGroup = create_top_btn_group([
            'admin/users/new' => 'Add User'
        ]);

        $title = 'Users - ( ' . count($users) . ' )';
        return view('admin/users/list', compact('title', 'users', 'topBtnGroup'));
    }

    public function new()
    {
        $title = 'Add User';
        $user = new User();

        $topBtnGroup = create_top_btn_group([
            'admin/users' => 'Back to Users'
        ]);

        $data  = compact('title', 'user', 'topBtnGroup');
        return view('admin/users/new', $data);
    }

    public function edit( $id )
    {

        $user = $this->getUser( $id );
        $title = 'Edit User - ( ' . $user->username . ' )';

        $topBtnGroup = create_top_btn_group([
            'admin/users' => 'Back to Users'
        ]);

        $data  = compact('title', 'user', 'topBtnGroup');
        return view('admin/users/edit', $data);
    }

    public function create()
    {
        if($this->request->getMethod() !== 'post'){
            throw new PageNotFoundException('Invalid request');
        }

        $user = new User( $this->request->getPost() );

        if($this->model->save( $user )){

            $insertId = $this->model->getInsertID();

            //Email verified
            $this->model->emailVerified( $insertId );

            //Admin approved
            $this->model->adminApproved( $insertId );

            //Update user role
            $this->model->updateUserRole( $insertId, $user->role);

            //Update user status
            $this->model->updateUserStatus( $insertId, $user->status );

            return redirect()->to('/admin/users/edit/' . $this->model->getInsertID())
                             ->with('success', 'user created successfully');

        }

        return redirect()->back()
                         ->with('errors', $this->model->errors())
                         ->withInput();
    }

    public function update( $id )
    {
        if($this->request->getMethod() !== 'post'){
            throw new PageNotFoundException('Invalid request');
        }

        $user = $this->getUser( $id );

        $user->username = $this->request->getPost('username');
        $user->email = $this->request->getPost('email');

        if($user->hasChanged()){
            if(! $this->model->save( $user )){

                return redirect()->back()
                                 ->with('errors', $this->model->errors())
                                 ->withInput();

            }
        }

        // Check admin approval
        $isAdminApproved = $this->request->getPost('is_admin_approved');
        if($user->is_admin_approved != $isAdminApproved){

            //Update admin approval
            $this->model->adminApproved($user->id, $isAdminApproved);
        }

        // Check email verification
        $isEmailVerified = $this->request->getPost('is_email_verified');
        if($user->is_email_verified != $isEmailVerified){

            //Update email verification
            $this->model->emailVerified($user->id, $isEmailVerified);
        }

        // Check user role
        $userRole = $this->request->getPost('role');
        if($user->role != $userRole){

            //Update email verification
            $this->model->updateUserRole($user->id, $userRole);
        }

        // Check user status
        $status = $this->request->getPost('status');
        if($user->status != $status){

            //Update email verification
            $this->model->updateUserStatus($user->id, $status);
        }

        //Attempt to change password
        $newPasswd = $this->request->getPost('new_password');
        $confirmPasswd = $this->request->getPost('confirm_password');
        if(! empty($newPasswd)){

            $user->password = $newPasswd;
            $user->confirm_password = $confirmPasswd;

            if(! $this->model->updatePassword( $user )){

                return redirect()->back()
                                ->with('errors', $this->model->errors());

            }

        }

        return redirect()->to('/admin/users')
                         ->with('success', 'User profile updated successfully');
    }

    public function delete( $id )
    {
        $user = $this->getUser( $id );

        if($this->model->delete( $user->id )){

            return redirect()->back()
                             ->with('success', 'User has been successfully deleted');

        }

        return redirect()->back()
                         ->with('errors', 'something went wrong');
    }

    protected function getUser( $id )
    {
        $user = $this->model->where('role !=', UserModel::ROLE_ADMIN)
                            ->getUser( $id );

        if($user === null){

            throw new PageNotFoundException('user not found');

        }

        return $user;
    }

}
