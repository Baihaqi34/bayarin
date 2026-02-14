<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body { margin: 0; padding: 0; font-family: monospace; }
        .receipt { width: 58mm; padding: 6mm; }
        .center { text-align: center; }
        .row { display: flex; justify-content: space-between; }
        .separator { border-top: 1px dashed #000; margin: 6px 0; }
        .title { font-size: 14px; font-weight: bold; }
        .small { font-size: 12px; }
        @media print {
            .actions { display: none; }
            .receipt { width: 58mm; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <div class="center title">Bayarin Pinet</div>
        <div class="center small">Struk Pembayaran</div>
        <div class="separator"></div>
        <div class="small">No: {{ $tagihan->id }}</div>
        <div class="small">Tanggal: {{ \Carbon\Carbon::parse($tagihan->dibayar_at ?? now())->format('Y-m-d H:i') }}</div>
        <div class="separator"></div>
        <div class="small">Pelanggan: {{ $pelanggan->nama ?? '-' }}</div>
        <div class="small">Nomor: {{ $pelanggan->nomor ?? '-' }}</div>
        <div class="small">Periode: {{ \Carbon\Carbon::parse($tagihan->periode)->format('Y-m') }}</div>
        <div class="small">Jatuh Tempo: {{ $tagihan->jatuh_tempo }}</div>
        <div class="separator"></div>
        <div class="row small">
            <div>Tagihan</div>
            <div>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</div>
        </div>
        <div class="row small">
            <div>Status</div>
            <div>{{ $tagihan->status }}</div>
        </div>
        <div class="separator"></div>
        <div class="center small">Terima kasih</div>
    </div>
    <div class="actions center" style="margin-top:10px;">
        <a href="{{ route('tagihan.index') }}">Kembali</a>
    </div>
</body>
</html>
