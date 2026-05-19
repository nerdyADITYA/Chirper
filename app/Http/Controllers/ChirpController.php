<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChirpController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')->latest()->take(50)->get();
        return view('home',['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Chirp::class);
        // Validate the incoming request data
        $validated = $request->validate([
            'message' => 'required|string|max:255|min:5',
        ],
        [
            'message.required' => 'Please write something to Chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
            'message.min' => 'Chirps must be at least 5 characters long.',
        ]
        );

        //create the chirp (for anonymous users, user_id will be null)
        auth()->user()->chirps()->create($validated);

        return redirect('/')->with('success', 'Chirp sent!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
    // Validate the incoming request data
        $validated = $request->validate([
            'message' => 'required|string|max:255|min:5',
        ],
        [
            'message.required' => 'Please write something to Chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
            'message.min' => 'Chirps must be at least 5 characters long.',
        ]
        );

        //Update the chirp
        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
