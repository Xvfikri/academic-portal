<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginPageController extends Controller
{
  public function show()
  {
    return view('auth.login-custom');
  }
}

