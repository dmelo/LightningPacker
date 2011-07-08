<?

$words = array('automatically', 'lightning', 'javascript', 'files', 'jQuery', 'php', 'programming');

$str = '';
for($i = 0; $i < 20000; $i++) {
    $str .= $words[rand(0, count($words) - 1)] . ' ';
}

echo $str;
