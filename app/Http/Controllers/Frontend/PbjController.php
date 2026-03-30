<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PbjQuestion;
use App\Models\PbjAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Informasi;
use Illuminate\Support\Facades\Storage;

class PbjController extends Controller
{
    public function index()
    {
        $questionsByYear = PbjQuestion::orderBy('year', 'desc')->get()->groupBy('year');
        
        return view('frontend.pages.pbj.index', compact('questionsByYear'));
    }

    public function show(int $year)
    {
        $questions = PbjQuestion::where('year', $year)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        if ($questions->isEmpty()) {
            abort(404);
        }

        $user = Auth::user();
        $canEdit = false;
        if ($user) {
            if ($user->isSuperAdmin()) {
                $canEdit = true;
            } elseif ($user->role === 'admin') {
                $apiUserData = User::getDataFromApi($user->nip);
                $userUnitId = $apiUserData['unit_id'] ?? null;
                $allowedUnitIds = ['730724', '730701'];
                if (in_array($userUnitId, $allowedUnitIds)) {
                    $canEdit = true;
                }
            }
        }
        
        $userId = $user ? $user->id : null;
        $existingAnswers = collect(); // Default empty collection

        if ($canEdit && $userId) { // Only fetch user's answers if they can edit
            $existingAnswers = PbjAnswer::with('informasi')->where('user_id', $userId)
                ->where('year', $year)
                ->get()
                ->keyBy('pbj_question_id'); // Key by question ID for easy lookup
        } else { // For public view, fetch all answers
            $existingAnswers = PbjAnswer::with('informasi')->where('year', $year)
                ->get()
                ->keyBy('pbj_question_id');
        }

        $categories = [];
        if ($canEdit) {
            $categories = [
                'Informasi Berkala',
                'Informasi Setiap Saat',
                'Informasi Serta Merta',
                'Informasi Dikecualikan',
            ];
        }

        $show_pedoman_modal = session('show_pedoman_modal', false);
        if ($show_pedoman_modal) {
            session()->forget('show_pedoman_modal');
        }

        return view('frontend.pages.pbj.show', compact('questions', 'year', 'existingAnswers', 'canEdit', 'categories', 'show_pedoman_modal'));
    }

    public function store(Request $request, int $year)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.url' => 'nullable|url',
            'answers.*.file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'answers.*.category' => 'nullable|string|in:Informasi Berkala,Informasi Setiap Saat,Informasi Serta Merta,Informasi Dikecualikan',
        ]);

        $userId = Auth::id();
        $user = Auth::user();

        foreach ($request->answers as $questionId => $answerData) {
            $url = $answerData['url'] ?? null;
            $file = $answerData['file'] ?? null;
            $category = $answerData['category'] ?? 'Informasi Tersedia Setiap Saat'; // Default to a safer category

            $answer = PbjAnswer::firstOrNew([
                'user_id' => $userId,
                'pbj_question_id' => $questionId,
                'year' => $year,
            ]);

            // Handle file upload
            $filePath = $answer->document_file_path; // Keep old file path if no new file
            if ($file) {
                // Delete old file if it exists
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $file->store('pbj_answers', 'public');
            } elseif (!$url) { // If no new file and no url, clear old file path
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = null;
            }


            // If there's a URL or a File, we need an Informasi record
            if ($url || $file) {
                $question = PbjQuestion::find($questionId);
                $apiUserData = User::getDataFromApi($user->nip);
                $userUnitId = $apiUserData['unit_id'] ?? null;

                $informasiData = [
                    'title' => $question->question,
                    'deskripsi' => 'Pengadaan Barang dan Jasa ' . $year,
                    'category' => $category,
                    'unit_id' => $userUnitId,
                    'jenis_dokumen' => 'Pengadaan Barang/Jasa',
                    'status' => 'aktif',
                    'tahun' => now()->year,
                    'tanggal_upload' => now(),
                    'user_id' => $user->id,
                    'published' => true,
                    'content' => $url ? '<a href="' . $url . '">' . $url . '</a>' : null,
                    'url' => $url,
                    'file' => $filePath,
                ];

                $informasi = Informasi::updateOrCreate(
                    ['id' => $answer->informasi_id],
                    $informasiData
                );
                $answer->informasi_id = $informasi->id;

            } else { // If BOTH url and file are absent
                // Delete the associated Informasi record if it exists
                if ($answer->informasi_id) {
                    Informasi::find($answer->informasi_id)->delete();
                    $answer->informasi_id = null;
                }
            }


            $answer->document_url = $url;
            $answer->document_file_path = $filePath;
            
            // If no url and no file, and it's an existing record, we delete it.
            if (!$url && !$file) {
                if ($answer->exists) {
                    $answer->delete();
                }
            } else {
                $answer->save();
            }
        }

        return redirect()->route('pbj.show', $year)->with('success', 'Jawaban Anda berhasil disimpan.');
    }
}