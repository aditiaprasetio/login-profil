<?php
/*
* @author dogwin
* date@2012-05-17
*/
/**
* 
* converts PDF to JPG
*
*/
class Export_mdl extends CI_Model{
        function __construct(){
                parent::__construct();
                $this->load->database();
        }
        /**
         * rsvg
         */
        //convert svg to image
        function rsvg($svg,$svgtag='svg'){
                $filesvg = "convert/svg/".$svgtag.time().".svg";
                //write svg to the disk
                $fp = fopen($filesvg,'a');
			fwrite($fp,$svg);
			fclose($fp);
                
                //$filesvg = 'convert/svg/svg1337048926.svg';                
                $filename = "convert/jpg/".$svgtag.time().".png";
                //exec("/usr/local/bin/rsvg -f 'png' ".$filesvg." ".$filename);
                //
                exec("/usr/bin/rsvg -f 'png' ".$filesvg." ".$filename);
                return $filename;
        } 
        /*
         * download
         * pdf 
         * jpg
         */
        function downloadjpg($image,$file_name){
                $imgfp = fopen($image, "r");
			header('Content-Type: image/jpeg');
			header("Content-Disposition:attachment;filename=$file_name");
			header('Content-Type:application/x-download');
			echo   fread($imgfp,filesize($image));
			fclose($imgfp);
			exit;
        }
        /*
         * merge
         */
        function mergeimages($source,$source1){
                //$source = base_url()."css/1336383202.png";  
                //$source1 = base_url()."css/avg1336383203.png";
                $imagename = "convert/jpg/Ptogether".time().".jpg";
                $target = 'convert/model.jpg';  
                   
                $source_img = imagecreatefrompng($source);  
                $source_img1 = imagecreatefrompng($source1);  
                $target_img = imagecreatefromjpeg($target);  
                  
                $size = getimagesize($source);  
                $size1 = getimagesize($source1);  
                // print_r($size);
                // print_r($size1);   
                imagecopy ($target_img,$source_img,0,0,0,0,$size[0],$size[1]);  
                imagecopy ($target_img,$source_img1,0,230,0,0,$size1[0],$size1[1]);  
                imagejpeg($target_img,$imagename);
                return $imagename;
                
        }
        /**
         * convert pdf to images
         */
        function pdf2image($pdf_name,$pdf_full_path,$file_name,$type,$path,$page){
                $im = new Imagick();
                //$im->setResolution(1200,1200);
                $im->setCompression(Imagick::COMPRESSION_JPEG);
                $im->setCompressionQuality(100);
                //$im->readImage($file_name."[$page]");
                
                //print_r($im);
                if($page==-1)
                        $im->readImage($file_name);
                else
                        $im->readImage($file_name."[$page]");
                        foreach ($im as $Key => $Var){
                                $Var->setImageFormat($type);
                                $image_name = md5($Key.time()).'.'.$type;
                                $filename = $path.$image_name;
                                //$width = $Var->getImageWidth();
                                //$height = $Var->getImageHeight();
                                if($Var->writeImage($filename) == true){
                                        $Return[] = array(
                                                'error'=>FALSE,
                                                'msg'=>'',
                                                'file_name'=>$image_name,
                                                'file_type'=>$type,
                                                'full_path'=>$filename,
                                                'is_image'=>true,
                                                'is_pdf'=>true,
                                                'image_width'=>$Var->getImageWidth(),
                                                'image_height'=>$Var->getImageHeight(),
                                                'image_type'=>$type,
                                                'pdf_name'=>$pdf_name,
                                                'pdf_full_path'=>$pdf_full_path,
                                        );
                                }
                        }  
                return $Return;
                $im->clear();
                $im->destroy();
        }
}
?>