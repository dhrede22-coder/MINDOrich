<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tribe;
use App\Models\Producer;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Producer::with('tribe');

    // Search
    if ($request->filled('search')) {
        $query->where('producer_name', 'like', '%' . $request->search . '%');
    }

    // Tribe Filter
    if ($request->filled('tribe')) {
        $query->where('tribe_id', $request->tribe);
    }

    // Gender Filter
    if ($request->filled('gender')) {
        $query->where('gender', $request->gender);
    }

    // Status Filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

   $producers = $request->boolean('all')
    ? $query->latest()->get()
    : $query->latest()->limit(10)->get();

    $tribes = Tribe::orderBy('tribe_name')->get();

    $totalProducers = Producer::count();

    $totalTribes = Tribe::count();

    $maleProducers = Producer::where('gender', 'Male')->count();

    $femaleProducers = Producer::where('gender', 'Female')->count(); 

    return view('admin.producers.index', compact(
    'producers',
    'tribes',
    'totalProducers',
    'totalTribes',
    'maleProducers',
    'femaleProducers'
));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $tribes = Tribe::orderBy('tribe_name')->get();

    return view('admin.producers.create', compact('tribes'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate(

    [
        'producer_name' => 'required|string|max:255',
        'tribe_id' => 'required|exists:tribes,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'gender' => 'required|in:Male,Female',
        'birthdate' => 'required|date|before_or_equal:today',
        'contact_number' => 'required|digits:11',
        'address' => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'years_of_experience' => 'required|integer|min:0',
        'status' => 'required|in:Active,Inactive',
        'biography' => 'required|string',
    ],

    [

        'producer_name.required' => 'Producer name is required.',

        'tribe_id.required' => 'Please select a tribe.',

        'gender.required' => 'Please select a gender.',

        'birthdate.required' => 'Birthdate is required.',

        'birthdate.before_or_equal' => 'Birthdate cannot be in the future.',

        'contact_number.required' => 'Contact number is required.',

        'contact_number.digits' => 'Contact number must be exactly 11 digits.',

        'address.required' => 'Address is required.',

        'specialization.required' => 'Specialization is required.',

        'years_of_experience.required' => 'Years of experience is required.',

        'years_of_experience.integer' => 'Years of experience must be a whole number.',

        'years_of_experience.min' => 'Years of experience cannot be negative.',

        'status.required' => 'Please select a status.',

        'biography.required' => 'Biography is required.',

        'photo.image' => 'Please upload a valid image.',

        'photo.mimes' => 'Photo must be JPG, JPEG, or PNG.',

        'photo.max' => 'Photo must not exceed 2MB.',

    ]

);
$photoPath = null;

if ($request->hasFile('photo')) {

    $photoPath = $request->file('photo')->store('producers', 'public');

}
Producer::create([

    'tribe_id' => $request->tribe_id,

    'producer_name' => $request->producer_name,

    'photo' => $photoPath,

    'gender' => $request->gender,

    'birthdate' => $request->birthdate,

    'contact_number' => $request->contact_number,

    'address' => $request->address,

    'biography' => $request->biography,

    'specialization' => $request->specialization,

    'years_of_experience' => $request->years_of_experience,

    'status' => $request->status,

]);
return redirect()
    ->route('producers.index')
    ->with('success', 'Producer added successfully.');
       
}

    /**
     * Display the specified resource.
     */
   public function show(Producer $producer)
{
    return view('admin.producers.show', compact('producer'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producer $producer)
{
    $tribes = Tribe::all();

    return view('admin.producers.edit', compact('producer', 'tribes'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producer $producer)
{
    $request->validate(

        [
            'producer_name' => 'required|string|max:255',
            'tribe_id' => 'required|exists:tribes,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gender' => 'required|in:Male,Female',
            'birthdate' => 'required|date|before_or_equal:today',
            'contact_number' => 'required|digits:11',
            'address' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'biography' => 'required|string',
        ]

    );

    // Keep current photo
    $photoPath = $producer->photo;

    // Replace photo if a new one is uploaded
    if ($request->hasFile('photo')) {

        if ($producer->photo && Storage::disk('public')->exists($producer->photo)) {

            Storage::disk('public')->delete($producer->photo);

        }

        $photoPath = $request->file('photo')->store('producers', 'public');

    }

    $producer->update([

        'tribe_id' => $request->tribe_id,
        'producer_name' => $request->producer_name,
        'photo' => $photoPath,
        'gender' => $request->gender,
        'birthdate' => $request->birthdate,
        'contact_number' => $request->contact_number,
        'address' => $request->address,
        'specialization' => $request->specialization,
        'years_of_experience' => $request->years_of_experience,
        'status' => $request->status,
        'biography' => $request->biography,

    ]);

    return redirect()
        ->route('producers.index')
        ->with('success', 'Craftsman updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producer $producer)
{
    // Check if the craftsman has products assigned
    if (Product::where('producer_id', $producer->id)->exists()) {

        return redirect()
    ->back()
    ->with('delete_error', 'This craftsman cannot be deleted because they have products assigned to them.');
    }

    // Delete photo if it exists
    if ($producer->photo && Storage::disk('public')->exists($producer->photo)) {

        Storage::disk('public')->delete($producer->photo);
    }

    // Delete record
    $producer->delete();

    return redirect()
        ->route('producers.index')
        ->with('success', 'Craftsman deleted successfully.');
}
}
