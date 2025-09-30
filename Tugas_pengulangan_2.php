<?php

// --- 1. KONFIGURASI & DATA MASTER ---

// Menetapkan zona waktu untuk tanggal yang akurat
date_default_timezone_set('Asia/Jakarta');

// Konstanta untuk tarif pajak (PPN 11%)
define('TARIF_PAJAK', 0.11);

// Data Master Produk (mirip seperti data dari database)
// Menggunakan ID unik sebagai key untuk pencarian lebih cepat
$menu = [
    'CF-001' => ['nama' => 'Espresso',         'harga' => 22000, 'kategori' => 'Kopi', 'stok' => 50],
    'CF-002' => ['nama' => 'Latte',            'harga' => 28000, 'kategori' => 'Kopi', 'stok' => 45],
    'CF-003' => ['nama' => 'Cappuccino',       'harga' => 28000, 'kategori' => 'Kopi', 'stok' => 0], // Stok habis
    'CF-004' => ['nama' => 'Americano',        'harga' => 25000, 'kategori' => 'Kopi', 'stok' => 60],
    'FD-001' => ['nama' => 'Croissant',        'harga' => 18000, 'kategori' => 'Pastry', 'stok' => 30],
    'FD-002' => ['nama' => 'Donat Cokelat',    'harga' => 12000, 'kategori' => 'Pastry', 'stok' => 40],
];

// --- 2. SIMULASI PESANAN DARI PELANGGAN ---
// Key adalah ID Produk, Value adalah Kuantitas (jumlah yang dibeli)
$pesanan = [
    'CF-002' => 2,   // Pelanggan memesan 2 Latte
    'FD-001' => 1,   // 1 Croissant
    'CF-003' => 1,   // Mencoba memesan 1 Cappuccino (stok habis)
    'XX-999' => 1,   // Mencoba memesan item yang tidak ada di menu
];

// --- 3. KUMPULAN FUNGSI UNTUK LOGIKA BISNIS ---

/**
 * Memproses pesanan, memeriksa stok, dan menghitung subtotal.
 * @param array $pesanan - Array pesanan pelanggan (id => kuantitas).
 * @param array $menu - Array data master produk.
 * @return array - Mengembalikan array berisi item yang berhasil diproses, item yang gagal, dan subtotal.
 */
function memprosesPesanan(array $pesanan, array $menu): array
{
    $itemBerhasil = [];
    $itemGagal = [];
    $subtotal = 0;

    // PERULANGAN untuk setiap item dan kuantitas dalam pesanan
    foreach ($pesanan as $idProduk => $kuantitas) {
        // KONTROL: Periksa apakah produk ada di menu
        if (isset($menu[$idProduk])) {
            $produk = $menu[$idProduk];
            // KONTROL: Periksa apakah stok mencukupi
            if ($produk['stok'] >= $kuantitas) {
                $totalHargaItem = $produk['harga'] * $kuantitas;
                $subtotal += $totalHargaItem;
                $itemBerhasil[] = [
                    'nama' => $produk['nama'],
                    'kuantitas' => $kuantitas,
                    'harga_satuan' => $produk['harga'],
                    'total' => $totalHargaItem
                ];
            } else {
                $itemGagal[] = "Stok '" . $produk['nama'] . "' tidak mencukupi (tersisa: " . $produk['stok'] . ").";
            }
        } else {
            $itemGagal[] = "Produk dengan ID '" . $idProduk . "' tidak ditemukan di menu.";
        }
    }

    return [
        'berhasil' => $itemBerhasil,
        'gagal' => $itemGagal,
        'subtotal' => $subtotal
    ];
}

/**
 * Menghitung diskon, pajak, dan total akhir.
 * @param float $subtotal - Subtotal belanja.
 * @return array - Rincian perhitungan (diskon, pajak, total).
 */
function menghitungTotal(float $subtotal): array
{
    $persenDiskon = 0;
    // KONTROL: Logika penentuan diskon
    if ($subtotal >= 150000) {
        $persenDiskon = 20; // Diskon 20% untuk pembelian >= Rp 150.000
    } elseif ($subtotal >= 75000) {
        $persenDiskon = 10; // Diskon 10% untuk pembelian >= Rp 75.000
    }

    $nilaiDiskon = $subtotal * ($persenDiskon / 100);
    $subtotalSetelahDiskon = $subtotal - $nilaiDiskon;
    $nilaiPajak = $subtotalSetelahDiskon * TARIF_PAJAK;
    $totalAkhir = $subtotalSetelahDiskon + $nilaiPajak;

    return [
        'persen_diskon' => $persenDiskon,
        'nilai_diskon' => $nilaiDiskon,
        'pajak' => $nilaiPajak,
        'total_akhir' => $totalAkhir
    ];
}

