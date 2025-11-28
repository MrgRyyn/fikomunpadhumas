<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vote;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function storeVote(Request $request)
    {
        // Require the user to be authenticated and derive npm from Auth user
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // allow only candidate IDs 1 and 2 (keep in sync with UI)
        $validator = Validator::make($request->all(), [
            'candidate_id' => 'required|integer|in:1,2',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input.'], 422);
        }

        $npm = $user->npm;
        $candidateId = $request->input('candidate_id');

        $mahasiswa = Mahasiswa::where('npm', $npm)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found.'], 404);
        }

        // Prevent double-voting at the server level as well
        if ((int) $mahasiswa->sudah_vote === 1) {
            return response()->json(['message' => 'Mahasiswa sudah melakukan vote sebelumnya.'], 403);
        }

        $mahasiswa->sudah_vote = 1;
        $mahasiswa->save();
        Vote::create([
            'voter_npm' => $npm,
            'candidate_id' => $candidateId,
        ]);
        return response()->json(['message' => 'Vote recorded successfully.'], 201);
    }
}
