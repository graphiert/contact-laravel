<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Showing Index view with sending contacts data
        return view('contacts.index', [
            // Send contact with search query if available
            'contacts' => Contact::search(
                keyword: request('search'),
                columns: ['name', 'username', 'phone', 'email']
            )
                // Paginator
                ->paginate(5, ['name', 'username', 'phone', 'profile'])
                // Handle if search used with pagination
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manipulate');
        // Showing Create view with sending genders data
        return view('contacts.create', [
          'genders' => ['Male', 'Female', 'Ask Me'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manipulate');
        // Validate the request
        $rules = [
          'name' => 'required|string|max:255',
          'username' => 'required|string|unique:contacts',
          'phone' => 'required|numeric',
          'email' => 'nullable|email',
          'profile' => 'nullable|image|file',
          'gender' => 'required|string'
        ];
        $datas = $request->validate($rules);
        // Save profile
        if($request->has('profile')) {
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        // Save data into database
        Contact::create($datas);
        // Redirect to Index with alert message
        return redirect()->route('contacts.index')
            ->with('message', $datas['name']. " was added.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Showing Show view with sending contact data
        return view('contacts.show', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        Gate::authorize('manipulate');
        // Showing Edit view with sending contact and genders data
        return view('contacts.edit', [
          'contact' => $contact,
          'genders' => ['Male', 'Female', 'Ask Me'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        Gate::authorize('manipulate');
        // Validate the request without username
        $rules = [
          'name' => 'required|string|max:255',
          'phone' => 'required|numeric',
          'email' => 'nullable|email',
          'profile' => 'nullable|image|file',
          'gender' => 'required|string'
        ];
        // Validate username if username changed
        if($request->username != $contact->username) {
            $rules['username'] = 'required|string|unique:contacts';
        };
        // Validate data
        $datas = $request->validate($rules);
        // Delete image when contact has profile and requested to delete profile
        if($contact->profile && $request->has('isDeleteImage')) {
            Storage::delete($contact->profile);
            $datas['profile'] = null;
        }
        // Replace profile when user update the profile or upload the profile
        if($request->has('profile')) {
            if($contact->profile) {
                Storage::delete($contact->profile);
                $datas['profile'] = null;
            }
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        // Update data
        $contact->update($datas);
        // Redirect to Show with message
        return redirect()->route('contacts.show', $contact->username)
            ->with('message', $datas['name']. " was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        Gate::authorize('manipulate');
        // Get name for message
        $name = $contact->name;
        // Delete profile if available
        if($contact->profile) {
            Storage::delete($contact->profile);
        }
        // Delete contact
        $contact->delete();
        // Redirect to Index with message
        return redirect()->route('contacts.index')
          ->with('message', "$name was deleted.");
    }
}
