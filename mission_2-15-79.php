<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>とこのみぃずブログ</title>
</head>

<body>
<h1>最近のマイブームは何ですか?</h1>
<form action="mission_2-15-79.php" method="post">
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
//送信ボタンを押したときのみデータが送られる
if (isset($_POST['soushin'])) {
	
	//emptyを使ってデータが空かどうか調べる
	if (empty($_POST['name'])) {
		die('<font color="red"> 名前が入力されていません。 </font>');
		echo '<br>';
	}
		
	if (empty($_POST['comment'])) {
		die('<font color="red"> コメントが入力されていません。 </font>');
		echo '<br>';
	}
			
		if (empty($_POST['pass1'])) {
		die('<font color="red"> パスワードが入力されていません。 </font>');
		echo '<br>';
	}
	
	
	//PDOでDBに接続する
	$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

	//PDOでINSERTを利用してカラムに値を代入する
	$sql = $pdo -> prepare("INSERT INTO smission (name,comment,datetime,password) VALUES (:name, :comment, :datetime, :password);");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':datetime', $datetime, PDO::PARAM_INT);
	$sql -> bindParam(':password', $password, PDO::PARAM_INT);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$datetime = date('Y-m-d-H-i-s');
	$password = $_POST["pass1"];

	$sql -> execute();
	
}

?>

<?php
//文字化けを直す
header('Content-Type: text/html; charset=UTF-8');

//PDOでDBに接続する
$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

//クエリ、「test」は自分が作ったテーブル名
$sql = 'SELECT * FROM smission;';

//実行・結果取得
$results = $pdo -> query($sql);

//以下でブラウザ上に出力する
foreach ($results as $row){

	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].'<br>';
	echo $row['name'].'<br>';
	echo $row['comment'].'<br>';
	echo $row['datetime'].'<br>';

	//区切りの見栄えのための水平線
	echo '<hr />';

}

?>


<?php
//削除フォームーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['sakuzyo'])) {

	$pdo = new PDO("データーベース名",'ユーザー名','パスワード');
	
	//POSTから$delに番号を入れる
	$del = $_POST["deletenumber"];
	
	//POSTから$pass2に番号を入れる
	$delpass = $_POST["deletepass"];
	
	//送信したidの項目をSELECTしてパスワードを得る。
	//$sql = 'SELECT * FROM smission WHERE id = $delpass;';
	//$results = $pdo->query($sql);
	
		
	//クエリ、「smission」は自分が作ったテーブル名
	$sql = 'SELECT * FROM smission;';

	//実行・結果取得
	$results = $pdo -> query($sql);

	//以下で$rowに変数を入れる
	foreach ($results as $row){
	
		//パスワードが一致した時
		if($row[0]==$del){
			if($row[4]==$delpass) {
		
				//DELETE文を実行
				$sql = "delete from smission where id='$del';";
				$results = $pdo->query($sql);
			
			}
		}
		
		//パスワードが一致しない時
		if($row[0]==$del){
			if($row[4]!==$delpass) {
			
				die('<font color="red"> パスワードが違います。 </font>');
				echo '<br>';
			}
		}
	}
}

?>

<?php
if (isset($_POST['sakuzyo'])) {

echo '<font color="blue"> 削除後の結果 </font><br>';
echo '<br>';

//文字化けを直す
header('Content-Type: text/html; charset=UTF-8');

//PDOでDBに接続する
$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

//クエリ、「test」は自分が作ったテーブル名
$sql = 'SELECT * FROM smission;';

//実行・結果取得
$results = $pdo -> query($sql);

//以下でブラウザ上に出力する
foreach ($results as $row){

	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].'<br>';
	echo $row['name'].'<br>';
	echo $row['comment'].'<br>';
	echo $row['datetime'].'<br>';

	//区切りの見栄えのための水平線
	echo '<hr />';

}
}

?>


<?php
//編集フォームーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

