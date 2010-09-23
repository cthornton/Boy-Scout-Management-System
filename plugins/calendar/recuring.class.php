<?php
class recuring
{
    public static $DAILY = 1, $WEEKLY = 2, $MONTHLY = 3, $YEARLY = 4;
    
    
    // Note: this isn't uploaded to FTP yet...
    public static function num2name($num)
    {
        switch($num)
        {
            case self::$DAILY: return 'daily'; break;
            case self::$WEEKLY: return 'weekly'; break;
            case self::$MONTHLY: return 'monthly'; break;
            case self::$YEARLY: return 'yearly'; break;
            default: return 'unknown'; break;
        }
    }
}

?>