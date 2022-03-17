<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $user="root";
    $pass="";
        $conn = new PDO('mysql:host=localhost;dbname=articles', $user, $pass);
    ?>
    <?php
    $title=$_POST["title"];
    $text=$_POST["text"];   
    $pictmp=$_FILES["pics"]["tmp_name"];  
    $picname=$_FILES["pics"]["name"]; 
    $path="uploads/";
    $filedir=$path.$picname;

    if(isset($_POST['send'])){
        $data=$conn->prepare("INSERT INTO prepods (`title`, `text`, `img_path`)
        VALUES (:title,:text,:img_path)");
        $data->bindParam(":title", $title, PDO::PARAM_STR);
        $data->bindParam(":text", $text, PDO::PARAM_STR);
        $data->bindParam(":img_path", $filedir, PDO::PARAM_STR);
        $data->execute();
        move_uploaded_file($pictmp, $filedir);
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputEmail">ФИО преподователя</label>
            <input type="text" name="title" class="form-control" placeholder="ФИО преподователя" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Должность</label>
            <textarea name="text" class="form-control" placeholder="Должность" required rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-lable" for="validationCustom01">Картинка</label>
            <input type="file" class="form-control" id="validationCustom01" name="pics">
        </div>
        <button type="submit" name="send" class="btn btn-primary">Добавить</button>
    </form>
    <table>
    <tr class="odd">
            <td class="sorting_1 dtr-contol">ФИО</td>
            <td class="sorting_1 dtr-contol">Должность</td>
            <td class="sorting_1 dtr-contol">Картинка</td>
            </tr>
    <?php
    $articles=$conn->query("SELECT * FROM `prepods`")->fetchAll(PDO::FETCH_ASSOC);
    foreach($articles as $art){
        echo '
        <tr>
            <td>'.$art['text'].'</td>
            <td>'.$art['title'].'</td>
            <td><img width="100" src='.$art['img_path'].'></td>
            </tr>
        ';
    }
    ?>
    </table>
</body>
</html>