//編集ボタンが押されたら
if (isset($_POST['hensyu'])) {

	$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

	//POSTから$edit_nunに番号を入れる
	$edit_num = $_POST['hensyunumber'];
	//POSTから$edit_passに番号を入れる
	$edit_pass = $_POST["editpass"];
	
	//クエリ、「smission」は自分が作ったテーブル名
	$sql = 'SELECT * FROM smission;';

	//実行・結果取得
	$results = $pdo -> query($sql);

	//以下で$rowに変数を入れる
	foreach ($results as $row){
		
		
		
		//エラーチェック
		//echo "エラーチェック".'<br>';
		//echo $row['id'].'<br>';
		//echo $row['name'].'<br>';
		//echo $row['comment'].'<br>';
		//echo $row['datetime'].'<br>';
		//echo $row['password'].'<br>';
		//var_dump($row[0]);
		//echo "<br>";
		//var_dump($row[1]);
		//echo "<br>";
		//var_dump($row[2]);
		//echo "<br>";
		//var_dump($row[3]);
		//echo "<br>";
		//var_dump($row[4]);
		//echo "<br>";


		if($row[0]==$edit_num){
			if($row[4]==$edit_pass) {
				$edit_num0=$row[0];
				$user=$row[1];
				$text=$row[2];
				$time=$row[3];
				$passw03=$row[4];
			
			}
		}
	}
	//エラーチェック
	//echo "エラーチェック".'<br>';
	//echo $edit_num0.'<br>';
	//echo $user.'<br>';
	//echo $text.'<br>';
	//echo $time.'<br>';
	//echo $passw03.'<br>';
	
	
}

?>


<form action="mission_2-15-79.php" method="post">
<input name="edit_num" type="hidden" value="<?php echo $edit_num0;?>"/>
<input name="user" type="text" value="<?php echo $user;?>"/>
<input name="text" type="text" value="<?php echo $text;?>"/>
<input name="passw3" type="hidden" value="<?php echo $passw03;?>"/>
<input type="submit" value="編集送信" name="hensyusoshin" />
</form>


<?php

//送信ボタンを押したときのみデータが送られる
if (isset($_POST['hensyusoshin'])) {

	$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

	//POSTから変数にを入れる
	$edit_num1 = $_POST['edit_num'];
	$user1 = $_POST['user'];
	$text1 = $_POST['text'];
	$time1 = date('Y-m-d-H-i-s');
	$passw3 = $_POST['passw3'];
	
	//クエリ、「test」は自分が作ったテーブル名
	$sql = 'SELECT * FROM smission;';

	//実行・結果取得
	$results = $pdo -> query($sql);

	//以下でブラウザ上に出力する
	foreach ($results as $row){

		if($row[0]==$edit_num1){
			if($row[4]==$passw3) {
				//UPATE文を実行  
				$sql = "UPDATE smission SET name = :name, comment = :comment WHERE id = :id";
		
				$stmt = $pdo->prepare($sql);
		
				$edit = array(':name' => $user1, ':comment' => $text1, ':id' => $edit_num1);
		
				$stmt->bindParam(':name', $user1, PDO::PARAM_STR);
				$stmt->bindParam(':comment', $text1, PDO::PARAM_STR);
				$stmt->bindValue(':id', $edit_num1, PDO::PARAM_INT);
		
				$stmt->execute();
		
		

			//$sql = $pdo -> prepare("INSERT INTO smission (editnum,name,comment,datetime,password) VALUES (:editnum, :name, :comment, :datetime, :password);");
			//$sql -> bindParam(':editnum', $edit_num1, PDO::PARAM_INT);
			//$sql -> bindParam(':name', $user1, PDO::PARAM_STR);
			//$sql -> bindParam(':comment', $text1, PDO::PARAM_STR);
			//$sql -> bindParam(':datetime', $time1, PDO::PARAM_INT);
			//$sql -> bindParam(':password', $passw3, PDO::PARAM_INT);
			
			//$sql -> execute();
			
			}
		}
	}
}

?>


<?php
if (isset($_POST['hensyusoshin'])) {

echo '<font color="blue"> 編集後の結果 </font><br>';
echo '<br>';

//文字化けを直す
header('Content-Type: text/html; charset=UTF-8');

//PDOでDBに接続する
$pdo = new PDO("データーベース名",'ユーザー名','パスワード');

//クエリ、「test」は自分が作ったテーブル名
$sql = 'SELECT * FROM smission;';

//実行・結果取得
$results = $pdo -> query($sql);

//以下でブラウザ上に出力する
foreach ($results as $row){

	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].'<br>';
	echo $row['name'].'<br>';
	echo $row['comment'].'<br>';
	echo $row['datetime'].'<br>';
	
	//区切りの見栄えのための水平線
	echo '<hr />';

	}
}

?>

