<?php 

use Core\Database;

$db = new Database();

// Pastikan konten tipe respons adalah JSON
header('Content-Type: application/json');

$qrcode_value = $_POST['qrcode_value'];

$response = [];

// Pastikan qrcode_value tidak kosong
if (!empty($qrcode_value)) {
    
    // Gunakan parameterized query untuk mencegah SQL injection
    $db->query = "SELECT * FROM gb_guests WHERE qrcode_value = '$qrcode_value'";
   
    $qrcode = $db->exec('single');

    // Periksa hasil
    if ($qrcode) {
        // Data ditemukan dalam tabel gb_guests
        
        // Tambahkan data ke gb_attendances
        try {
            // Masukkan data ke dalam tabel gb_attendances
            $db->insert('gb_attendances', [
                'guest_id' => $qrcode->id,
                'created_by' => $qrcode->id,
            ]);

            // Jika operasi berhasil, kirim respons keberhasilan
            $response['success'] = true;
            $response['message'] = "Halo selamat datang $qrcode->name";
        } catch (Exception $e) {
            // Tangani kesalahan saat menambahkan data ke database
            $response['success'] = false;
            $response['message'] = "Gagal menambahkan data ke gb_attendances: " . $e->getMessage();
        }
        
    } else {
        // qrcode_value tidak ditemukan di gb_guests
        $response['success'] = false;
        $response['message'] = "Data tidak terdaftar.";
    }
} else {
    // qrcode_value kosong
    $response['success'] = false;
    $response['message'] = "QR Code kosong.";
}

// Kirim respons JSON ke klien
echo json_encode($response);
?>
