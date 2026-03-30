@extends('backend.layouts.master')

@section('title', 'Detail App Log')

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
        }

        .card-header-modern {
            background: linear-gradient(135deg, #556ee6 0%, #364574 100%) !important;
            color: white !important;
            border-bottom: none;
            padding: 1.4rem 1.5rem !important;
        }

        .json-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            font-family: monospace;
            font-size: 0.9rem;
            white-space: pre-wrap;
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18 text-white">Detail Activity Log</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend.app-logs.index') }}">App Log</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h4 class="card-title mb-0 text-white">Informasi Log</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="180">Tanggal</th>
                                    <td>{{ $app_log->created_at->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>
                                        <strong>{{ $app_log->user->name ?? 'System' }}</strong><br>
                                        <small>{{ $app_log->user->email ?? '-' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $app_log->ip_address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="180">Module</th>
                                    <td><span class="badge bg-info">{{ $app_log->module_name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Aksi</th>
                                    <td><span
                                            class="badge bg-{{ $app_log->action == 'create' ? 'success' : ($app_log->action == 'update' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($app_log->action) }}
                                        </span></td>
                                </tr>
                                <tr>
                                    <th>Guard</th>
                                    <td>{{ $app_log->guard_name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('backend.app-logs.index') }}" class="btn btn-light">
                            ← Kembali ke Daftar Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Old Value -->
    @if ($app_log->old_value)
        <div class="row mt-3">
            <div class="col-12">
                <div class="card card-modern">
                    <div class="card-header card-header-modern">
                        <h4 class="card-title mb-0 text-white">Data Sebelumnya (Old Value)</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="json-box">
                            {{ json_encode($app_log->old_value, JSON_PRETTY_PRINT) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- New Value -->
    @if ($app_log->new_value)
        <div class="row mt-3">
            <div class="col-12">
                <div class="card card-modern">
                    <div class="card-header card-header-modern">
                        <h4 class="card-title mb-0 text-white">Data Baru (New Value)</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="json-box">
                            {{ json_encode($app_log->new_value, JSON_PRETTY_PRINT) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
