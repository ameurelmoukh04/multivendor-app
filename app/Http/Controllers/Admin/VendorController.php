<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $vendors = Vendor::with('user')->latest()->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function show($id)
    {
        $vendor = Vendor::with(['user', 'products'])->findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }

    public function updateStatus(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $vendor->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Vendor status updated successfully');
    }
}
