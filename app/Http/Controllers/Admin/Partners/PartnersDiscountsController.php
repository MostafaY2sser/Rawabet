<?php

namespace App\Http\Controllers\Admin\Partners;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PartnerDiscount;
use App\Models\PartnersSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnersDiscountsController extends Controller
{
    public function index()
    {
        $user = Auth::user('admin');

        if (!$user->can('view partnersDiscounts')) {
            abort(403);
        }
        $discounts = PartnerDiscount::all();
        $sections = PartnersSection::all();
        $partners = Partner::all();
        return view('admin.partners.discounts', compact('discounts', 'partners', 'sections'));
    }

    public function store(Request $request)
    {
        $user = Auth::user('admin');

        if (!$user->can('create partnersDiscounts')) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required',
            'partner_id' => 'required|exists:partners,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'delivery_duration' => 'required|numeric|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('discounts', 'public');
        }

        // Save to database
        PartnerDiscount::create([
            'name' => $validated['name'],
            'section_id' => $validated['section_id'],
            'partner_id' => $validated['partner_id'],
            'price' => $validated['price'],
            'discount' => $validated['discount'],
            'shipping_time' => $validated['delivery_duration'],
            'image' => $imagePath ?? null,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الخصم بنجاح');
    }

    public function update(Request $request, PartnerDiscount $discount)
    {
        $user = Auth::user('admin');

        if (!$user->can('edit partnersDiscounts')) {
            abort(403);
        }
        // ✅ 1. Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required',
            'partner_id' => 'required|exists:partners,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'shipping_time' => 'required|integer|min:0',
            'image' => 'nullable',  // Optional, max 2MB
        ]);

        // ✅ 2. Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($discount->image && Storage::exists($discount->image)) {
                Storage::delete($discount->image);
            }

            // Store new image
            $validated['image'] = $request->file('image')->store('public/discounts');
        }

        // ✅ 3. Update discount
        $discount->update($validated);

        // ✅ 4. Redirect or respond
        return redirect()->back()->with('success', 'تم تحديث الخصم بنجاح.');
    }
}
