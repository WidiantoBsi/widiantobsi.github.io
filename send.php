<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Include librari phpmailer
include('phpmailer/Exception.php');
include('phpmailer/PHPMailer.php');
include('phpmailer/SMTP.php');

		$nama = $_POST['Nama'];
		$NoHp = $_POST['NoHp'];

$email_pengirim = 'widilangit@gmail.com'; // Isikan dengan email pengirim
$nama_pengirim = $nama; // Isikan dengan nama pengirim
$email_penerima = $_POST['E-mail']; // Ambil email penerima dari inputan form
$subjek = 'Portfolio|'.$email_penerima; // Ambil subjek dari inputan form
$pesan = $_POST['Pesan']; // Ambil pesan dari inputan form
$attachment = $_FILES['attachment']['name']; // Ambil nama file yang di upload
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'widilangit@gmail.com'; // Email Pengirim
$mail->Password = 'qanrnuqrjqcqrgap'; // Isikan dengan Password email pengirim
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
// $mail->SMTPDebug = 2; // Aktifkan untuk melakukan debugging
$mail->setFrom($email_pengirim, $nama_pengirim);
$mail->addAddress($email_pengirim, ''); // Kirim ke alamat email yg di tuju
$mail->isHTML(true); // Aktifkan jika isi emailnya berupa html
// Load file content.php
ob_start();
include "content.php";
$content = ob_get_contents(); // Ambil isi file content.php dan masukan ke variabel $content
ob_end_clean();
$mail->Subject = $subjek;
$mail->Body = $content;
$mail->AddEmbeddedImage('assets/UBSI.png', 'UBSI', 'UBSI.png'); // Aktifkan jika ingin menampilkan gambar dalam email
if(empty($attachment)){ // Jika tanpa attachment
	$send = $mail->send();
    if($send){ // Jika Email berhasil dikirim
    	echo "<h1>Email berhasil dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
    }else{ // Jika Email gagal dikirim
    	echo "<h1>Email gagal dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
        // echo '<h1>ERROR<br /><small>Error while sending email: '.$mail->getError().'</small></h1>'; // Aktifkan untuk mengetahui error message
    }
}else{ // Jika dengan attachment
	$tmp = $_FILES['attachment']['tmp_name'];
	$size = $_FILES['attachment']['size'];
    if($size <= 25000000){ // Jika ukuran file <= 25 MB (25.000.000 bytes)
        $mail->addAttachment($tmp, $attachment); // Add file yang akan di kirim
        $send = $mail->send();
        if($send){ // Jika Email berhasil dikirim
        	echo "<h1>Email berhasil dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
        }else{ // Jika Email gagal dikirim
        	echo "<h1>Email gagal dikirim</h1><br /><a href='index.php'>Kembali ke Form</a>";
            // echo '<h1>ERROR<br /><small>Error while sending email: '.$mail->getError().'</small></h1>'; // Aktifkan untuk mengetahui error message
        }
    }else{ // Jika Ukuran file lebih dari 25 MB
    	echo "<h1>Ukuran file attachment maksimal 25 MB</h1><br /><a href='index.php'>Kembali ke Form</a>";
    }
}
?>