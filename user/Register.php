<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />

    <!--  -->
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Layout/style_footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/info.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Logincss.css">
</head>

<body>
    <?php
    include_once '../core/Connection.php';
    session_start();
    include("layout/header.php");

    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        // Kiểm tra mật khẩu và xác nhận mật khẩu khớp nhau
        if ($password != $confirm_password) {
            $error_message = "Mật khẩu và xác nhận mật khẩu không khớp!";
        } else {
            // Kiểm tra xem tên tài khoản đã tồn tại hay chưa
            $sql = "SELECT * FROM user WHERE TenTaiKhoan = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $error_message = "Tên tài khoản đã tồn tại!";
            } else {
                // Thêm tài khoản mới vào cơ sở dữ liệu
                $sql = "INSERT INTO user (TenKhachHang, TenTaiKhoan, MatKhau, Email) VALUES (:fullname, :username, :password, :email)";
                $sql2 = "INSERT INTO giohang (MaTaiKhoan) VALUES (:matk)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':fullname', $fullname);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password); // Lưu mật khẩu nguyên thủy
                $stmt->bindParam(':email', $email);

                if ($stmt->execute()) {
                    $matk = $pdo->lastInsertId();
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(':matk', $matk);
                    $stmt2->execute();

                    $_SESSION['username'] = $username;
                    $_SESSION['tenkhachhang'] = $fullname;
                    $_SESSION['email'] = $email;
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Đã xảy ra lỗi khi đăng ký tài khoản!";
                }
            }
        }
    }
    ?>

    <div class="container login-container">
        <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
        <form id="form_register" method="post" action="Register.php">
            <p>Tên Tài Khoản: <span class="required">*</span></p>
            <input type="text" name="username" placeholder="Nhập tên tài khoản" required><br>
            <p>Tên Khách Hàng: <span class="required">*</span></p>
            <input type="text" name="fullname" placeholder="Nhập tên khách hàng" required><br>
            <p>Mật Khẩu: <span class="required">*</span></p>
            <input type="password" name="password" placeholder="Mật khẩu" required><br>
            <p>Xác Nhận Mật Khẩu: <span class="required">*</span></p>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required><br>
            <p>Email: <span class="required">*</span></p>
            <input type="email" name="email" placeholder="Nhập email" required><br>
            <input type="submit" class="btn-login" value="Đăng Ký">
            <?php if ($error_message != "") { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
        </form>
        <p class="sign_up">Bạn đã có tài khoản ? <a href="login.php">Đăng nhập tại đây.</a></p>
    </div>

    <?php
    include("layout/footer.php");
    ?>
</body>

</html>