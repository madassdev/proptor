<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Sale;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $total_properties = Property::count();
        $total_sales = Sale::wherePaymentStatus('paying')->orWhere('payment_status','completed')->count();;
        $total_payments = Payment::sum('amount');
        $properties = Property::latest()->take(5)->get();
        return view('admin.index', compact('total_users', 'total_properties', 'total_sales', 'total_payments', 'properties'));
    }
}
