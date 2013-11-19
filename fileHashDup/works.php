<?php
echo "Starting\n";

$gmworker= new GearmanWorker();

$gmworker->addServer();

$gmworker->addFunction("hashFile", "hash_file_fn");

echo 'Waiting for job...' . PHP_EOL;
while($gmworker->work()) {
  if ($gmworker->returnCode() != GEARMAN_SUCCESS) {
    echo "return_code: " . $gmworker->returnCode() . "\n";
    break;
  }
}

function hash_file_fn($job) {
  $path = $job->workload();
  $file_size = filesize($path);
  $size_str = getSizeStr($file_size);
  echo "Received job: " . $job->handle() . PHP_EOL;
  echo "Path: {$path}\t({$size_str})\t";
  $hash_val = $file_size > 102400000 || $file_size == 0 ? '' : md5_file($path); 
  $data = array(
	  'path' => addslashes($path),
	  'size' => $file_size,
	  'size_str' => $size_str, 
	  'hash_val' => $hash_val, 
	  'hash_num' => hash2num($hash_val),
  );
  echo TDb::saveData($data) ? 'save success' . PHP_EOL : 'save failed' . PHP_EOL;
  return $path;
}

function getSizeStr($file_size, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($file_size) - 1) / 3);
  return sprintf("%.{$decimals}f", $file_size / pow(1024, $factor)) . @$sz[$factor];
}
function hash2num($str) {
	$num = 0;
	for($i=0,$j=strlen($str);$i<$j;$i++) {
		$num += ord($str[$i]);
	}
	return $num;
}

class TDb {
	static $con = false;
	static $sth = false;
	static function getCon() {
		if (self::$con) return self::$con;
		try {
			//$dsn = 'mysql:dbname=test;host=127.0.0.1';
			//$dbh = new PDO($dsn, 'test', 'test', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$dsn = 'sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . 'sqlite3.db';
			$dbh = new PDO($dsn, '', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$con = $dbh;
			return $dbh;
		} catch (PDOException $e) {
			echo 'connect error' . $e->getMessage();
		}
	}
	static function saveData($data) {
		$sql = 'INSERT INTO `dup_finder` (`path`,`size`,`size_str`,`hash`, `hash_num`) VALUES (:path, :size, :size_str, :hash_val, :hash_num)';
		$sth = self::getCon()->prepare($sql);
		$sth->bindValue(':path', $data['path'], PDO::PARAM_STR);
		$sth->bindValue(':size', $data['size'], PDO::PARAM_INT);
		$sth->bindValue(':size_str', $data['size_str'], PDO::PARAM_STR);
		$sth->bindValue(':hash_val', $data['hash_val'], PDO::PARAM_STR);
		$sth->bindValue(':hash_num', $data['hash_num'], PDO::PARAM_INT);
		$rslt = $sth->execute();
		if (!$rslt) var_dump($sth->errorInfo());
		return $rslt;
	}
}
