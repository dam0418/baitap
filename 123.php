<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "đàm"; // Đảm bảo tên CSDL 'đàm' là chính xác và tồn tại

// Kết nối đến MySQL và chọn CSDL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tạo bảng `my_contacts` nếu chưa tồn tại
$createTableSql = "CREATE TABLE IF NOT EXISTS my_contacts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    full_names VARCHAR(255) NOT NULL,
    gender VARCHAR(6) NOT NULL,
    contact_no VARCHAR(75) NOT NULL,
    email VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;";

// Thực thi câu lệnh tạo bảng
if ($conn->query($createTableSql) === TRUE) {
    echo "Table my_contacts created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Thêm dữ liệu vào bảng
$insertSql = "INSERT INTO my_contacts (
    full_names, gender, contact_no, email, city, country
) VALUES
    ('Faker', 'Male', '111', 'Faker@t1.com', 'Seoul', 'Korea'),
    ('Minjeong', 'Female', '123', 'winter0101@aespa.com', 'Busan', 'Korea'),
    ('Loverrukk', 'Female', '783', 'Lovegmm@milklove.com', 'Rome', 'Italy')";

// Thực thi câu lệnh thêm dữ liệu
if ($conn->query($insertSql) === TRUE) {
    echo "Data inserted successfully.<br>";
} else {
    echo "Error inserting data: " . $conn->error . "<br>";
}

// Đóng kết nối
$conn->close();
?>
