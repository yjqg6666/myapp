#!/bin/bash
from=$(date -d "2013-11-06" +%s); 
end=$(date -d "2014-01-31" +%s);
while [[ "$from" -le "$end" ]];
do 
	date=$(date -d "@$from" +%F);
	url="http://domain.com/path/to/url?date=${date}";
	echo $url;
	sleep=$(php -r 'echo rand(4,7);'); 
	echo sleep $sleep seconds && sleep $sleep;  
	curl $url -H 'Pragma: no-cache' -H 'DNT: 1' -H 'Accept-Encoding: gzip,deflate,sdch' -H 'Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.6,en;q=0.4' -H 'User-Agent: Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8' -H 'Cache-Control: no-cache' -H 'Connection: keep-alive' --compressed -o - >> rslt.html
	let from+=86400; 
done
