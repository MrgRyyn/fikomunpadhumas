<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Vote;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with mahasiswa and vote stats.
     */
    public function index()
    {
        $npmuser = Session::get('npm');
        // Cek Role
        $role = Mahasiswa::where('npm', $npmuser)->value('role');
        if ($role !== 'admin') {
            return redirect('vote')->with('error', 'Access denied. Admins only.');
        }
        
        // All students
        $mahasiswas = Mahasiswa::orderBy('npm')->get();

        // Vote counts per candidate (candidate_id may be 1 or 2)
        $voteCounts = Vote::selectRaw('candidate_id, COUNT(*) as total')
            ->groupBy('candidate_id')
            ->pluck('total', 'candidate_id')
            ->all();

        $totalVotes = array_sum($voteCounts);

        // List of raw votes (we can't map hashed voter_npm back to mahasiswa)
        $votes = Vote::orderByDesc('created_at')->get();

        // Prepare a plain array for JavaScript to avoid embedding PHP closures in Blade
        $mahasiswasForJs = $mahasiswas->map(function($m) {
            return [
                'id' => $m->id,
                'nim' => $m->npm,
                'nama' => $m->nama,
                'email' => $m->email,
                'sudah_vote' => $m->sudah_vote ? 'Sudah' : 'Belum',
                'pilihan' => Vote::where('voter_npm', $m->npm)->value('candidate_id') ?? '-'
            ];
        })->values()->toArray();

        return view('dashboard.admin', compact('mahasiswas', 'voteCounts', 'totalVotes', 'votes', 'mahasiswasForJs'));
    }
}
