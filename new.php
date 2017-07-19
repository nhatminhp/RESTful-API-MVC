

<form action="new.php" method="post">
    <input type="submit" name="test" value="Them nhan vien" />
    <input type="text" name="name" />
    <br/>
    <input type="submit" name="list" value="Hien thi danh sach nhan vien" />
    <br/>
    <input type="submit" name="del" value="Xoa thanh vien" />
    <input type="text" name="xoa"/>
    <br/>
    <input type="submit" name="reset" value="Reset he thong" />
    <br/>
</form>

<?php
$filename="list.txt";
if(isset($_REQUEST['reset'])){
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fclose($myfile);
}
if(isset($_REQUEST['test'])){
    $store=array();
    $store=read($filename);
    $check=0;
    $tmp=trim($_POST['name']);
    if(strlen($tmp)==0) {
        echo "No character found";
        exit;
    }

    if(strcmp($tmp,"")!=0) {
        for ($j = 0; $j < count($store); $j++) {
            $store[$j] = substr($store[$j], 0, strlen($store[$j]) - 1);
            if (strcmp($store[$j], $tmp) == 0) {
                echo "Name has already existed";
                $check++;
                break;
            }
        }
        if ($check == 0) {
            $myfile = fopen($filename, "a") or die("Unable to open file!");
            $user = $tmp;
            fwrite($myfile, $user);
            $temp = "\n";
            fwrite($myfile, $temp);
            fclose($myfile);
            echo "Add successfully";
        }
    }
}
if(isset($_REQUEST['list'])) {

    $myfile = fopen($filename, "r") or die("Unable to open file!");
    while ($line = fgets($myfile)) {
        echo $line;
        echo "<br>";
    }
    fclose($myfile);
}
if(isset($_REQUEST['del'])){
    $store=array();
    $i=0;
    $store=read($filename);
    $tmp=trim($_POST['xoa']);
    for($j=0;$j<count($store);$j++)
    {
        $store[$j]=substr($store[$j],0,strlen($store[$j])-1);
    }


    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fclose($myfile);
    for($j=0;$j<count($store);$j++)
    {
        $myfile = fopen($filename, "a") or die("Unable to open file!");
        if(strcmp($store[$j],$tmp)!=0){
            fwrite($myfile,$store[$j]);
            $tmp="\n";
            fwrite($myfile,$tmp);
        }
        else
            $i++;
        fclose($myfile);
    }
    if($i==0) {
        echo "Can not find that name";
    }
    else
        echo "Delete successfully";

}
function read($filename){
    $file=fopen($filename,"r") or die("Unable to open file");
    $arr=array();

    while($line=fgets($file)){
        array_push($arr,$line);
    }
    fclose($filename);
    return $arr;
}
?>