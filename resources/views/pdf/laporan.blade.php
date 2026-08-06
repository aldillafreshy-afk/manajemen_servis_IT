<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Kerusakan - {{ $laporan->no_laporan }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin: 0;
            padding: 0;
        }
        .header p {
            color: #64748b;
            font-size: 12px;
            margin: 5px 0 0 0;
        }
        .info-laporan {
            background: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2563eb;
        }
        .info-laporan table {
            width: 100%;
            font-size: 12px;
        }
        .info-laporan td {
            padding: 4px 8px;
        }
        .info-laporan .label {
            font-weight: bold;
            color: #475569;
            width: 130px;
        }
        .info-laporan .value {
            color: #0f172a;
        }
        .section-title {
            background: #1e293b;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table th {
            background: #e2e8f0;
            color: #0f172a;
            font-weight: bold;
            padding: 8px 12px;
            text-align: left;
            font-size: 11px;
            border: 1px solid #cbd5e1;
        }
        table td {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            font-size: 11px;
        }
        table tr:nth-child(even) {
            background: #f8fafc;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-selesai { background: #dcfce7; color: #166534; }
        .status-diproses { background: #fef3c7; color: #92400e; }
        .status-menunggu { background: #dbeafe; color: #1e40af; }
        .status-ditugaskan { background: #e0e7ff; color: #3730a3; }
        .footer {
            margin-top: 30px;
            border-top: 2px solid #e2e8f0;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
        .signature {
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
        }
        .signature-box {
            text-align: center;
        }
        .signature-box .line {
            width: 150px;
            border-top: 1px solid #333;
            margin: 30px auto 5px auto;
        }
        .signature-box .label {
            font-size: 10px;
            color: #64748b;
        }
        .deskripsi-box {
            background: #f1f5f9;
            padding: 12px 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 3px solid #64748b;
        }
        .urgensi-tinggi {
            color: #dc2626;
            font-weight: bold;
        }
        .urgensi-sedang {
            color: #d97706;
            font-weight: bold;
        }
        .urgensi-rendah {
            color: #16a34a;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .mt-10 { margin-top: 10px; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>LAPORAN KERUSAKAN PERANGKAT</h1>
        <p>Sistem Manajemen Perbaikan Perangkat</p>
        <p style="font-size: 11px; color: #475569;">Dicetak pada: {{ $tanggal_cetak }}</p>
    </div>

    <!-- INFO LAPORAN -->
    <div class="info-laporan">
        <table>
            <tr>
                <td class="label">No. Laporan</td>
                <td class="value"><strong>{{ $laporan->no_laporan }}</strong></td>
                <td class="label">Tanggal Laporan</td>
                <td class="value">{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Pelapor</td>
                <td class="value">{{ $laporan->user->name ?? '-' }}</td>
                <td class="label">Status</td>
                <td class="value">
                    @php
                        $status = strtolower($laporan->status ?? '');
                        $statusClass = 'status-menunggu';
                        if ($status === 'selesai') $statusClass = 'status-selesai';
                        elseif ($status === 'diproses' || $status === 'ditugaskan') $statusClass = 'status-diproses';
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($laporan->status ?? 'Menunggu') }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">Perangkat</td>
                <td class="value">{{ $laporan->perangkat->nama_perangkat ?? '-' }}</td>
                <td class="label">Kode Perangkat</td>
                <td class="value">{{ $laporan->perangkat->kode_perangkat ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Ruangan</td>
                <td class="value">{{ $laporan->ruangan->nama_ruangan ?? '-' }}</td>
                <td class="label">Jenis Kerusakan</td>
                <td class="value">{{ $laporan->jenisKerusakan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tingkat Urgensi</td>
                <td class="value">
                    @php
                        $urgensi = strtolower($laporan->tingkat_urgensi ?? 'sedang');
                        $urgensiClass = 'urgensi-sedang';
                        if ($urgensi === 'tinggi') $urgensiClass = 'urgensi-tinggi';
                        elseif ($urgensi === 'rendah') $urgensiClass = 'urgensi-rendah';
                    @endphp
                    <span class="{{ $urgensiClass }}">{{ ucfirst($laporan->tingkat_urgensi ?? 'Sedang') }}</span>
                </td>
                <td class="label">Prioritas</td>
                <td class="value">
                    @if($urgensi === 'tinggi')
                        <span style="color: #dc2626; font-weight: bold;">⚠️ Prioritas Tinggi</span>
                    @elseif($urgensi === 'sedang')
                        <span style="color: #d97706; font-weight: bold;">⚡ Prioritas Sedang</span>
                    @else
                        <span style="color: #16a34a; font-weight: bold;">✓ Prioritas Rendah</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- DESKRIPSI KERUSAKAN -->
    <div class="section-title">📋 Deskripsi Kerusakan</div>
    <div class="deskripsi-box">
        {{ $laporan->deskripsi_kerusakan ?? 'Tidak ada deskripsi' }}
    </div>

    <!-- RIWAYAT STATUS -->
    @if(isset($riwayatStatus) && $riwayatStatus->count() > 0)
        <div class="section-title">📊 Riwayat Status</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Tanggal</th>
                    <th style="width: 25%;">Status Lama</th>
                    <th style="width: 25%;">Status Baru</th>
                    <th style="width: 20%;">Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatStatus as $riwayat)
                    <tr>
                        <td>{{ $riwayat->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ucfirst($riwayat->status_lama ?? '-') }}</td>
                        <td>{{ ucfirst($riwayat->status_baru ?? '-') }}</td>
                        <td>{{ $riwayat->user->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- TINDAKAN PERBAIKAN -->
@if($laporan->penugasanTeknisi->isNotEmpty())
    <div class="section-title">🔧 Tindakan Perbaikan</div>
    
    @foreach($laporan->penugasanTeknisi as $penugasan)
        @if($penugasan->tindakanPerbaikan->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Teknisi</th>
                        <th style="width: 25%;">Deskripsi Tindakan</th>
                        <th style="width: 15%;">Tanggal Selesai</th>
                        <th style="width: 15%;">Biaya</th>
                        <th style="width: 20%;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penugasan->tindakanPerbaikan as $index => $tindak)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $penugasan->teknisi->name ?? '-' }}</td>
                            <td>{{ $tindak->deskripsi_tindakan ?? '-' }}</td>
                            <td>{{ $tindak->tanggal_selesai ? \Carbon\Carbon::parse($tindak->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
                            <td class="text-right">Rp {{ number_format($tindak->biaya ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $tindak->catatan_teknisi ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
    
    <!-- Total Biaya -->
    @php
        $totalBiaya = 0;
        foreach($laporan->penugasanTeknisi as $penugasan) {
            $totalBiaya += $penugasan->tindakanPerbaikan->sum('biaya');
        }
    @endphp
    @if($totalBiaya > 0)
        <table>
            <tr style="font-weight: bold; background: #f1f5f9;">
                <td colspan="4" class="text-right">Total Biaya</td>
                <td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </table>
    @endif
@endif

{{-- <!-- PENUGASAN TEKNISI -->
@if($laporan->penugasanTeknisi->isNotEmpty())
    <div class="section-title">👨‍🔧 Penugasan Teknisi</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Teknisi</th>
                <th style="width: 20%;">Tanggal Penugasan</th>
                <th style="width: 25%;">Status</th>
                <th style="width: 25%;">Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan->penugasanTeknisi as $index => $pg)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pg->teknisi->name ?? '-' }}</td>
                    <td>{{ $pg->tanggal_penugasan ? \Carbon\Carbon::parse($pg->tanggal_penugasan)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @php
                            $status = strtolower($pg->status_penugasan ?? '');
                            $statusClass = 'status-menunggu';
                            if ($status === 'selesai') $statusClass = 'status-selesai';
                            elseif ($status === 'diproses' || $status === 'ditugaskan') $statusClass = 'status-diproses';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($pg->status_penugasan ?? 'Menunggu') }}</span>
                    </td>
                    <td>{{ $pg->catatan_admin ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif --}}

    <!-- TANDA TANGAN -->
    <div class="signature">
        <div class="signature-box">
            <div class="line"></div>
            <div class="label">Pelapor</div>
            <div style="font-size: 11px; margin-top: 5px;">{{ $laporan->user->name ?? '-' }}</div>
        </div>
        <div class="signature-box">
            <div class="line"></div>
            <div class="label">Teknisi</div>
            <div style="font-size: 11px; margin-top: 5px;">
                @if($laporan->penugasanTeknisi->isNotEmpty())
                    {{ $laporan->penugasanTeknisi->first()->teknisi->name ?? '-' }}
                @else
                    -
                @endif
            </div>
        </div>
        <div class="signature-box">
            <div class="line"></div>
            <div class="label">Admin</div>
            <div style="font-size: 11px; margin-top: 5px;">{{ $dicetak_oleh ?? '-' }}</div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dokumen ini dicetak dari Sistem Manajemen Perbaikan Perangkat</p>
        <p>Tanggal Cetak: {{ $tanggal_cetak }}</p>
        <p style="margin-top: 5px; color: #94a3b8; font-size: 9px;">
            Laporan ini adalah dokumen resmi dan memiliki kekuatan hukum
        </p>
    </div>

</body>
</html>