<?php
    $flvImage = '';
    $flvFile = $_GET['vidname'];
    $PlayerPath  = $_GET['playerpath'];
    $str_pos = strrpos($flvFile, ".flv");
    if($str_pos !==false)    { 
        /*$swf_object = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"  width="400" height="400" > 
        <param name="salign" value="lt"> 
        <param name="quality" value="high">   
        <param name="scale" value="noscale"> 
        <param name="wmode" value="transparent"> 
        <param name="movie" value="http://geekfile.googlepages.com/flvplay.swf"> 
        <param name="FlashVars" value="&streamName='.$flvImage.'&skinName=http://geekfile.googlepages.com/flvskin&autoPlay=true&autoRewind=true">  
        <embed width="300" height="300" flashvars="&streamName='.$flvFile.'&autoPlay=false&autoRewind=true&skinName=http://geekfile.googlepages.com/flvskin" quality="high" scale="noscale" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://geekfile.googlepages.com/flvplay.swf" wmode="transparent"> 
        </embed>
        </object>';*/
        $swf_object = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"  width="400" height="270" > 
        <param name="salign" value="lt"> 
        <param name="quality" value="high">   
        <param name="scale" value="noscale"> 
        <param name="wmode" value="transparent"> 
        <param name="allowfullscreen" value="true">    
        <param name="movie" value="'.$PlayerPath.'mediaplayer.swf"> 
        <param name="FlashVars" value="&file='.$flvFile.'&image='.$flvImage.'">  
        <embed width="400" height="270" flashvars="&file='.$flvFile.'&image='.$flvImage.'" quality="high" scale="noscale" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$PlayerPath.'mediaplayer.swf" wmode="transparent"> 
        </embed>
        </object>';
    }
    else    {
        $swf_object = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"  width="400" height="400" > 
        <param name="salign" value="lt"> 
        <param name="quality" value="high">   
        <param name="scale" value="noscale"> 
        <param name="wmode" value="transparent"> 
        <param name="movie" value="'.$flvFile.'"> 
        <embed width="400" height="400" flashvars="&streamName='.$flvFile.'&autoPlay=false&autoRewind=true&skinName=http://geekfile.googlepages.com/flvskin" quality="high" scale="noscale" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'.$flvFile.'" wmode="transparent"> 
        </embed>
        </object>'; 
    }
    echo $swf_object;
    
?>
