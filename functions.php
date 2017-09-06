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
 * A function for checking is the string a decimal number.
 *
 * @var string $_string
 *
 * @return bool
 */
function isStringNumber(string $_string)
{
    $_number = (int) $_string;
    if ((string) $_number == $_string) {
        return true;
    }
    return false;
}

/**
 * A function for checking: is the data correct? (dd.mm.yyyy).
 *
 * @var string $_str_date
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
 * A function checks a key to see it has a valid variable name.
 *
 * @var &$post_data A reference to array
 * @var string $key A keyword
 * @var string $default_val A Default value
 *
 * @return  bool.
 */
function getFromPost(&$post_data, string $key, $default_val = '')
{
    if (array_key_exists($key, $post_data)) {
        return $post_data[$key];
    } else {
        return $default_val;
    }
}
/**
 * A function compares two values.
 *
 * @var mixed $_variables first argument
 * @var mixed $requisition second argument
 * @var mixed $key word or number (key for array)
 * @var &$flagsArray A reference to flags array
 *
 * @return void*/
function setFlag($_variables, $requisition, $key, &$flagsArray)
{
    if ($_variables == $requisition) {
        $flagsArray[$key] = true;
        $flagsArray['form'] = true;
    }
}
?>