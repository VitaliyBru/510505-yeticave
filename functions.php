<?php
/**
 * A template engine combine templates with a data to produce result documents.
 *
 * @param string $includeFile Contains name of file template (without '.php' extend).
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
 * @param string $date receive Unix timestamp format data.
 *
 * @return string
 */
function tsToTimeOrDate(string $date)
{
    $_ts = strtotime($date);
    /** @array $caseSystemRu[$firstKey][$secondKey] contains words with russian case endings */
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
function checkUserDate($_str_date)
{
    $date = DateTime::createFromFormat('Y-m-d', $_str_date);
    return $date && $date->format('Y-m-d') === $_str_date && strtotime($_str_date) > strtotime('now');
}

/**
 *  A function extract "add lot form" data from $_POST to array
 *
 * @param $post contains $_POST
 * @param $categories contains a list of goods type
 *
 * @return mixed
 */
function getDataAddLotForm($post, $categories)
{
    $errors_count = 0;
    if (array_key_exists('add_lot', $post)) {
        $add_lot = $post['add_lot'];
        foreach ($add_lot[0] as $key => $value) {
            if (($key == 'price_start' || $key == 'price_increment') && (int) $value <= 0) {
                $add_lot[0][$key] = null;
                $errors_count++;
            }
            if ($key == 'date_end' && !checkUserDate($value)) {
                $add_lot[0][$key] = null;
                $errors_count++;
            }
            if ($key == 'category' && !in_array($value, array_column($categories, 'name'))) {
                $add_lot[0][$key] = null;
                $errors_count++;
            }
            if (($key == 'name' || $key == 'description' || $key == 'image') && $value == '') {
                $errors_count++;
            }
            if ($errors_count) {
                $add_lot[1]['errors'] = $errors_count;
            }
        }
    }
    return $add_lot;
}

/**
 * @param $post
 * @return array
 */
function getDataSignInForm($post)
{
    $error_count = 0;
    $sign[0] = $post['sign'];
    $sign[0]['email'] = filter_var($sign[0]['email'], FILTER_VALIDATE_EMAIL);
    foreach ($sign[0] as $key => $value) {
        if ($key != 'avatar' && !$value) {
            $error_count++;
        }
    }
    $sign['errors'] = $error_count;
    return $sign;
}

/**
 * @param $files
 * @param string $file_path
 * @return string
 */
function getImageFilePostForm($files, $file_path = '/img/')
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

function indexDataBuilder($link, $id, $get, $lots_on_page = 3)
{
    if ($id) {
        $sql_lots_count = 'SELECT COUNT(l.id) AS lots_count FROM lots AS l JOIN categories AS c ON l.category_id=c.id 
WHERE l.date_end > NOW() AND l.category_id=?';
        $lots_count = select_data($link, $sql_lots_count, [$id]);
        $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() AND l.category_id=? ORDER BY l.id DESC LIMIT ? OFFSET ?';
        $pages = paginationCalculator($lots_count[0]['lots_count'], $get, $lots_on_page);
        $lots = select_data($link, $sql_lot, [$id, $pages['limit'], $pages['offset']]);
    } else {
        $sql_lots_count = 'SELECT COUNT(id) AS lots_count FROM lots WHERE date_end > NOW()';
        $lots_count = select_data($link, $sql_lots_count);
        $sql_lot = 'SELECT l.id, l.name, l.image, l.price_start, l.date_end, c.name AS category FROM lots AS l 
    JOIN categories AS c ON l.category_id=c.id WHERE l.date_end > NOW() ORDER BY l.id DESC LIMIT ? OFFSET ?';
        $pages = paginationCalculator($lots_count[0]['lots_count'], $get, $lots_on_page);
        $lots = select_data($link, $sql_lot, [$pages['limit'], $pages['offset']]);
    }
    return ['pages' => $pages, 'lots' => $lots];
}


function timeLeft(string $lot_time)
{
    $lot_time_remaining = null;
    $ts = strtotime($lot_time);
    $now = strtotime('now');
    $delta_ts = $ts - $now;
    $days = floor($delta_ts / 86400);
    if ($days > 3) {
        return 'Окончание ' . date('d.m.Y в H:i', $ts);
    }
    $hour = floor($delta_ts % 86400 / 3600);
    $minute = floor($delta_ts % 3600 / 60);
    if ($days) {
        $lot_time_remaining = "$days д " . sprintf("%02d:%02d", $hour, $minute);
    } else {
        $lot_time_remaining = sprintf("%02d:%02d", $hour, $minute);
    }
    return $lot_time_remaining;
}

/**
 * @param $link
 * @param $sql
 * @param array $data
 * @return array
 */
function select_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = [];
    if (!mysqli_stmt_execute($stmt)) {
        return $result = [];
    }
    $meta = mysqli_stmt_result_metadata($stmt);
    $row = [];
    $list = [];
    while ($field = mysqli_fetch_field($meta)) {
        $list[] = &$row[$field->name];
    }
    $variables = array_merge([$stmt], $list);
    $bind_result = 'mysqli_stmt_bind_result';
    $bind_result(...$variables);
    while (mysqli_stmt_fetch($stmt)) {
        $temp = [];
        foreach ($row as $key => $value) {
            $temp[$key] = $value;
        }
        $result[] = $temp;
    }
    mysqli_free_result($meta);
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * @param $link
 * @param $table_name
 * @param array $row_data
 *
 * @return bool|int|string
 */
function insert_data($link, $table_name, $row_data = array())
{
    $sql = "INSERT INTO $table_name(";
    $placeholder_list = "VALUES (";
    $data = [];
    $first_element = true;
    foreach ($row_data as $column => $value) {
        $sql .= $first_element ? "$column" : ", $column";
        $placeholder_list .= $first_element ? "?" : ", ?";
        $data[] = $value;
        $first_element = false;
    }
    $sql .= ") $placeholder_list)";
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    if (!mysqli_stmt_execute($stmt)) {
        return false;
    }
    $insert_id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $insert_id;
}

/**
 * @param $link
 * @param $sql
 * @param array $data
 *
 * @return bool
 */
function exec_query($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    if (!mysqli_stmt_execute($stmt)) {
        return false;
    }
    mysqli_stmt_close($stmt);
    return true;
}

/**
 * @param $lots_count
 * @param $get contains «$_GET»
 * @param int $lots_limit count of lots on single page
 *
 * @return array
 */
function paginationCalculator($lots_count, $get, $lots_limit = 3)
{
    $current_page = $get['page'] ?? 1;
    $pages_count = ceil($lots_count / $lots_limit);
    $offset = ($current_page - 1) * $lots_limit;
    $pages_list = range(1, $pages_count);
    return ['count' => $pages_count, 'list' => $pages_list, 'limit' => $lots_limit, 'offset' => $offset, 'current' => $current_page];
}
