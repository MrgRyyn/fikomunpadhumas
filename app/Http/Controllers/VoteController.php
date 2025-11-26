<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vote;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class VoteController extends Controller
{
    public function storeVote(Request $request)
    {   
        // Note: some environments may not have a 'candidates' table (this project
        // uses a simple two-candidate UI). To avoid a DB validation error when
        // the candidates table is missing, validate candidate_id against the
        // known allowed ids. Adjust this if you later add a candidates table.
        $validator = Validator::make($request->all(), [
            'npm' => 'required|string',
            // allow only candidate IDs 1 and 2 (keep in sync with UI)
            'candidate_id' => 'required|integer|in:1,2',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input.'], 422);
        }
        $npm = $request->input('npm');
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
        $hashnpm = Hash::make($npm);
        Vote::create([
            'voter_npm' => $hashnpm,
            'candidate_id' => $candidateId,
        ]);
        return response()->json(['message' => 'Vote recorded successfully.'], 201);
    }
}
