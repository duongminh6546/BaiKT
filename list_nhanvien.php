<?php
require_once ('entities/nhanvien.class.php');
include_once ('header.php');

// Số lượng nhân viên trên mỗi trang
$soLuongNhanVienTrenTrang = 5;

// Lấy danh sách tất cả nhân viên
$nhanviens = NHANVIEN::list_nhanvien();

// Tính tổng số lượng nhân viên
$tongSoNhanVien = count($nhanviens);

// Tính tổng số lượng trang
$tongSoTrang = ceil($tongSoNhanVien / $soLuongNhanVienTrenTrang);

// Kiểm tra trang hiện tại
$trangHienTai = isset($_GET['page']) ? $_GET['page'] : 1;

// Xác định vị trí bắt đầu và kết thúc của danh sách nhân viên trên trang hiện tại
$viTriBatDau = ($trangHienTai - 1) * $soLuongNhanVienTrenTrang;
$viTriKetThuc = min($viTriBatDau + $soLuongNhanVienTrenTrang, $tongSoNhanVien);

echo "<table>";
echo "<tr><th>Mã nhân viên</th><th>Tên nhân viên</th><th>Phái</th><th>Nơi sinh</th><th>Mã phòng</th><th>Lương</th><th>Thao tác</th></tr>";

for ($i = $viTriBatDau; $i < $viTriKetThuc; $i++) {
    $item = $nhanviens[$i];
    echo "<tr>";
    echo "<td>" . $item["Ma_NV"] . "</td>";
    echo "<td>" . $item["Ten_NV"] . "</td>";
    echo "<td>";

    // Kiểm tra giá trị của phái từ dữ liệu thực của từng nhân viên
    if ($item["Phai"] == 'Nam') {
        echo "<img src='man.png' width='50' height='50' />";
    } else {
        echo "<img src='women.png' width='50' height='50' />";
    }

    echo "</td>";
    echo "<td>" . $item["Noi_Sinh"] . "</td>";
    echo "<td>" . $item["Ma_Phong"] . "</td>";
    echo "<td>" . $item["Luong"] . "</td>";

    // Thêm nút xóa
    echo "<td><form method='post' action='xoa_nhanvien.php'>";
    echo "<input type='hidden' name='maNV' value='" . $item["Ma_NV"] . "' />";
    echo "<input type='submit' name='xoaNV' value='Xóa' />";
    echo "</form></td>";

    echo "</tr>";
}

echo "</table>";

// Hiển thị phân trang
echo "<div>";
for ($page = 1; $page <= $tongSoTrang; $page++) {
    echo "<a href='?page=$page'>$page</a> ";
}
echo "</div>";

include_once ('footer.php');
?>