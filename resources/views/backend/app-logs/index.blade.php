@extends('backend.layouts.master')

@section('title', 'App Log')

@push('css')
    <style>
        .main-content {
            padding-top: 100px !important;
        }

        .page-content {
            margin-top: -4rem !important;
        }

        .page-title-box {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            padding: 1.8rem 1.5rem !important;
            border-radius: 10px;
        }

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            margin-bottom: 2rem !important;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .table-modern th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .log-badge {
            font-size: 0.82rem;
            padding: 0.35em 0.65em;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">App Log / Activity Log</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">App Log</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Daftar Activity Log</h4>
                </div>

                <div class="card-body p-4">
                    @if ($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-modern align-middle">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>User</th>
                                        <th>Module</th>
                                        <th>Aksi</th>
                                        <th>IP Address</th>
                                        <th width="100" class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $logs->firstItem() + $loop->index }}</td>
                                            <td>
                                                <small>{{ $log->created_at->format('d M Y') }}</small><br>
                                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $log->user->name ?? 'System' }}</strong><br>
                                                <small class="text-muted">{{ $log->user->email ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info log-badge">{{ $log->module_name }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $log->action === 'create' ? 'success' : ($log->action === 'update' ? 'warning' : 'danger') }} log-badge">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            </td>
                                            <td><small>{{ $log->ip_address }}</small></td>
                                            <td class="text-center">
                                                <a href="{{ route('backend.app-logs.show', $log) }}" class="btn btn-sm btn-primary">
                                                    <i class="mdi mdi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-center">
                            {{ $logs->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-history font-size-48 mb-3 d-block opacity-50"></i>
                            <h5>Belum ada data Activity Log</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @if (session('success'))
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
        });
    @endif
@endpush