/**
 * Mencetak struk dalam format yang rapi.
 * @param array $hasilProses - Hasil dari fungsi memprosesPesanan.
 * @param array $hasilTotal - Hasil dari fungsi menghitungTotal.
 * @param float $jumlahBayar - Uang yang dibayarkan pelanggan.
 */
function mencetakStruk(array $hasilProses, array $hasilTotal, float $jumlahBayar): void
{
    // Menggunakan tag <pre> agar spasi dan format teks tetap terjaga
    echo '<pre>';
    echo "========================================\n";
    echo "         <b>Barsua Coffee</b>\n";
    echo "    Jl. Saliwiryo No. 24, Bondowoso\n";
    echo "========================================\n";
    echo "Kasir    : Fawwas Dlogok\n";
    echo "Tanggal  : " . date('d-m-Y H:i:s') . "\n";
    echo "----------------------------------------\n";

    // PERULANGAN untuk menampilkan item yang berhasil dipesan
    foreach ($hasilProses['berhasil'] as $item) {
        // str_pad digunakan untuk merapikan teks
        echo str_pad($item['nama'], 20) . "\n";
        echo str_pad("  " . $item['kuantitas'] . " x " . number_format($item['harga_satuan']), 28, ' ', STR_PAD_RIGHT);
        echo str_pad("Rp" . number_format($item['total']), 12, ' ', STR_PAD_LEFT) . "\n";
    }

    echo "----------------------------------------\n";
    echo str_pad("Subtotal", 28) . str_pad("Rp" . number_format($hasilProses['subtotal']), 12, ' ', STR_PAD_LEFT) . "\n";
    
    // KONTROL: Hanya tampilkan diskon jika ada
    if ($hasilTotal['nilai_diskon'] > 0) {
        $labelDiskon = "Diskon (" . $hasilTotal['persen_diskon'] . "%)";
        echo str_pad($labelDiskon, 28) . str_pad("-Rp" . number_format($hasilTotal['nilai_diskon']), 12, ' ', STR_PAD_LEFT) . "\n";
    }

    echo str_pad("PPN (" . (TARIF_PAJAK * 100) . "%)", 28) . str_pad("Rp" . number_format($hasilTotal['pajak']), 12, ' ', STR_PAD_LEFT) . "\n";
    echo "========================================\n";
    echo "<b>" . str_pad("TOTAL", 28) . str_pad("Rp" . number_format($hasilTotal['total_akhir']), 12, ' ', STR_PAD_LEFT) . "</b>\n";
    echo "----------------------------------------\n";

    $kembalian = $jumlahBayar - $hasilTotal['total_akhir'];
    echo str_pad("Tunai", 28) . str_pad("Rp" . number_format($jumlahBayar), 12, ' ', STR_PAD_LEFT) . "\n";
    echo str_pad("Kembalian", 28) . str_pad("Rp" . number_format($kembalian), 12, ' ', STR_PAD_LEFT) . "\n\n";

    echo "     Terima Kasih Atas Kunjungan Anda\n";
    echo "========================================\n";

    // KONTROL: Tampilkan pesan error jika ada item yang gagal diproses
    if (!empty($hasilProses['gagal'])) {
        echo "\n<b>Pemberitahuan:</b>\n";
        // PERULANGAN untuk setiap pesan kegagalan
        foreach ($hasilProses['gagal'] as $pesan) {
            echo "- " . $pesan . "\n";
        }
    }
    echo '</pre>';
}


// --- 4. EKSEKUSI UTAMA ---

// Langkah 1: Proses pesanan yang masuk
$hasilProses = memprosesPesanan($pesanan, $menu);

// Langkah 2: Hitung diskon, pajak, dan total dari subtotal yang didapat
$hasilTotal = menghitungTotal($hasilProses['subtotal']);

// Langkah 3: Simulasi pelanggan membayar dengan uang tunai
$jumlahBayar = 100000;

// Langkah 4: Cetak struk akhir
mencetakStruk($hasilProses, $hasilTotal, $jumlahBayar);

?>