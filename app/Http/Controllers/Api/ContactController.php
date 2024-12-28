<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $contacts = Contact::search(request('search'))->paginate(5, ['name', 'username', 'phone', 'profile'])->withQueryString();

        $message = '';
        if(!request('search')) {
            $message = 'Successfully fetched Contact resource with a total of 5 items on page '.request('page', 1) .'.';
        } else {
            $message = 'Successfully fetched Contact resource with '. request('search') . ' query and with a total of 5 items on page '. request('page', 1) . '.';
        }

        return response()->json([
            'message' => $message,
            'data' => $contacts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
          'name' => 'required|string|max:255',
          'username' => 'required|string|unique:contacts',
          'phone' => 'required|numeric',
          'email' => 'nullable|email',
          'profile' => 'nullable|image|file',
          'gender' => 'required|string'
        ];
        $datas = $request->validate($rules);
        return response()->json($request->all());
        if(!in_array($datas['gender'], ['Male', 'Female', 'Ask Me'])) {
            return response()->json([
                'message' => "You entered the wrong 'Gender' field. This field only accept 'Male', 'Female', and 'Ask Me'.",
            ], 400);
        }
        if($request->has('profile')) {
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        Contact::create($datas);
        return response()->json([
            'message' => "Successfully added $datas['name'] to Contact resource.",
            'data' => $datas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username): JsonResponse
    {
        $contact = Contact::where('username', $username)->first();
        if(!$contact) {
            return response()->json([
                'message' => "Data not found on Contact resource.",
            ], 404);
        }
        return response()->json([
            'message' => "Successfully fetched $contact->name on Contact resource.",
            'data' => $contact
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $username): JsonResponse
    {
        $contact = Contact::where('username', $username)->first();
        if(!$contact) {
            return response()->json([
                'message' => "Data not found on Contact resource.",
            ], 404);
        }
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
        }
        if($request->has('profile')) {
            if($contact->profile) {
                Storage::delete($contact->profile);
            }
            $datas['profile'] = $request->file('profile')->store('profile');
        }
        $contact->update($datas);
        return response()->json([
            'message' => "Successfully updated $contact->name on Contact resource.",
            'data' => $contact
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $username): JsonResponse
    {
        $contact = Contact::where('username', $username)->first();
        if(!$contact) {
            return response()->json([
                'message' => "Data not found on Contact resource.",
            ], 404);
        }
        $name = $contact->name;
        Storage::delete($contact->profile);
        $contact->delete();
        return response()->json([
            'message' => "Successfully deleted $contact->name on Contact resource.",
            'data' => $contact
        ], 204);
    }
}
