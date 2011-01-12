<?php
require_once(dirname(__FILE__) . '/app.php');

/*!
 * upload demo for php
 * @requires xhEditor
 * 
 * @author Yanis.Wang<yanis.wang@gmail.com>
 * @site http://pirate9.com/
 * @licence LGPL(http://www.opensource.org/licenses/lgpl-license.php)
 * 
 * @Version: 0.9.2 build 100225
 * 
 * 注：本程序仅为演示用，请您根据自己需求进行相应修改，或者重开发。
 */
header('Content-Type: text/html; charset=UTF-8');

function uploadfile($inputname)
{
	global $INI;
	$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;
	$attachdir='upload';//上传文件保存路径，结尾不要带/
	$dirtype=1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
	$maxattachsize=2097152;//最大上传大小，默认是2M
	$upext='jpg,jpeg,gif,png';//上传扩展名
	$msgtype=2;//返回上传参数的格式：1，只返回url，2，返回参数数组
	
	$err = "";
	$msg = "";
	if(!isset($_FILES[$inputname]))return array('err'=>'文件域的name错误或者没选择文件','msg'=>$msg);
	$upfile=$_FILES[$inputname];
	if(!empty($upfile['error']))
	{
		switch($upfile['error'])
		{
			case '1':
				$err = '文件大小超过了php.ini定义的upload_max_filesize值';
				break;
			case '2':
				$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
				break;
			case '3':
				$err = '文件上传不完全';
				break;
			case '4':
				$err = '无文件上传';
				break;
			case '6':
				$err = '缺少临时文件夹';
				break;
			case '7':
				$err = '写文件失败';
				break;
			case '8':
				$err = '上传被其它扩展中断';
				break;
			case '999':
			default:
				$err = '无有效错误代码';
		}
	}
	elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = '无文件上传';
	else
	{
		$fileinfo=pathinfo($upfile['name']);
		$extension=strtolower($fileinfo['extension']);
		if(preg_match('/'.str_replace(',','|',$upext).'/i',$extension))
		{
			$filesize=$upfile['size'];
			if($filesize > $maxattachsize)$err='文件大小超过'.$maxattachsize.'字节';
			else
			{
				$year = date('Y');
				$day = date('md');
				$n = time().rand(1000,9999).'.jpg';
				$attach_dir = IMG_ROOT . "/team/{$year}/{$day}";
				RecursiveMkdir( IMG_ROOT . "/team/{$year}/{$day}" );
				$fname= time().rand(1000,9999).'.'.$extension;
				$target = $attach_dir.'/'.$n;
				if ( is_resource($upfile['tmp_name']) ) {
					$data = fread($upfile['tmp_name'], $filesize);
					file_put_contents($target, $data);
					$image_size = getimagesize($target);
					mark_image($image_size, $target, IMG_ROOT .'/logo.png');
					fclose($upfile['tmp_name']);
				} else {
					move_uploaded_file($upfile['tmp_name'],$target);
					$image_size = getimagesize($target);
					mark_image($image_size, $target, IMG_ROOT .'/logo.png');
					@unlink($upfile['tmp_name']);
				}
				
				$target = $INI['system']['imgprefix']."/static/team/{$year}/{$day}/{$n}";
				
				if($immediate=='1')$target='!'.$target;
				if($msgtype==1)$msg=$target;
				else $msg=array('url'=>$target,'localname'=>$upfile['name'],'id'=>'1');//id参数固定不变，仅供演示，实际项目中可以是数据库ID
			}
		}
		else $err='上传文件扩展名必需为：'.$upext;

		if (is_resource($upfile['tmp_name'])) {fclose($upfile['tmp_name']);}
		else { @unlink($upfile['tmp_name']); }
	}
	return array('err'=>$err,'msg'=>$msg);
}

//HTML5 上传
if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])) {
    if(preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)) {
        $temp_name = tmpfile();
		$content = file_get_contents("php://input");
		fwrite($temp_name, $content);
		fseek($temp_name, 0);
        $size = strlen($content);
        $_FILES[$info[1]]=array('name'=>$info[2],'tmp_name'=>$temp_name,'size'=>$size,'type'=> '','error'=>0); 
    }
}
//End HTML5 

$state=uploadfile('filedata');
echo json_encode($state);
