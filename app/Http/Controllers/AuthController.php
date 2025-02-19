<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;



class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Admin,User', // Ensure only valid roles
        ]);

        $data['password'] = Hash::make($data['password']);
        $users = User::create($data);
        if($users){
            return redirect()->route('login')->with('success','Register Successfully');
        }
        return back()->withError('Registration failed. Please try again.');
    }

    /**
     * Login an existing user.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors('Invalid credentials. Please try again.');
    }

    /**
     * Show the user dashboard.
     */
    public function dashboard()
    {

    if (Auth::check()) {
        // Get counts for each order status
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        // Pass the data to the view
        return view('auth.dashboard', compact('pendingOrders', 'deliveredOrders'));
    }

    return redirect()->route('login')->withErrors('Please log in to access the dashboard.');
}


    /**
     * product view for authenticated users.
     */
    public function product()
    {
        if (Auth::check()) {
            return view('auth.commerce.product');
        }

        return redirect()->route('login')->withErrors('Please log in to access this page.');
    }

    /**
     * Logout the current user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function pendingOrders()
{
    if (Auth::check()) {
        // Fetch pending orders with associated product details
        $pendingOrders = Order::with('product')
            ->where('status', 'pending')
            ->get();

        // Pass data to the view
        return view('auth.order.pending_order', compact('pendingOrders'));
    }

    return redirect()->route('login')->withErrors('Please log in to access the pending orders.');
}


// In OrderController.php

public function deliveredOrders()
{
    $deliveredOrders = Order::where('status', 'delivered')->get(); // Get all orders with "delivered" status

    return view('auth.order.delivered_orders', compact('deliveredOrders'));
}


public function markAsDelivered($orderId, Request $request)
{
    $order = Order::findOrFail($orderId);
    if ($order->status != 'pending') {
        return response()->json(['success' => false, 'message' => 'Only pending orders can be marked as delivered.']);
    }
    $order->status = 'delivered';
    $order->save();
    return response()->json(['success' => true, 'message' => 'Order marked as delivered.']);
}

}
