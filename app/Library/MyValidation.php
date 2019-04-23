<?php
namespace App\Library;

class MyValidation
{

    public static $rulesUser = array(
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|alpha_num|min:8|max:20',
        'rePassword' => 'same:password',
    );

    public static $ruleGroup = array(
        'name' => 'required|unique:groups',
    );


    public static $ruleDoctor = array(
        'name' => 'required',
        'doctor_no' => 'required|unique:doctors',
        'id_number' => 'required|unique:doctors',
        'email' => 'required|unique:doctors',        
    );

    public static $ruleEmployee = array(
        'name' => 'required',
        'employee_no' => 'required|unique:employees',
        'id_number' => 'required|unique:employees',
        'email' => 'required|unique:employees',
        
    );
    public static $rulePatient = array(
        'name' => 'required',
        'id_number' => 'required|unique:patients',
        'email' => 'required|unique:patients',        
    );

    public static $messageUser = array(
        'name' => 'Name is missing',
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
        'email' => 'Email is required',
        'doctor_no' => 'Doctor number is required',
    );

    public static $messagePatient = array(
        'name' => 'Name is required',
        'email' => 'Email is required',
        'id_number' => 'ID number is required',
    );
    

    public static $messageEmployee = array(
        'name' => 'Name is required',
        'email' => 'Email is required',
        'id_number' => 'ID number is required',
        'employee_no' => 'Employee number is required',
    );

}
