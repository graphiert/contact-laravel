<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function create(Request $request) {
        return view('profile.api', [
            'tokens' => $request->user()->tokens
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|unique:personal_access_tokens'
        ]);

        $token = $request->user()->createToken($data['name']);

        return redirect()->route('token.create')->with('key', $token->plainTextToken);
    }

    public function destroy(Request $request, string $id) {
        $token = $request->user()->tokens()->where('id', $id)->first();
        $tokenName = $token->name;
        $token->delete();
        return redirect()->route('token.create')->with('message', $tokenName." successfully deleted.");
    }
}
