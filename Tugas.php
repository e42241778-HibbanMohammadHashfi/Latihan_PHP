<?php
echo "<h3>Tugas 1</h3>";
// Tugas 1: String angka bisa dihitung karena PHP otomatis konversi tipe data
$a = "10";
$b = "20";
$hasil = $a + $b;
echo "Hasil penjumlahan string angka: $a + $b = $hasil <br>";
echo "PHP otomatis mengkonversi string yang berisi angka menjadi integer.<br><br>";

echo "<h3>Tugas 2</h3>";
// Tugas 2: Perbedaan / dan %
$x = 10;
$y = 3;
echo "$x / $y = " . ($x / $y) . " (hasil bagi) <br>";
echo "$x % $y = " . ($x % $y) . " (sisa bagi/modulo) <br><br>";

echo "<h3>Tugas 3</h3>";
// Tugas 3: Menggabungkan string tugas1 dan tugas2 menjadi 9080
$tugas1 = 90;
$tugas2 = 80;

// penjumlahan biasa
$jumlah = $tugas1 + $tugas2; 
echo "Penjumlahan biasa: $tugas1 + $tugas2 = $jumlah <br>";

// penggabungan string
$gabung = $tugas1 . $tugas2; 
echo "Hasil gabungan string (concatenate): " . $gabung . "<br>";
?>
