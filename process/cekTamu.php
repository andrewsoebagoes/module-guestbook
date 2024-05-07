<?php 

use Core\Database;

$db = new Database();

header('Content-Type: application/json');

$event_id     = $_POST['event_id'];
$qrcode_value = $_POST['qrcode_value'];

$response = [];

if (!empty($qrcode_value)) {
    
    $db->query = "SELECT gb_guests.*, gb_events.start_at, gb_events.end_at 
    FROM gb_guests 
    JOIN gb_events ON gb_events.id = gb_guests.event_id
    WHERE gb_guests.qrcode_value = '$qrcode_value'
    AND gb_guests.event_id = '$event_id'";
   
    $guestData = $db->exec('single');

    if ($guestData) {
        $currentTime = date('Y-m-d H:i:s');
        if($currentTime >= $guestData->start_at && $currentTime <= $guestData->end_at){
            $db->query = "SELECT * FROM gb_attendances WHERE guest_id = '$guestData->id'";

            $attendance = $db->exec('single');

            if(!$attendance){
                $db->insert('gb_attendances', [
                    'guest_id' => $guestData->id,
                    'created_by' => auth()->id,
                    'created_at' => $currentTime
                ]);  
                $response['success'] = true;
                $response['message'] = "Halo selamat datang $guestData->name";
            }else{
                $response['suceess'] = false;
                $response['message'] = "Tamu $guestData->name sudah melakukan scan sebelumnya";
            }
        }else{
            $response['suceess'] = false;
            $response['message'] = "Tidak dapat melakukan scan di luar waktu acara";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Tamu tidak terdaftar.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "QR Code kosong.";
}
// Kirim respons JSON ke klien
echo json_encode($response);
?>
