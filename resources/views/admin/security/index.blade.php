@extends('admin.layouts.app')

@section('title', 'Daftar IP Diblokir')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar IP Diblokir</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.security.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="ip_address" class="form-control" placeholder="Masukkan IP Address" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="reason" class="form-control" placeholder="Alasan (Opsional)">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Blokir IP</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>IP Address</th>
                        <th>Alasan</th>
                        <th>Tanggal Blokir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blocks as $block)
                        <tr>
                            <td>{{ $loop->iteration + $blocks->firstItem() - 1 }}</td>
                            <td>{{ $block->ip_address }}</td>
                            <td>{{ $block->reason }}</td>
                            <td>{{ $block->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.security.destroy', $block->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membuka blokir IP ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus Blokir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada IP yang diblokir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $blocks->links() }}
        </div>
    </div>
</div>
@endsection
