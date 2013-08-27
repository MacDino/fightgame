<?php
//测试流程专用类
class Test
{
    public static function getMacAddress()
    {
        switch(PHP_OS){
            case 'WIN32':
            case 'WINNT':
            case 'Windows':
              $macAddress = self::_getWindowMacAddress();
              break;
            default:
              $macAddress = self::_getLinuxMacAddress();
              break;
        }
        if($macAddress)
        {
            foreach ( $macAddress as $value )
            { 
                  if (preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value, $temp_array ))
                  {  
                      return strtoupper($temp_array[0]);
                      break;
                  }  
            
            }   
        
        }
        return 'EC:6C:9F:0E:A4:36';
    }

    private static function _getWindowMacAddress()
    {
        @exec("ipconfig /all", $macAddress); 
        if($macAddress)
        {
            return $macAddress;
        }else{
            $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";  
            if(is_file($ipconfig))
            { 
                @exec($ipconfig." /all", $macAddress); 
            }else{ 
              @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $macAddress);
            } 
            return $macAddress;
        }
    }

    private static function _getLinuxMacAddress()
    {
        @exec("ifconfig -a", $macAddress);  
        return $macAddress;
    }
}
