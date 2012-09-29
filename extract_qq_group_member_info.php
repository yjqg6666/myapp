<?php
    $cont = file_get_contents('raw.html');
    $fh = fopen('list', 'w+');
    $pat = '/<div\s*title=\"(?<nickname>[\s\S]+?)\"\s+class=\"chatBox_groupMember_nameArea\">\s+<div\s+class=\"chatBox_groupMember_nick[^\"]*\"\s+id=\"chatBox_groupMember_nick_(?<gid>\d+)_(?<uid>\d+)\">(?<truename>[^<]*?)<\/div/i';
    preg_match_all($pat, $cont, $matches);
    var_dump(count($matches[0]));
    $total = count($matches[0]);
    for($i=0; $i<$total; $i++) {
        $echo = "nickname:<{$matches['nickname'][$i]}>\tgid:<ALL{$matches['gid'][$i]}>\tuid:<{$matches['uid'][$i]}>\ttruename:<{$matches['truename'][$i]}>" . PHP_EOL;
        $write .= $echo;
        echo $echo;
    }
    fwrite($fh, $write);
    fclose($fh);
