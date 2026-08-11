<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Laporan Kerusakan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 15px;
            position: relative;
            min-height: 100vh;
        }

        .content {
            padding-bottom: 180px; /* Beri ruang untuk tanda tangan */
        }
        
        /* ===== KOP SURAT - FULL HEADER IMAGE ===== */
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px double #1a56db;
            padding-bottom: 10px;
        }
        
        .kop-surat .header-image {
            width: 100%;
            max-width: 100%;
            height: auto;
        }
        
        .kop-surat .header-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* ===== JUDUL LAPORAN ===== */
        .judul-laporan {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1a56db;
        }
        
        .periode {
            text-align: center;
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 10px;
        }
        
        /* ===== STATISTIK - MENGGUNAKAN TABLE ===== */
        .statistik-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }
        
        .statistik-table td {
            text-align: center;
            padding: 8px 10px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            width: 25%;
        }
        
        .statistik-table .number {
            font-size: 20px;
            font-weight: bold;
        }
        
        .statistik-table .label {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }
        
        .stat-blue .number { color: #1a56db; }
        .stat-green .number { color: #059669; }
        .stat-yellow .number { color: #d97706; }
        .stat-gray .number { color: #6b7280; }
        
        /* ===== TABEL DATA ===== */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            margin-top: 10px;
        }
        
        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 4px 5px;
            text-align: left;
            border: 1px solid #1a56db;
            font-weight: bold;
            font-size: 7px;
        }
        
        table.data-table td {
            padding: 3px 5px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            font-size: 7px;
        }
        
        
        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 6px;
            font-weight: bold;
        }
        
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-diproses { background: #dbeafe; color: #1e40af; }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-ditugaskan { background: #e0e7ff; color: #3730a3; }
        
        /* ===== TANDA TANGAN - POSISI ABSOLUT DI BAWAH ===== */
        .ttd-wrapper {
            position: absolute;
            bottom: 50px;
            left: 15px;
            right: 15px;
            width: calc(100% - 30px);
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .ttd-table td {
            text-align: center;
            padding: 15px 30px; /* Perbesar padding */
            width: 50%;
            vertical-align: bottom;
        }

        /* Garis Tanda Tangan - Lebih Lebar */
        .ttd-table .line {
            width: 200px; /* Perbesar dari 180px */
            border-top: 1.5px solid #333;
            margin: 30px auto 8px auto;
        }

        /* Nama - Lebih Besar */
        .ttd-table .nama-ttd {
            font-weight: bold;
            font-size: 13px; /* Perbesar dari 11px */
            margin-top: 5px;
        }

        /* NIP */
        .ttd-table .nip-ttd {
            font-size: 9px; /* Perbesar dari 8px */
            color: #6b7280;
            margin-top: 2px;
        }

        /* Label / Jabatan */
        .ttd-table .label-ttd {
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 5px;
        }

        .ttd-table .jabatan-ttd {
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Tanggal di sisi kanan */
        .ttd-table .tanggal-ttd {
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 5px;
        }

        /* ===== FOOTER - POSISI ABSOLUT ===== */
        .footer {
            position: absolute;
            bottom: 10px;
            left: 15px;
            right: 15px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            text-align: center;
            font-size: 8px;
            color: #9ca3af;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .mt-10 { margin-top: 10px; }
        .mb-10 { margin-bottom: 10px; }
        .uppercase { text-transform: uppercase; }
    </style>
</head>
<body>

    <!-- CONTENT WRAPPER -->
    <div class="content">
        
        <!-- KOP SURAT -->
        <div class="kop-surat">
            <div class="header-image">
                <img src="{{ public_path('images/kopHeader.png') }}" alt="Kop Surat">
            </div>
        </div>

        <!-- JUDUL LAPORAN -->
        <div class="judul-laporan">REKAP LAPORAN KERUSAKAN PERANGKAT</div>
        <div class="periode">
            Periode: {{ $periode ?? 'Semua Periode' }}
            <br>Dicetak pada: {{ $tanggal_cetak }}
        </div>

        <!-- STATISTIK -->
        <table class="statistik-table">
            <tr>
                <td class="stat-blue"><div class="number">{{ $totalLaporan ?? 0 }}</div><div class="label">Total Laporan</div></td>
                <td class="stat-green"><div class="number">{{ $totalSelesai ?? 0 }}</div><div class="label">Selesai</div></td>
                <td class="stat-yellow"><div class="number">{{ $totalDiproses ?? 0 }}</div><div class="label">Diproses</div></td>
                <td class="stat-gray"><div class="number">{{ $totalMenunggu ?? 0 }}</div><div class="label">Menunggu</div></td>
            </tr>
        </table>

    <!-- ========================================================== -->
    <!-- TABEL DATA                                                 -->
    <!-- ========================================================== -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 10%;">No. Laporan</th>
                <th style="width: 12%;">Pelapor</th>
                <th style="width: 14%;">Perangkat</th>
                <th style="width: 10%;">Ruangan</th>
                <th style="width: 12%;">Jenis Kerusakan</th>
                <th style="width: 9%; text-align: center;">Urgensi</th>
                <th style="width: 9%; text-align: center;">Tanggal</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans ?? [] as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->no_laporan ?? 'LP-'.$item->id }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->perangkat->nama_perangkat ?? '-' }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->jenisKerusakan->nama_kerusakan ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $urgensi = strtolower($item->tingkat_urgensi ?? 'rendah');
                            $color = $urgensi == 'tinggi' ? '#dc2626' : ($urgensi == 'sedang' ? '#d97706' : '#16a34a');
                        @endphp
                        <span style="color: {{ $color }}; font-weight: bold; font-size: 7px;">
                            {{ ucfirst($item->tingkat_urgensi ?? 'Rendah') }}
                        </span>
                    </td>
                    <td class="text-center">{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>
                    <td class="text-center">
                        @php
                            $status = strtolower($item->status ?? 'menunggu');
                            $class = 'status-menunggu';
                            if ($status == 'selesai') $class = 'status-selesai';
                            elseif ($status == 'diproses' || $status == 'ditugaskan') $class = 'status-diproses';
                        @endphp
                        <span class="status-badge {{ $class }}">{{ ucfirst($item->status ?? 'Menunggu') }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #9ca3af;">
                        Tidak ada data laporan untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <!-- ========================================================== -->
    <!-- TANDA TANGAN - POSISI ABSOLUT DI BAWAH                     -->
    <!-- ========================================================== -->
    <div class="ttd-wrapper">
            <table class="ttd-table">
        <tr>
            <!-- KIRI: Kepala Sekolah -->
            <td style="padding-right: 40px;">
                <div class="label-ttd">Mengetahui,</div>
                <div class="jabatan-ttd">Kepala SMK Negeri 2 Padang Panjang</div><br><br><br>
                <div class="line"></div>
                <div class="nama-ttd">Drs. H. Zulkarnain, M.Pd</div>
                <div class="nip-ttd">NIP. 19651231 199003 1 012</div>
            </td>
            
            <!-- KANAN: Admin / Petugas -->
            <td style="padding-left: 40px;">
                <div class="tanggal-ttd">Padang Panjang, {{ now()->format('d F Y') }}</div>
                <div class="jabatan-ttd">Admin / Petugas</div><br><br><br>
                <div class="line"></div>
                <div class="nama-ttd">{{ $dicetak_oleh ?? '-' }}</div>
                <div class="nip-ttd">NIP. {{ Auth::user()->nip ?? '-' }}</div>
            </td>
        </tr>
    </table>

        <!-- FOOTER -->
        <div class="footer">
            <p>Dokumen ini dicetak dari Sistem Informasi Manajemen Perbaikan Perangkat SMK Negeri 2 Padang Panjang</p>
            <p>Dicetak pada: {{ $tanggal_cetak }}</p>
        </div>
    </div>

</body>
</html>