<?php

namespace App\Http\Controllers;

use App\Models\PermohonanInformasi;
use App\Models\PermohonanResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Helpers\GeneralHelper;

class LaporanPermohonanController extends Controller
{
    private function getUnitData()
    {
        return GeneralHelper::getUnitData();
    }

    public function index(Request $request)
    {
        $query = PermohonanInformasi::query()
            ->whereIn('privacy_status', ['Publik', 'Anonim'])
            ->whereIn('status_permohonan', ['selesai', 'ditolak']);

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                    ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('detail_informasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('privacy_status', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'nama_pemohon_asc':
                $query->orderBy('nama_pemohon', 'asc');
                break;
            case 'nama_pemohon_desc':
                $query->orderBy('nama_pemohon', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $permohonan = $query->paginate($perPage);

        return view('laporan.permohonan.index', compact('permohonan'));
    }

    public function show(PermohonanInformasi $permohonanInformasi)
    {
        $permohonan = $permohonanInformasi->load('user', 'responses.user');

        $isOwner = auth()->check() && auth()->id() == $permohonan->user_id;

        // Public view conditions
        $isPubliclyVisible = in_array($permohonan->privacy_status, ['Publik', 'Anonim']) &&
                             in_array($permohonan->status_permohonan, ['selesai', 'ditolak']);

        // A user can always see their own request, regardless of status.
        // Others can only see it if it meets the public visibility criteria.
        if (!$isOwner && !$isPubliclyVisible) {
            abort(404, 'Permohonan informasi tidak ditemukan atau tidak dapat diakses.');
        }
        
        $units = $this->getUnitData();

        return view('laporan.permohonan.show', compact('permohonan', 'units', 'isOwner'));
    }

    public function edit(PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan mengubah permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                            ->with('error', 'Permohonan tidak dapat diubah karena tidak lagi dalam status "pending".');
        }

        $units = $this->getUnitData();
        $permohonan = $permohonanInformasi; // for clarity in the view

        return view('laporan.permohonan.edit', compact('permohonan', 'units'));
    }

    public function update(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan mengubah permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                            ->with('error', 'Permohonan tidak dapat diubah karena tidak lagi dalam status "pending".');
        }

        $validatedData = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'nomor_telepon_pemohon' => 'required|string|max:20',
            'email_pemohon' => 'required|email|max:255',
            'detail_informasi' => 'required|string',
            'tujuan_penggunaan_informasi' => 'required|string',
            'cara_memperoleh_informasi' => 'required|array',
            'cara_memperoleh_informasi.*' => 'in:Melihat/Membaca/Mendengarkan,Mendapat Salinan Informasi',
            'cara_mendapatkan_salinan' => 'nullable|array',
            'cara_mendapatkan_salinan.*' => 'in:Mengambil,Kurir,Pos,Faksmail,E-Mail',
            'tempat_mendapatkan_salinan' => 'nullable|string|max:255', // unit_id from external API
            'privacy_status' => 'required|in:Publik,Anonim,Rahasia',
        ]);

        // Convert array fields to JSON strings
        $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
        $validatedData['cara_mendapatkan_salinan'] = isset($validatedData['cara_mendapatkan_salinan']) ? json_encode($validatedData['cara_mendapatkan_salinan']) : null;

        // Set tempat_mendapatkan_salinan to null if "Mengambil" is not selected or if it's empty
        if (!isset($request->cara_mendapatkan_salinan) || !in_array('Mengambil', $request->cara_mendapatkan_salinan) || empty($validatedData['tempat_mendapatkan_salinan'])) {
            $validatedData['tempat_mendapatkan_salinan'] = null;
        }

        $permohonanInformasi->update($validatedData);

        return redirect()->route('laporan.permohonan.saya')
                        ->with('success', 'Permohonan informasi berhasil diperbarui.');
    }

    public function destroy(PermohonanInformasi $permohonanInformasi)
    {
        // Authorize: Ensure the user is the owner and status is 'pending'
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan menghapus permohonan ini.');
        }
        if ($permohonanInformasi->status_permohonan != 'pending') {
            return redirect()->route('laporan.permohonan.saya')
                            ->with('error', 'Permohonan tidak dapat dihapus karena tidak lagi dalam status "pending".');
        }

        $permohonanInformasi->delete();

        return redirect()->route('laporan.permohonan.saya')
                        ->with('success', 'Permohonan informasi berhasil dihapus.');
    }

    public function myRequests(Request $request)
    {
        $query = PermohonanInformasi::query()->where('user_id', auth()->id());

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_pemohon', 'like', '%' . $searchTerm . '%')
                    ->orWhere('unique_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('detail_informasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status_permohonan', 'like', '%' . $searchTerm . '%')
                    ->orWhere('privacy_status', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'nama_pemohon_asc':
                $query->orderBy('nama_pemohon', 'asc');
                break;
            case 'nama_pemohon_desc':
                $query->orderBy('nama_pemohon', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $permohonan = $query->paginate($perPage);
                                   
        return view('laporan.permohonan.index', compact('permohonan'));
    }

    public function create()
    {
        $units = $this->getUnitData();
        return view('laporan.permohonan.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'pekerjaan' => 'required|string|max:255',
            'nomor_telepon_pemohon' => 'required|string|max:20',
            'email_pemohon' => 'required|email|max:255',
            'detail_informasi' => 'required|string',
            'tujuan_penggunaan_informasi' => 'required|string',
            'cara_memperoleh_informasi' => 'required|array',
            'cara_memperoleh_informasi.*' => 'in:Melihat/Membaca/Mendengarkan,Mendapat Salinan Informasi',
            'cara_mendapatkan_salinan' => 'nullable|array',
            'cara_mendapatkan_salinan.*' => 'in:Mengambil,Kurir,Pos,Faksmail,E-Mail',
            'tempat_mendapatkan_salinan' => 'nullable|string|max:255', // unit_id from external API
            'privacy_status' => 'required|in:Publik,Anonim,Rahasia',
        ]);

        // Convert array fields to JSON strings
        $validatedData['cara_memperoleh_informasi'] = json_encode($validatedData['cara_memperoleh_informasi']);
        $validatedData['cara_mendapatkan_salinan'] = isset($validatedData['cara_mendapatkan_salinan']) ? json_encode($validatedData['cara_mendapatkan_salinan']) : null;

        // Set tempat_mendapatkan_salinan to null if "Mengambil" is not selected or if it's empty
        if (!isset($request->cara_mendapatkan_salinan) || !in_array('Mengambil', $request->cara_mendapatkan_salinan) || empty($validatedData['tempat_mendapatkan_salinan'])) {
            $validatedData['tempat_mendapatkan_salinan'] = null;
        }

        // Add the authenticated user's ID
        $validatedData['user_id'] = auth()->id();

        // Tambahkan unique_code
        $uniqueCode = '';
        do {
            $uniqueCode = GeneralHelper::generateUniqueCode(5);
        } while (PermohonanInformasi::where('unique_code', $uniqueCode)->exists());

        $validatedData['unique_code'] = $uniqueCode; // Tambahkan unique_code ke data yang divalidasi

        PermohonanInformasi::create($validatedData);

        return redirect()->route('laporan.permohonan.saya')->with('success', 'Permohonan informasi berhasil dikirim.');
    }

    public function addResponse(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // 1. Authorize: Ensure the authenticated user is the owner of the request
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan menanggapi permohonan ini.');
        }

        // 2. Authorize: Ensure the status is 'diproses'
        if ($permohonanInformasi->status_permohonan != 'diproses') {
            return redirect()->back()->with('error', 'Anda hanya dapat menanggapi permohonan yang sedang dalam proses.');
        }

        // 3. Validate the request
        $validatedData = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // 4. Create the response
        PermohonanResponse::create([
            'permohonan_informasi_id' => $permohonanInformasi->id,
            'user_id' => auth()->id(), // The user (applicant) is the one responding
            'message' => $validatedData['message'],
            'file_path' => null, // Not allowing file uploads for this user response for now
            'link' => null,
        ]);

        // 5. Redirect back with a success message
        return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                         ->with('success', 'Tanggapan Anda berhasil dikirim.');
    }

    public function rate(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // 1. Authorize: Ensure the authenticated user is the owner of the request
        if (auth()->id() != $permohonanInformasi->user_id) {
            abort(403, 'Anda tidak diizinkan memberikan penilaian untuk permohonan ini.');
        }

        // 2. Authorize: Ensure there is a response
        if ($permohonanInformasi->responses->isEmpty()) {
            return redirect()->back()->with('error', 'Anda belum bisa memberikan penilaian karena belum ada tanggapan.');
        }

        // 3. Validate the request
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        $isFirstRating = is_null($permohonanInformasi->rating);

        // 4. Update the request
        $permohonanInformasi->rating = $validatedData['rating'];
        
        // Mark as 'selesai' only on the first rating
        if ($isFirstRating) {
            $permohonanInformasi->status_permohonan = 'selesai';
        }
        
        $permohonanInformasi->save();

        // 5. Redirect back with a success message
        $message = $isFirstRating 
            ? 'Terima kasih! Penilaian Anda telah kami terima dan permohonan ini telah ditandai sebagai selesai.'
            : 'Penilaian Anda berhasil diperbarui.';

        return redirect()->route('laporan.permohonan.show', $permohonanInformasi)
                         ->with('success', $message);
    }

    public function downloadPDF(Request $request, PermohonanInformasi $permohonanInformasi)
    {
        // Apply the same access control as the show method
        $isOwner = auth()->check() && auth()->id() == $permohonanInformasi->user_id;
        $isPubliclyVisible = in_array($permohonanInformasi->privacy_status, ['Publik', 'Anonim']) &&
                             in_array($permohonanInformasi->status_permohonan, ['selesai', 'ditolak']);

        if (!$isOwner && !$isPubliclyVisible) {
            abort(404, 'Permohonan informasi tidak ditemukan atau tidak dapat diakses.');
        }

        $ppidLogoBase64 = '';
        $logoPath = storage_path('app/public/logo/ppid.webp'); // Get absolute path
        
        if (file_exists($logoPath)) { // Use standard file_exists check
            $logoContent = file_get_contents($logoPath);
            $ppidLogoBase64 = 'data:image/webp;base64,' . base64_encode($logoContent);
        }

        $pdf = Pdf::loadView('laporan.permohonan.pdf', [
            'permohonan' => $permohonanInformasi,
            'ppidLogoBase64' => $ppidLogoBase64
        ]);
        
        $fileName = 'laporan-permohonan-' . $permohonanInformasi->unique_code . '.pdf';

        if ($request->query('action') === 'preview') {
            return $pdf->stream($fileName);
        }

        return $pdf->download($fileName);
    }
}