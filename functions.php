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
    if ($last_number > 4 || $first_number == 1 || $last_number == 0) {
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
 * A function for checking: is the data correct? (dd.mm.yyyy).
 *
 * @param string $_str_date
 *
 * @return bool
 */
function checkUserDate(string $_str_date)
{
    if (preg_match('#^[0-3](?(?<=3)[01]|\d)\.[01](?(?<=1)[0-2]|\d)\.20[1-3](?(?<=3)[0-4]|\d)$#', $_str_date)) {
        if (date('d.m.Y', strtotime($_str_date)) == $_str_date) {
            if (strtotime($_str_date) > strtotime('now')) {
                return true;
            }
        }
    }
    return false;
}

/**
 * @param $post
 * @param $key
 * @param $section
 * @return mixed
 */
function addFormToArray($post, $key, $section)
{
    if (array_key_exists($key, $post)) {
        if ($section['require'] == 'not empty') {
            if ($post[$key] != '') {
                $section['value'] = $post[$key];
                $section['valid'] = true;
            } else {
                $section['valid'] = false;
            }
        }
        if ($section['require'] == 'number') {
            $number = (int) $post[$key];
            if ((string) $number == $post[$key] && $post[$key] > 0) {
                $section['value'] = $post[$key];
                $section['valid'] = true;
            } else {
                $section['valid'] = false;
                $section['value'] = null;
            }
        }
        if ($section['require'] == 'date') {
            if (checkUserDate($post[$key])) {
                $section['value'] = strtotime($post[$key]);
                $section['valid'] = true;
            } else {
                $section['valid'] = false;
                $section['value'] = '';
            }
        }
        if ($section['require'] == 'choice') {
            if ($post[$key] != 'Выберите категорию'){
                $section['value'] = $post[$key];
                $section['valid'] = true;
            } else {
                $section['valid'] = false;
                $section['value'] = '';
            }
        }
    }
    return $section;
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
            if (array_key_exists('password', $user) && password_verify($post['password'], $user[password])) {
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

?>