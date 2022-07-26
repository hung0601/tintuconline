<?php

// Hàm lấy value từ $_POST
function redirect($url)
{
    header("Location:{$url}");
    exit();
}
function input_post($key)
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : false;
}

// Hàm lấy value từ $_GET
function input_get($key)
{
    return isset($_GET[$key]) ? trim($_GET[$key]) : false;
}

// Hàm kiểm tra submit
function is_submit($key)
{
    return (isset($_POST['request_name']) && $_POST['request_name'] == $key);
}

// Hàm show error
function show_error($error, $key)
{
    echo '<span style="color: red">' . (empty($error[$key]) ? "" : $error[$key]) . '</span>';
}
function date_process($date_str)
{
    $date = date_create($date_str);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $sub = strtotime(date('Y-m-d H:i:s')) - strtotime($date->format('Y-m-d H:i:s'));
    if ($sub < 60) {
        $result = "vừa xong";
        return $result;
    } else if (($sub / 60) < 60) {
        $result = (int)($sub / 60) . ' phút trước';
        return $result;
    } else if (($sub / 3600) < 24) {
        $result = (int)($sub / 3600) . ' giờ trước';
        return $result;
    } else if (($sub / (3600 * 24)) < 7) {
        $result = (int)($sub / (3600 * 24)) . ' ngày trước';
        return $result;
    } else if (($sub / (3600 * 24 * 7)) < 5) {
        $result = (int)($sub / (3600 * 24 * 7)) . ' tuần trước';
        return $result;
    } else {
        $result = $date->format('d-m-Y H:m');
        return $result;
    }
}
