<?php
include_once '../core/Connection.php';

if (isset($_GET['id'])) {
    $mahoadon = $_GET['id'];
    $sql = "SELECT u.TenKhachHang, h.DiaChi, sp.TenSanPham, cthd.SoLuong, cthd.ThanhTien
            FROM user u
            JOIN hoadon h ON u.MaTaiKhoan = h.MaTaiKhoan
            JOIN chitiethoadon cthd ON h.MaHoaDon = cthd.MaHoaDon
            JOIN sanpham sp ON cthd.MaSanPham = sp.MaSanPham
            WHERE h.MaHoaDon = ?";
    $st = $pdo->prepare($sql);
    $st->execute([$mahoadon]);

    if ($st->rowCount()) {
        $hoadon = $st->fetchAll(PDO::FETCH_OBJ);

        require('fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', "A4");

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(60, 0, '', 0, 0);
        $pdf->Cell(59, 5, 'HOA DON BAN HANG', 0, 0);
        $pdf->Cell(59, 10, '', 0, 1);

        $pdf->SetFont('Arial', '', 11);
        foreach ($hoadon as $hd) {
            $pdf->Cell(71, 5, "Ten: ".$hd->TenKhachHang, 0, 0);
            $pdf->Cell(59, 5, '', 0, 0);
            $pdf->Cell(59, 10, '', 0, 1);

            $pdf->Cell(71, 5, "Dia chi: ".$hd->DiaChi, 0, 0);
            $pdf->Cell(59, 5, '', 0, 0);
            $pdf->Cell(59, 10, '', 0, 1);
            
            break;
        }

        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(10, 6, 'STT', 1, 0, 'C');
        $pdf->Cell(100, 6, 'Ten san pham', 1, 0, 'C');
        $pdf->Cell(20, 6, 'So luong', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Don gia', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Thanh tien', 1, 1, 'C');

        $stt = 1;
        $dg = 0;
        $sl = 0;
        $tt = 0;
        foreach ($hoadon as $hd) {
            $dg = $hd->ThanhTien / $hd->SoLuong;
            $sl += $hd->SoLuong;
            $tt += $hd->ThanhTien;
            $pdf->Cell(10, 6, $stt++, 1, 0, 'C');
            $pdf->Cell(100, 6, $hd->TenSanPham, 1, 0, 'L');
            $pdf->Cell(20, 6, $hd->SoLuong, 1, 0, 'C');
            $pdf->Cell(30, 6, number_format($dg, 0, ',', '.'), 1, 0, 'C');
            $pdf->Cell(30, 6, number_format($hd->ThanhTien, 0, ',', '.'), 1, 1, 'C');
        }

        $pdf->Cell(10, 6, '', 1, 0, 'C');
        $pdf->Cell(100, 6, 'Tong', 1, 0, 'C');
        $pdf->Cell(20, 6, $sl, 1, 0, 'C');
        $pdf->Cell(30, 6, '' ,1 , 0, 'C');
        $pdf->Cell(30, 6, number_format($tt, 0, ',', '.'), 1, 1, 'C');

        $pdf->Cell(10, 5, '', 0, 1);
        
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(8, 5, '', 0, 0);
        $pdf->Cell(71, 5, '', 0, 0);
        $pdf->Cell(60, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'Ngay '.date("d,").' Thang '.date("m,").' Nam 20'.date("y"), 0, 1);
        
        $pdf->Cell(10, 1, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(8, 5, '', 0, 0);
        $pdf->Cell(71, 5, 'Nguoi ban hang', 0, 0);
        $pdf->Cell(70, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'Nguoi mua hang', 0, 1);

        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(8, 5, '', 0, 0);
        $pdf->Cell(71, 5, '(Ky, ghi ro ho ten)', 0, 0);
        $pdf->Cell(70, 5, '', 0, 0);
        $pdf->Cell(59, 5, '(Ky, ghi ro ho ten)', 0, 1);

        $pdf->Output();
    }
}
?>
