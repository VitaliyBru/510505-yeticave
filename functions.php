<?php
/**
 * A template engine combine templates with a data to produce result documents.
 *
 * @param string $includeFile Contains name of file teplate (without '.php' exctend).
 * @param array $data Contains a data for assembling html code.
 *
 * @return string.
 */
function renderTemplate(string $includeFile, $data = array())
{
    $includeFile = 'templates/' . $includeFile . '.php';

    $content_out = "";
    if (file_exists($includeFile)) {
        extract($data, EXTR_REFS);
        ob_start();
        require_once($includeFile);
        $content_out = ob_get_clean();
    }
    return $content_out;
}

/**
 * This function returns a data of the timestamp was created
 * or a time between the timestamp and current time.
 *
 * @param int $_ts receive Unix timestamp format data.
 *
 * @return string
 */
function tsToTimeOrDate(int $_ts)
{
    /** @array $caseSystemRu[$firstKey][$secondKey] contains words with russion case endings */
    $caseSystemRu = [
        'hours' => ['Час', ' час', ' часа', ' часов'],
        'minutes' => ['Минуту', ' минуту', ' минуты', ' минут']
    ];
    /** @var string $firstKey contains a first keyword for $caseSystemRu array */
    $firstKey = 'hours';
    /** @var int $secondKey contains a second keyword for $caseSystemRu */
    $secondKey = 0;
    /** @var int $delta_ts contains time interval in seconds */
    $delta_ts = strtotime('now') - $_ts;
    if ($delta_ts >= SECONDS_IN_DAY) {
        return date('d.m.y в H:i', $_ts);
    }
    //** @var string $interval contains time interval in Hour(s) or Minute(s) */
    $interval = gmdate('H', $delta_ts);
    if ($interval === '00') {
        $interval = gmdate('i', $delta_ts);
        $firstKey = 'minutes';
    }
    /** @var int $first_number contains first number of $interval */
    $first_number = (int)$interval[0];
    /** @var int $last_number contains second number of $interval */
    $last_number = (int)$interval[1];
    if ($last_number > 4 || $first_number == 1 || ($last_number == 0 && $first_number != 0)) {
        $secondKey = 3;
    } elseif ($last_number > 1 && $last_number < 5) {
        $secondKey = 2;
    } elseif ($interval === '01') {
        $interval = '00';
    } else {
        $secondKey = 1;
    }
    $interval .= ($caseSystemRu[$firstKey][$secondKey] . ' назад');
    return ltrim($interval, '0');
}

/**
 * A function for checking: is the data correct? (yyyy-mm-dd).
 *
 * @param string $_str_date
 *
 * @return bool
 */
function checkUserDate(string $_str_date)
{
    if (preg_match('#^20[1-3](?(?<=3)[0-4]|\d)-[01](?(?<=1)[0-2]|\d)-[0-3](?(?<=3)[01]|\d)$#', $_str_date)) {
        if (date('Y-m-d', strtotime($_str_date)) == $_str_date) {
            if (strtotime($_str_date) > strtotime('now')) {
                return true;
            }
        }
    }
    return false;
}

/**
 *  A function extract "add lot form" data from $_POST to array
 * @param $post contains $_POST
 * @param $categories contains a list of goods type
 * @return mixed
 */
function getDataAddLotForm($post, $categories)
{
    $errors_count = 0;
    if (array_key_exists('add_lot', $post)) {
        $add_lot = $post['add_lot'];
        foreach ($add_lot as $key => $value) {
            if (($key == 'price_start' || $key == 'price_step') && (int) $value <= 0) {
                $add_lot[$key] = null;
                $errors_count++;
            }
            if ($key == 'date_end' && !checkUserDate($value)) {
                $add_lot[$key] = null;
                $errors_count++;
            }
            if ($key == 'category' && !in_array($value, $categories)) {
                $add_lot[$key] = null;
                $errors_count++;
            }
            if (($key == 'name' || $key == 'description' || $key == 'img_url') && $value == '') {
                $errors_count++;
            }
            if ($errors_count) {
                $add_lot['errors'] = $errors_count;
            }
        }
    }
    return $add_lot;
}

/**
 * @param $files
 * @param string $file_path
 * @return string
 */
function getFileAddLotForm($files, $file_path = '/img/')
{
    $file_path_full = __DIR__ . $file_path;
    $file_name = $files['userImage']['name'];
    if (file_exists($file_path_full . $file_name)) {
        $file_path_name = $file_path . $file_name;
    } else {
        $type_content = mime_content_type($_FILES['userImage']['tmp_name']);
        if ($type_content != 'image/png' && $type_content != 'image/jpeg') {
            $file_path_name = '';
        } else {
            $file_name = uniqid('img_', true);
            if ($type_content == 'image/png') {
                $file_name = $file_name . '.png';
            }else {
                $file_name = $file_name . '.jpg';
            }
            move_uploaded_file($files['userImage']['tmp_name'], $file_path_full . $file_name);
            $file_path_name = $file_path . $file_name;
        }
    }
    return $file_path_name;
}

/**
 * @param $post
 * @param $users
 * @param $user_login
 * @return mixed
 */
function userAuthenticator($post, $users, $user_login)
{
    foreach ($users as $user) {
        if (array_key_exists('email', $user) && $post['email'] == $user['email']) {
            if (array_key_exists('password', $user) && password_verify($post['password'], $user['password'])) {
                $user_login['name'] = $user['name'];
            } else {
                $user_login['email'] = $post['email'];
                $user_login['form_valid'] = false;
            }
        }
    }
    if (!$user_login['email'] || !$user_login['name'] ) {
        $user_login['form_valid'] = false;
    }
    return $user_login;
}

/**
 * @param int $lot_ts
 * @return string
 */
function timeLeft(int $lot_ts)
{
    $now = strtotime('now');
    $delta_time_h = floor(($lot_ts - $now) / 3600);
    $delta_time_m = floor(($lot_ts - $now) % 3600 / 60);
    return sprintf("%02d:%02d", $delta_time_h, $delta_time_m);
}