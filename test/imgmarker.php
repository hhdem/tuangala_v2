<?php
 
/******************************************************************************
 
����˵��:
$max_file_size  : �ϴ��ļ���С����, ��λBYTE
$destination_folder : �ϴ��ļ�·��
$watermark   : �Ƿ񸽼�ˮӡ(1Ϊ��ˮӡ,����Ϊ����ˮӡ);
 
******************************************************************************/
 
//�ϴ��ļ������б�
 
$uptypes=array(
    'image/jpg', 
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);
 
 
$max_file_size=2000000;     //�ϴ��ļ���С����, ��λBYTE
$destination_folder="uploadimg/"; //�ϴ��ļ�·��
$watermark=1;      //�Ƿ񸽼�ˮӡ(1Ϊ��ˮӡ,����Ϊ����ˮӡ);
$watertype=2;      //ˮӡ����(1Ϊ����,2ΪͼƬ)
$waterposition=1;     //ˮӡλ��(1Ϊ���½�,2Ϊ���½�,3Ϊ���Ͻ�,4Ϊ���Ͻ�,5Ϊ����);
$waterstring="http://www.hhdem.com/";  //ˮӡ�ַ���
$waterimg="xplore.gif";    //ˮӡͼƬ
$imgpreview=1;      //�Ƿ�����Ԥ��ͼ(1Ϊ����,����Ϊ������);
$imgpreviewsize=1/2;    //����ͼ����
 
?>
 
<html>
<head>
<title>ZwelLͼƬ�ϴ�����</title>
<style type="text/css">
<!--
body
{ 
     font-size: 9pt;
}
input
{ 
     background-color: #66CCFF;
     border: 1px inset #CCCCCC;
}
-->
</style>
</head>
<body>
<form enctype="multipart/form-data" method="post" name="upform">
  �ϴ��ļ�:
  <input name="upfile" type="file">
  <input type="submit" value="�ϴ�"><br>
  �����ϴ����ļ�����Ϊ:<?=implode(', ',$uptypes)?>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    if (!is_uploaded_file($_FILES["upfile"]["tmp_name"]))
    //�Ƿ�����ļ�
    { 
         echo "ͼƬ������!";
         exit;
    }
    $file = $_FILES["upfile"];
 
    if($max_file_size < $file["size"])
    //����ļ���С
    { 
        echo "�ļ�̫��!";
        exit;
    }
 
    if(!in_array($file["type"], $uptypes))
    //����ļ�����
    { 
        echo "�ļ����Ͳ���!".$file["type"];
        exit;
    }
 
    if(!file_exists($destination_folder))
    { 
        mkdir($destination_folder);
    }
 
    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];
    $destination = $destination_folder.time().".".$ftype;
 
    if (file_exists($destination) && $overwrite != true)
    { 
        echo "ͬ���ļ��Ѿ�������";
        exit;
    }
 
    if(!move_uploaded_file ($filename, $destination))
    { 
        echo "�ƶ��ļ�����";
        exit;
    }
 
    $pinfo=pathinfo($destination);
    $fname=$pinfo["basename"];
 
    echo " < font color=red>�Ѿ��ɹ��ϴ�</font><br>�ļ���:  <font color= blue>".$destination_folder.$fname."</font><br>";
    echo " ���:".$image_size[0];
    echo " ����:".$image_size[1];
    echo "<br> ��С:".$file["size"]." bytes";
 
    if($watermark==1)
    { 
        $iinfo=getimagesize($destination,$iinfo);
        $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
        $white=imagecolorallocate($nimage,255,255,255);
        $black=imagecolorallocate($nimage,0,0,0);
        $red=imagecolorallocate($nimage,255,0,0);
        imagefill($nimage,0,0,$white);
        switch ($iinfo[2])
        { 
            case 1:
            $simage =imagecreatefromgif($destination);
            break;
 
            case 2:
            $simage =imagecreatefromjpeg($destination);
            break;
 
            case 3:
            $simage =imagecreatefrompng($destination);
            break;
 
            case 6:
            $simage =imagecreatefromwbmp($destination);
            break;
 
            default:
            die("��֧�ֵ��ļ�����");
            exit;
         }
 
        imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
        imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);
 
        switch($watertype)
        { 
            case 1:   //��ˮӡ�ַ���
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
            break;
 
            case 2:   //��ˮӡͼƬ
            $simage1 = imagecreatefrompng("logo.png");
            imagecopy($nimage,$simage1,40,40,0,0,263,58);
            imagedestroy($simage1);
            break;
         }
 
        switch ($iinfo[2])
        { 
            case 1:
            //imagegif($nimage, $destination);
            imagejpeg($nimage, $destination);
            break;
 
            case 2:
            imagejpeg($nimage, $destination);
            break;
 
            case 3:
            imagepng($nimage, $destination);
            break;
 
            case 6:
            imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);
            break;
         }
 
        //����ԭ�ϴ��ļ�
        imagedestroy($nimage);
        imagedestroy($simage);
    }
 
    if($imgpreview==1)
    { 
        echo "<br>ͼƬԤ��:<br>";
        echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
        echo " alt=\"ͼƬԤ��:\r�ļ���:".$destination."\r�ϴ�ʱ��:\">";
    }
 
}
 
?>
</body>
</html>