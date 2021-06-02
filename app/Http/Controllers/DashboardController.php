<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;

class DashboardController extends Controller
{
  /**
   * Menampilkan dashboard
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // View
    return view('admin/dashboard/index');
  }
}
