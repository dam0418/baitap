<?php
const DB_TYPE = "mysql";
const DB_HOST = "localhost";
const DB_NAME = "chovy";
const USER_NAME = "root";
const USER_PASSWORD = "";

try {
    $connection = new PDO("$DB_TYPE:host=$DB_HOST;dbname=$DB_NAME", USER_NAME, USER_PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    $connection->exec($sql);
    echo "Cơ sở dữ liệu đã được tạo (nếu chưa tồn tại).<br>";

    $connection->exec("USE " . DB_NAME);

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL
    )";
    $connection->exec($sql);
    echo "Bảng 'users' đã được tạo (nếu chưa tồn tại).<br>";
    $action = isset($_GET['action']) ? $_GET['action'] : 'display';
//1. Thêm 
    switch ($action) {
        case 'add_multiple':
            $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
            $stmt = $connection->prepare($sql);
            $users = [
                ['name' => 'Jihoon', 'email' => 'jihoon@geng.com'],
                ['name' => 'Aespa', 'email' => 'aespa@smtown.com'],
                ['name' => 'Mark', 'email' => 'nctdream@sm.com'],
                ['name' => 'Lisa', 'email' => 'lisa@blackpink.com'],
                ['name' => 'Tom White', 'email' => 'tom.white@gmail.com'],
            ];
            foreach ($users as $user) {
                $stmt->bindParam(':name', $user['name']);
                $stmt->bindParam(':email', $user['email']);
                $stmt->execute();
            }
            echo "Dữ liệu đã được thêm thành công.<br>";
            break;

        // 2. Cập nhật dữ liệu
        case 'update':
            $sql = "UPDATE users SET email = :email WHERE id = :id";
            $stmt = $connection->prepare($sql);

            $id = 1;
            $newEmail = "newemail@example.com";

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':email', $newEmail);
            $stmt->execute();

            echo "Dữ liệu đã được cập nhật thành công.<br>";
            break;

        // 3. Xóa dữ liệu
        case 'delete':
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $connection->prepare($sql);

            $id = 1;

            $stmt->bindParam(':id', $id);
            $stmt->execute();

            echo "Dữ liệu đã được xoá thành công.<br>";
            break;

        //4. Hiển thị dữ liệu
        case 'display':
        default:
            $sql = "SELECT * FROM users";
            $stmt = $connection->prepare($sql);

            $stmt->execute();

            // Lấy tất cả kết quả dưới dạng mảng liên kết
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                echo "ID: " . $row['id'] . "<br>";
                echo "Tên: " . $row['name'] . "<br>";
                echo "Email: " . $row['email'] . "<br><br>";
            }
            break;
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>