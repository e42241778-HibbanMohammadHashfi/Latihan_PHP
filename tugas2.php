<?php
// nama file: kondisi_login.php
// contoh input sederhana lewat querystring: ?user=andi&pass=123

$user = isset($_GET['user']) ? $_GET['user'] : '';
$pass = isset($_GET['pass']) ? $_GET['pass'] : '';

$correctUser = 'andi';
$correctPass = '123';

// IF - ELSE biasa
echo "<h3>Contoh IF - ELSE</h3>";
if ($user == $correctUser && $pass == $correctPass) {
    echo "Selamat datang, $user! Anda berhasil login.<br>";
} else {
    echo "Login gagal. Periksa username / password Anda.<br>";
}

// nested IF (contoh tambahan)
echo "<h3>Contoh Nested IF</h3>";
if ($user != '') {
    if ($user == $correctUser) {
        echo "Username ditemukan. ";
        if ($pass == $correctPass) {
            echo "Password cocok. Akses diberikan.<br>";
        } else {
            echo "Password salah.<br>";
        }
    } else {
        echo "Username tidak ditemukan.<br>";
    }
} else {
    echo "Silakan isi parameter ?user=...&pass=... pada URL.<br>";
}

// ternary operator (singkat)
echo "<h3>Ternary</h3>";
$greeting = ($user == $correctUser) ? "Halo $user" : "Halo tamu";
echo $greeting . "<br>";
?>


<?php
// nama file: switch_menu.php
// akses contoh: ?kode=A

$kode = isset($_GET['kode']) ? strtoupper($_GET['kode']) : '';

echo "<h3>Contoh SWITCH</h3>";
switch ($kode) {
    case 'A':
        echo "Menu: Nasi Goreng - Rp15.000";
        break;
    case 'B':
        echo "Menu: Mie Ayam - Rp13.000";
        break;
    case 'C':
        echo "Menu: Ayam Geprek - Rp17.000";
        break;
    case 'D':
        echo "Menu: Es Teh - Rp5.000";
        break;
    default:
        echo "Kode menu tidak tersedia. Gunakan ?kode=A/B/C/D";
}
?>

<?php
// nama file: kontrol_ulang.php

echo "<h2>CONTOH IF ELSE</h2>";
$nilai = 90;
if ($nilai > 80) {
    echo "Selamat Anda mendapat grade A <br>";
} else {
    echo "Maaf Anda belum dapat grade A <br>";
}

echo "<h2>CONTOH SWITCH</h2>";
switch ($nilai) {
    case 100:
        echo "Nilai yang dipilih 100 <br>";
        break;
    case 90:
        echo "Nilai yang dipilih 90 <br>";
        break;
    default:
        echo "Nilai lain: $nilai <br>";
}

echo "<h2>CONTOH FOR</h2>";
for ($i = 1; $i <= 5; $i++) {
    echo "Looping FOR ke : " . $i . "<br>";
}

echo "<h2>CONTOH WHILE</h2>";
$j = 1;
while ($j <= 5) {
    echo "Looping While ke : " . $j . "<br>";
    $j++;
}

echo "<h2>CONTOH DO-WHILE</h2>";
$k = 0;
do {
    echo "Do-While iterasi : " . $k . "<br>";
    $k++;
} while ($k < 3);

echo "<h2>CONTOH FOREACH</h2>";
$buah = array("apel", "pisang", "jeruk");
foreach ($buah as $key => $val) {
    echo ($key+1) . ". " . $val . "<br>";
}
?>

<?php
// nama file: perulangan_100_1000.php

echo "<h2>Angka dari 100 sampai 1000</h2>";
for ($n = 100; $n <= 1000; $n++) {
    echo $n;
    if ($n < 1000) echo ", ";
    // untuk readability, newline setiap 20 angka
    if (($n - 99) % 20 == 0) echo "<br>";
}
?>

<?php
// nama file: fungsi_max_dan_tanggal.php

// Fungsi menentukan bilangan terbesar dari 2 angka
function max2($a, $b) {
    return ($a >= $b) ? $a : $b;
}

$a = 100;
$b = 150;
echo "<h3>Perbandingan $a dan $b</h3>";
echo "Nilai terbesar adalah: " . max2($a, $b) . "<br>";

// Tampilkan tanggal menggunakan getdate()
$now = getdate();
echo "<h3>Tanggal (getdate())</h3>";
// contoh format: dd-mm-yyyy
echo sprintf("%02d-%02d-%04d<br>", $now['mday'], $now['mon'], $now['year']);

// Tampilkan dengan date('d-F-Y')
echo "<h3>Tanggal (date)</h3>";
echo date('d-F-Y') . "<br>";
?>
