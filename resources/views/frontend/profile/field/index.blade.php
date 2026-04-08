@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Sekretariat & Bidang
@endsection

@push('css')
    <style>
        .field-title-main {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
            line-height: 1.2;
        }
        .field-title-sub {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--secondary);
            text-align: center;
            margin-bottom: 30px;
        }

        .field-card {
            background: #ffffff;
            border-radius: 6px;
            display: flex;
            align-items: stretch;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            margin-bottom: 8px;
        }
        .field-card-left {
            width: 400px;
            display: flex;
            align-items: stretch;
            overflow: hidden;
        }
        .field-card-photo {
            width: 45%;
            display: block;
        }
        .field-card-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .field-card-left-label {
            width: 60%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            text-align: center;
            font-size: .9rem;
            font-weight: 600;
        }

        .field-card-right {
            flex: 1;
            padding: 16px 24px;
        }
        .field-head-name {
            font-weight: 800;
            color: var(--primary);
            font-size: 1rem;
            text-transform: uppercase;
        }
        .field-head-nip,
        .field-head-golongan {
            font-size: .9rem;
            color: #555;
            margin-bottom: 0;
        }

        .field-members-wrapper {
            padding: 10px 0 18px 0;
        }
        .field-members-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }
        .field-member-card {
            background: #e9edf3;
            border-radius: 6px;
            padding: 8px 10px;
            font-size: .75rem;
            display: flex;
            align-items: stretch;
            gap: 8px;
        }
        .field-member-photo {
            width: 25%;
            flex-shrink: 0;
        }
        .field-member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 4px;
        }
        .field-member-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .field-member-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }
        .field-member-meta {
            color: #666;
            margin-bottom: 0;
            line-height: 1.2;
        }

        @media (max-width: 991.98px) {
            .field-members-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .field-card {
                flex-direction: column;
            }
            .field-card-left {
                width: 100%;
            }
            .field-card-left-label {
                width: 50%;
            }
        }

        @media (max-width: 575.98px) {
            .field-members-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-4">

        <h2 class="field-title-main">Sekretariat dan Bidang</h2>
        <h3 class="field-title-sub">DPMPTSP Kabupaten Katingan</h3>

        @foreach($bidangs as $bidang)
            @php
                $kepala  = $bidang->strukturOrganisasi->firstWhere('is_pejabat', 1);
                $anggota = $bidang->strukturOrganisasi->where('is_pejabat', 0);
            @endphp

            {{-- Kartu kepala bidang --}}
            <div class="field-card">
                <div class="field-card-left">
                    <div class="field-card-photo">
                        @if($kepala && $kepala->image)
                            <img src="{{ asset('storage/' . $kepala->image) }}" alt="{{ $kepala->name }}">
                        @endif
                    </div>
                    <div class="field-card-left-label">
                        {{ $bidang->name }}
                    </div>
                </div>
                <div class="field-card-right">
                    @if($kepala)
                        <p class="field-head-name mb-1">{{ $kepala->name }}</p>
                        <p class="field-head-nip mb-1">NIP. {{ $kepala->nip }}</p>
                        <p class="field-head-golongan mb-0">{{ $kepala->golongan }}</p>
                    @else
                        <p class="mb-0 text-muted">Belum ada data pejabat untuk bidang ini.</p>
                    @endif
                </div>
            </div>

            {{-- Anggota bidang --}}
            @if($anggota->count())
                <div class="field-members-wrapper mb-3">
                    <div class="field-members-grid">
                        @foreach($anggota as $member)
                            <div class="field-member-card">
                                <div class="field-member-photo">
                                    @if($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                                    @endif
                                </div>
                                <div class="field-member-body">
                                    <div class="field-member-name">{{ $member->name }}</div>
                                    @if($member->nip)
                                        <p class="field-member-meta mb-0">NIP. {{ $member->nip }}</p>
                                    @endif
                                    @if($member->golongan)
                                        <p class="field-member-meta mb-0">{{ $member->golongan }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>
@endsection

@push('scripts')
    <script>
        
    </script>
@endpush
