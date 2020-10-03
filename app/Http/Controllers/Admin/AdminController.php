<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Property;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total_users = rand(10000,9999999);
        $total_properties = rand(10,9999);
        $total_sales = rand(10,999999);
        $total_payments = rand(100000,9999999);
        $properties = Property::latest()->take(5)->get();
        return view('admin.index', compact('total_users', 'total_properties', 'total_sales', 'total_payments', 'properties'));
    }
}
