<script language=JavaScript>
<!--
var message="Computer Engineering";
	function click(e) {
		if (document.all) {
			if (event.button == 2) {
				alert(message);
				return false;
				}
				}
				if (document.layers) {
if (e.which == 3) {
alert(message);
return false;
}
}
}
if (document.layers) {
document.captureEvents(Event.MOUSEDOWN);
}
document.onmousedown=click;
// --> 
</script>

<?php
function CopyImage($page,$pic_name, $image_name, $image_type, $image_size ){
		if($image_size==0 ){
			echo "<script>alert('Your file more than 2 MB.');</script>";
			return false;
		}else{
			if( $image_type == "image/jpeg" ){
				$type = ".jpg";
			}else 
			if( $image_type == "image/pjpeg" ){
				$type = ".jpg";
			}else 
			if( $image_type == "image/gif" ){
				$type = ".gif";
			}else 
			if( $image_type == "image/x-png" ){
				$type = ".png";
			}else 
			if( $image_type == "image/bmp" ){
				$type = ".bmp";
			}
			if( $image_type == "application/octet-stream" ){
				$type = ".zip";
			}
			if( $image_type == "application/octet-stream" ){
				$type = ".rar";
			}
			if( $image_type == "application/octet-stream" ){
				$type = ".pdf";
			}			
			if(is_uploaded_file($image_type))
			{     
				copy($image_type, "file/".$page."/".$pic_name.$type);
				$image = "file".$page."/".$pic_name.$type;
			}else{
				echo "No is_uploaded_file";
			}
			return $image;
		}

}

function fileDownload( $page,$filename, $f_name,$f_nm, $f_type, $f_size ){
		if($f_size > 20480000 ){
			echo "<script>alert('Your file more than 2 MB.');</script>";
			return false;
		}else{
				$array_last = explode( ".", $f_nm );
				$c = count( $array_last )-1;
				$type = strtolower( $array_last[$c] );
					if (is_uploaded_file($f_name))
					{     
						copy($f_name, "file/".$page."/".$filename.".".$type);
						$file = "file/".$page."/".$filename.".".$type;
					}else{
						echo "No is_uploaded_file";
					}
			return $file;
	   }
}

?>
