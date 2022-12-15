<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendRegisterEmail($name, $email, $verification_code) {
        $data = [
            'name' => $name,
            'verification_code' => $verification_code
        ];
        Mail::to($email)->send(new RegisterEmail($data));
    }
}
