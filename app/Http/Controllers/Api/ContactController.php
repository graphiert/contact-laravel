<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $contacts = Contact::search(request('search'), ['name', 'username', 'phone', 'email'])->paginate(5);

        $message = '';
        if(!request('search')) {
            $message = 'Successfully fetched Contact resource with a total of '. count($contacts) .' items on page '.request('page', 1) .'.';
        } else {
            $message = 'Successfully fetched Contact resource with '. request('search') . ' query and with a total of '. count($contacts) .' items on page '. request('page', 1) . '.';
        }

        return response()->json([
            'message' => $message,
            'data' => ContactResource::collection($contacts)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        Gate::authorize('manipulate');
        $rules = [
          'name' => 'required|string|max:255',
          'username' => 'required|string|unique:contacts',
          'phone' => 'required|numeric',
          'email' => 'nullable|email',
          'profile' => 'nullable|image|file',
          'gender' => 'required|string'
        ];
        $datas = $request->validate($rules);
        if(!in_array($datas['gender'], ['Male', 'Female', 'Ask Me'])) {
            return response()->json([
                'message' => "You entered the wrong 'Gender' field. This field only accept 'Male', 'Female', and 'Ask Me'.",
            ], 400);
        }
        if($request->has('profile')) {
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        $contact = Contact::create($datas);
        return response()->json([
            'message' => "Successfully added ".$datas['name']." to Contact resource.",
            'data' => new ContactResource($contact)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json([
            'message' => "Successfully fetched $contact->name on Contact resource.",
            'data' => new ContactResource($contact)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        Gate::authorize('manipulate');
        $rules = [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email',
            'profile' => 'nullable|image|file',
            'gender' => 'nullable|string'
        ];
        if($request->username != $contact->username) {
            $rules['username'] = 'nullable|string|unique:contacts';
        }
        $datas = $request->validate($rules);
        if($request->gender && !in_array($datas['gender'], ['Male', 'Female', 'Ask Me'])) {
            return response()->json([
                'message' => "You entered the wrong 'Gender' field. This field only accept 'Male', 'Female', and 'Ask Me'.",
            ], 400);
        }
        if($contact->profile && $request->has('isDeleteImage')) {
            Storage::delete($contact->profile);
            $datas['profile'] = null;
        }
        if($request->has('profile')) {
            if($contact->profile) {
                Storage::delete($contact->profile);
                $datas['profile'] = null;
            }
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        $contact->update($datas);
        return response()->json([
            'message' => "Successfully updated $contact->name on Contact resource.",
            'data' => new ContactResource($contact)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        Gate::authorize('manipulate');
        $name = $contact->name;
        if ($contact->profile) {
            Storage::delete($contact->profile);
        }
        $contact->delete();
        return response()->json([
            'message' => "Successfully deleted $contact->name on Contact resource.",
            'data' => null
        ], 200);
    }
}
