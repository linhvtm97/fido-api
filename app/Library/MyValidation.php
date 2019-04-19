<?php
namespace App\Library;

class MyValidation
{

    public static $rulesUser = array(
        'name' => 'required',
        'group_id' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|alpha_num|min:8|max:20',
        'rePassword' => 'same:password',
    );

    public static $ruleGroup = array(
        'name' => 'required|unique:groups',
    );


    public static $ruleDoctor = array(
        'name' => 'required|unique:doctors',
        'doctor_no' => 'required|unique:doctors',
        'id_number' => 'required|unique:doctors',
        'email' => 'required|unique:doctors',
        'specialist' => 'required|unique:doctors',
        
    );

    public static $messageUser = array(
        'name' => 'Name is missing',
        'group_id.required' => 'Group id is missing',
        'email.required' => 'Email is missing',
        'email.email' => 'Email is incorrect',
        'password.required' => 'Password is missing',
        'password.min' => 'Minimum length of password must be more than 8',
        'password.max' => 'Maximum length of password must be less than 20',
        'password.alpha_num' => 'Password should contain both number and character',
        'rePassword.same' => 'Confirm Password and Password must be the same',
    );

    public static $messageGroup = array(
        'name' => 'Name is required',
    );


    public static $messageDoctor = array(
        'name' => 'Name is required',
        'email' => 'Name is required',
        'specialist' => 'Name is required',
        'doctor_no' => 'Name is required',

    );

}
