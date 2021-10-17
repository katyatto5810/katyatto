<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
    
    <?php
    //接続
    $dsn =  'mysql:dbname=co_***_it_3919_com;host=localhost';
    $user = 'co-***.it.3919.c';
    $password =  'PASSWORD';
    $pdo = new PDO($dsn,$user,$password);
    $sql = "CREATE TABLE IF NOT EXISTS tbtoukou(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name char(32),
    comment TEXT,
    datet DATETIME
    )";
    $stmt = $pdo->query($sql);
    $sql = "SHOW TABLES";
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
    $sql ='SHOW CREATE TABLE tbtoukou';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
    }
    echo "<hr>";
    
        $filename="mission_5-1.txt";
        if((empty($_POST["name"]))&&(empty($_POST["str"]))&&(!empty($_POST["hidden"]))){
            //空の時が真の値に中身が実行される//
        }
        //新規投稿
        elseif((!empty($_POST["name"]))&&(!empty($_POST["str"]))&&(empty($_POST["hidden"]))){
           
            $sql = $pdo -> prepare("INSERT INTO tbtoukou (name, comment,datet) VALUES (:name, :comment,:datet)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':datet', $datet, PDO::PARAM_STR);
            $name = $_POST["name"];
            $comment = $_POST["str"];
            $datet=date("Y-m-d H:i:s");
            $sql -> execute();
            
        }
        //削除機能
        
        if(!empty($_POST["del"])){
            
            $id = $_POST["del"];
            $sql = 'delete from tbtoukou where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
        }
        //編集番号表示機能
        if(!empty($_POST["rewrite"])){
            
            $id = $_POST["rewrite"];
            $sql = 'SELECT * FROM tbtoukou where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll();
            //$rowの中にはテーブルのカラム名が入る
            foreach ($results as $row){
                $toukou2=$row['id'];
                $name2 = $row['name'];
                $comment2 = $row['comment'];
            }
            //$stmt->execute()
                
            }
        // 編集実行機能
        if(!empty($_POST["hidden"])){
           
            $hidden=$_POST["rewrite"];
            
            $id = $_POST["hidden"]; //変更する投稿番号
            $name = $_POST["name"];
            $comment = $_POST["str"]; //変更したい名前、変更したいコメントは自分で決めること
            $sql = 'UPDATE tbtoukou SET name=:name,comment=:comment WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        ?>
    <form action="" method="post">
        　　名前:<input type="text" name="name" value= <?php echo @$name2;?>><br>
            コメント:<input type="text" name="str" value=<?php echo @$comment2;?>><br>
        <input type="text" name="hidden" value=<?php echo @$toukou2;?>><br>
        削除:<input type="text" name="del" placeholder="削除する行を入力"><br>
        編集:<input type="text" name="rewrite" placeholder="編集する番号を入力"><br>
        <input type="submit" name="submit" del="submit" rewrite="submit" value="submit"><br>
    </form>
<?php        
        //表示機能
            $sql = 'SELECT * FROM tbtoukou';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['datet'].'<br>';
            echo "<hr>";
            }
        
?>

</body>
</html>