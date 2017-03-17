<?php

class PasswordHandler
{
    //Encrypts the password and returns the encrypted password
    public static function Encrypt($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }
    
    //Verify if passwords match, returns true if the password matches the hashed password and false if otherwise
    public static function Verify($password,$hash)
    {
        return password_verify($password,$hash);
    }
}