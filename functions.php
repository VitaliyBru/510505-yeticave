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
	extract($data, EXTR_REFS);

    $includeFile = 'templates/' . $includeFile . '.php';

    $content_out = "";
    if (file_exists($includeFile)) {
    	ob_start();
    	require_once ($includeFile);
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
    $first_number = (int) $interval[0];
    /** @var int $last_number contains second number of $interval */
    $last_number = (int) $interval[1];
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
?>