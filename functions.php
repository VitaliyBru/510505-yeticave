<?php
/**
* A template engine combine templates with a data to produce result documents.
*
* @param string $includeFile Contains name of file teplate (file.php) and path to it.
* @param array $data Contains a data for assembling html code.
*
* @return string.
*/
function renderTemplate(string $includeFile, $data = array())
{
	/** @var array $goods_type A list of goods tipes */
	$goods_type;
	/** @var array $lots_list A list of lots */
	$lots_list;
	/** @var string $lot_time_remaining A time (hh:mm) before the lot ends */
	$lot_time_remaining;
	/** @var bool $is_auth user authorization (true or false) */
	$is_auth;
	/** @var string $user_name Contains user name */
	$user_name;
	/** @var string $user_avatar Contains user avatar source */
	$user_avatar;
	/** @var string $content Contains html code */
	$content;
	/** @var string $title A document title */
	$title;

	if (isset($data['types'])) {
		$goods_type = &$data['types'];
	}
	if (isset($data['lots'])) {
		$lots_list = &$data['lots'];
	}
	if (isset($data['time'])) {
		$lot_time_remaining = $data['time'];
	}
	if (isset($data['auth'])) {
		$is_auth = $data['auth'];
	}
    if (isset($data['name'])) {
    	$user_name =$data['name'];
    }
    if (isset($data['avatar'])) {
    	$user_avatar = $data['avatar'];
    }
    if (isset($data['content'])) {
    	$content = &$data['content'];
    }
    if (isset($data['title'])) {
    	$title = $data['title'];
    }

    ob_start();
    if (file_exists($includeFile)) {
    	require_once ($includeFile);
    } else {
    	print("");
    }
	return ob_get_clean();
}
?>