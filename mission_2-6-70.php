<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>とこのみぃずブログ</title>
</head>

<body>
<h1>最近のマイブームは何ですか?</h1>
<form action="mission_2-6-70.php" method="post">
名前:<br />
<input type="text" name="name" size="30" value="" /><br />
コメント:<br />
<textarea name="comment" cols="30" rows="5"></textarea><br />
パスワード:<br />
<input type="password" name="pass1" size="8" value="" /><br />
<input type="submit" value="送信" name="soushin" /><br />
<br />
<br />
<br />
<h2>削除フォーム</h2>
削除対象番号:
<input type="text" name="deletenumber" size="5" value="" /><br />
パスワード:
<input type="password" name="deletepass" size="8" value="" /><br />
<input type="submit" value="削除" name="sakuzyo" /><br />
<br />
<br />
<h2>編集フォーム</h2>
編集対象番号:
<input type="text" name="hensyunumber" size="5" value="" /><br />
パスワード:
<input type="password" name="editpass" size="8" value="" /><br />
<input type="submit" value="編集" name="hensyu" />
</form>
</body>
</html>


<?php
//ミッション2-2ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['soushin'])) {


	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$comment = str_replace("\r\n", '', $comment);
	$passw1 = $_POST["pass1"];

	$filename = '2-30.txt';
	$fp = fopen($filename, 'a');

	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$lines = file($filename);

	//count関数で$linesの数を数える
	$num = count($lines);

	//1増やす
	$num+=1;

	//$numの内容を表示
	fwrite($fp, $num);
	
	//名前の入力
	fwrite($fp, "<>".$name."<>"."");

	//コメントの入力
	fwrite($fp, $comment."<>"."");

	// 日付の入力
	fwrite($fp, date("Y-m-d-H-i-s") ."<>"."");
	
	//パスワードを保存
	fwrite($fp, $passw1."<>"."\n");


	fclose($fp);
}

?>

<?php
//ミッション2-3ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//テキストファイルを変数に格納
$filename = '2-30.txt';

//ファイルを配列で読み込む
$filedata = file($filename);

//配列の数だけ繰り返し処理
foreach($filedata as $line){

	//分割する
	$data = explode("<>", $line);

	//投稿番号
	echo $data[0].'<br />';

	//名前
	echo $data[1].'<br />';

	//コメント
	echo $data[2].'<br />';

	//投稿日時
	echo $data[3].'<br />';
	
	//区切りの見栄えのための水平線
	echo '<hr />';

}

?>

<?php
//ここから削除フォームーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['sakuzyo'])) {

	//POSTから$delに番号を入れる
	$del = $_POST["deletenumber"];
	
	//POSTから$pass2に番号を入れる
	$passw2 = $_POST["deletepass"];
	
	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$filedata = file($filename);

	//内容を消して開く
	$fp = fopen($filename, 'w+');

	//配列の数だけ繰り返し処理
	foreach($filedata as $line){

		//<>で分割する
		$data = explode("<>", $line);

		//エラーチェック
		//echo "$data[4]<br>";
		//echo "$passw2<br>";
		
		
		//$delと違う、パスワードが一致した時
		if($data[0]!=$del) {
			if($data[4]==$passw2) {
			//ファイルに追記
			fputs($fp,$line);
			//エラーチェック
			//echo "aaa";
			}
		}


		//$delと違う、パスワードが一致しない時
		if($data[0]!=$del) {
		if($data[4]!=$passw2) {
			//ファイルに追記
			fputs($fp,$line);
			//エラーチェック
			//echo "bbb";
			}
		}
			
		//$delと同じ、パスワードが一致しない時
	if($data[0]==$del) {
	if($data[4]!=$passw2) {
	
			//ファイルに追記
			fputs($fp,$line);
			//エラーチェック
			//echo "ccc";
			
			}
		
		}
		//エラーチェック
		//var_dump( $data[0] );
		//var_dump( $del );
		//var_dump( $passw2 );
		
	}
	

//ファイルを閉じる
fclose($fp);

}

?>


