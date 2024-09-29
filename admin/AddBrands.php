<?php
ob_start();
include('includes/header.php');
?>
<div>
    <?php
    include_once '../core/Connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tenHang = $_POST['tenHang'];
        $logo = $_FILES['logo']['name'];

        $target_dir = "../public/images/logo/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);

        $sqlInsert = "INSERT INTO hang (TenHang, Logo) VALUES (:tenHang, :logo)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute([':tenHang' => $tenHang, ':logo' => $logo]);

        header("Location: ListBrands.php");
        exit();
    ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 400px; margin: 20px auto">
            <strong>Thành công!</strong> Thêm thương hiệu mới thành công.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: right; background: none; border: none;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

    <?php
    }
    ?>
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Thêm Thương Hiệu Mới</h1>
                        </div>
                        <form class="product" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="tenHang" class="form-label">Tên Thương Hiệu</label>
                                <input type="text" class="form-control form-control-user" name="tenHang" placeholder="Nhập tên thương hiệu" required>
                            </div>
                            <div class="form-group mt-4">
                                <label for="logo" class="form-label">Chọn Logo</label>
                                <div class="input-group">
                                    <input type="file" class="form-control form-control-user" name="logo" required>
                                    <span class="input-group-text">
                                        <i class="fa fa-upload"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block mt-5">
                                <i class="fa-solid fa-check-circle"></i> Hoàn Thành
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('includes/footer.php');
ob_end_flush();
?>
