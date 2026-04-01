@extends('frontend.layouts.app')

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
            margin-bottom: 22px;
        }
        .field-card-left {
            width: 400px;
            display: flex;
            align-items: stretch;
            overflow: hidden;
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
            color: #0093d9;
            font-size: 1rem;
            text-transform: uppercase;
        }
        .field-head-nip,
        .field-head-golongan {
            font-size: .9rem;
            color: #555;
            margin-bottom: 0;
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

        /* Box keterangan peraturan bupati */
        .org-note-box {
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 1.3rem;
            line-height: 1.6;
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-4">

        <h2 class="field-title-main">Struktur Organisasi</h2>
        <h3 class="field-title-sub">DPMPTSP Kabupaten Katingan</h3>
        
        @foreach($bidangs as $bidang)
            @php
                $kepala = $bidang->strukturOrganisasi->first();
            @endphp

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
        @endforeach

        {{-- Box keterangan Peraturan Bupati --}}
        <div class="org-note-box">
            Berdasarkan Peraturan Bupati Katingan Nomor 38 Tahun 2022 tentang Kedudukan, 
            Susunan Organisasi, Tugas, Fungsi dan Tata Kerja Dinas Penanaman Modal dan 
            Pelayanan Terpadu Satu Pintu Kabupaten Katingan
        </div>

    </div>
@endsection

@push('scripts')
<script></script>
@endpush