<?php
//ここから編集フォームーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//編集ボタンが押されたら
if (isset($_POST['hensyu'])) {

	//POSTから$edit_nunに番号を入れる
	$edit_num = $_POST['hensyunumber'];
	//POSTから$edit_passに番号を入れる
	$edit_pass = $_POST["editpass"];

	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$filedata = file($filename);

	//配列の数だけ繰り返し処理
	foreach($filedata as $line){

		//<>で分割する
		$data = explode("<>", $line);
		
		//編集番号が$edit_numと一致したら
		//エラーチェック
		//var_dump($data[0]);
		//echo "<br>";
		//var_dump($data[1]);
		//echo "<br>";
		//var_dump($data[2]);
		//echo "<br>";
		//var_dump($data[3]);
		//echo "<br>";
		//var_dump($data[4]);
		//echo "<br>";
		
		if($data[0]==$edit_num){
			if($data[4]==$edit_pass){
			$edit_num0=$data[0];
			$user=$data[1];
			$text=$data[2];
			$time=$data[3];
			$passw03=$data[4];
			
			
		}
	}
}

}

?>

<form action="mission_2-6-70.php" method="post">
<input name="edit_num" type="hidden" value="<?php echo $edit_num0;?>"/>
<input name="user" type="text" value="<?php echo $user;?>"/>
<input name="text" type="text" value="<?php echo $text;?>"/>
<input name="passw3" type="hidden" value="<?php echo $passw03;?>"/>
<input type="submit" value="編集送信" name="hensyusoshin" />
</form>

<?php
//送信ボタンを押したときのみデータが送られる
if (isset($_POST['hensyusoshin'])) {


	//POSTから変数にを入れる
	$edit_num1 = $_POST['edit_num'];
	$user1 = $_POST['user'];
	$text1 = $_POST['text'];
	$time1 = date('Y-m-d-H-i-s');
	$passw3 = $_POST['passw3'];
	
	
	//エラーチェック
	//echo "2<br>";
	//echo "$passw3<br>";
	//echo "<br>";
	
	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$filedata = file($filename);

	//内容を消して開く
	$fp = fopen($filename, 'w+');

	//配列の数だけ繰り返し処理
	foreach($filedata as $line){

		//<>で分割する
		$data = explode("<>", $line);

		//エラーチェック
		//var_dump($data[0]);
		//echo "<br>";

		//編集番号が$edit_numと同じならカッコの中処理
		if($data[0]==$edit_num1){
			fwrite($fp, $edit_num1);
			fwrite($fp, "<>");
			fputs($fp, $user1);
			fwrite($fp, "<>");
			fputs($fp,$text1);
			fwrite($fp, "<>");
			fwrite($fp, $time1);
			fwrite($fp, "<>");
			fwrite($fp, $passw3."<>"."\n");
			
			
		//一致しない時はもとのデータをそのまま書き込み
		} else{
			
			//元の一行をファイルに追記
			fputs($fp, $line);
		}
	}


//ファイルを閉じる
fclose($fp);

}

?>


<?php

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['sakuzyo'])) {

echo '<font color="blue"> 削除後の結果 </font><br>';
echo '<br>';

	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$filedata = file($filename);

	//配列の数だけ繰り返し処理
	foreach($filedata as $line){

		//分割する
		$data = explode("<>", $line);

		//投稿番号
		echo $data[0].'<br />';

		//名前
		echo $data[1].'<br />';

		//コメント
		echo $data[2].'<br />';

		//投稿日時
		echo $data[3].'<br />';
	
		//区切りの見栄えのための水平線
		echo '<hr />';

	}
}

?>

<?php

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['hensyusoshin'])) {

echo '<font color="blue"> 編集後の結果 </font><br>';
echo '<br>';

	//テキストファイルを変数に格納
	$filename = '2-30.txt';

	//ファイルを配列で読み込む
	$filedata = file($filename);

	//配列の数だけ繰り返し処理
	foreach($filedata as $line){

		//分割する
		$data = explode("<>", $line);

		//投稿番号
		echo $data[0].'<br />';

		//名前
		echo $data[1].'<br />';

		//コメント
		echo $data[2].'<br />';

		//投稿日時
		echo $data[3].'<br />';
	
		//区切りの見栄えのための水平線
		echo '<hr />';

	}
}

?>


