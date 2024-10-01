<?php
    include("includes/header.php");
    include_once '../core/Connection.php';

    if(isset($_GET['id'])) {
        $mahoadon = $_GET['id'];
        $sql = "SELECT user.Email FROM user JOIN hoadon ON user.MaTaiKhoan = hoadon.MaTaiKhoan WHERE hoadon.MaHoaDon = :mahoadon";
        $st = $pdo->prepare($sql);
        $st->bindParam(':mahoadon', $mahoadon);
        $st->execute();
    }
    
    if ($st->rowCount()) {
        $donhang = $st->fetch(PDO::FETCH_OBJ);
        
        if($donhang) {
            require("PHPMailer-master/src/PHPMailer.php");
            require("PHPMailer-master/src/SMTP.php");
            require("PHPMailer-master/src/Exception.php");

            $mail = new PHPMailer\PHPMailer\PHPMailer();

            $mail->IsSMTP();
            $mail->SMTPDebug = 2;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->IsHTML(true);
            $mail->Username = "maxmaxshopp@gmail.com";
            $mail->Password = "iyuu qojn bpxj bmlz";
            $mail->SetFrom("maxmaxshopp@gmail.com");
            $mail->Subject = "BTVSHOP";
            $mail->Body = "Đơn hàng của bạn đã được xác nhận. Cảm ơn quý khách đã đặt hàng.";
            $mail->AddAddress($donhang->Email);

            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message has been sent";
            }
        } else {
            echo "Không tìm thấy thông tin đơn hàng";
        }
    } else {
        echo "Không tìm thấy thông tin đơn hàng";
    }

    include("includes/footer.php");
?>
