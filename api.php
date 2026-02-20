<?php
// تنظیمات برای اجازه دسترسی ری‌اکت به این فایل (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$file = 'users.json';

// دریافت دیتای ارسالی از ری‌اکت
$json_data = file_get_contents('php://input');
$new_user = json_decode($json_data, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $new_user) {
    // خواندن دیتای قبلی
    $current_data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    
    // اضافه کردن ID رندوم و زمان ثبت‌نام
    $new_user['id'] = time(); 
    
    // ذخیره در لیست
    $current_data[] = $new_user;
    
    // نوشتن مجدد در فایل
    if(file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode(["status" => "success", "message" => "کاربر با موفقیت ذخیره شد"]);
    } else {
        echo json_encode(["status" => "error", "message" => "خطا در نوشتن فایل"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "درخواست نامعتبر"]);
}
?>