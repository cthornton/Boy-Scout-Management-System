<?php
class calendar extends apifunctions
{
    private $month, $year, $events, $revents;
    
    protected $db;
    
    private $tDay, $tMonth, $tYear;
    
    public function __construct($month, $year)
    {
        $this->db = new db();
        // Check for invalid variables!
        if(!is_numeric($month) || $month < 0 || $month > 12)
            $month = date('n');
        
        if(!is_numeric($year) || $year < 1900)
            $year = date('Y');
        
        $this->month = $month;
        $this->year  = $year;
        
        template::assign('month', $month);
        template::assign('year', $year);
        template::assign('monthstr', $this->getMonthStr());
        template::assign('title', 'Calendar - '. $this->getMonthStr() . ' ' . $year);
        
        $this->getEvents();
    }
    
    /**
     * Return the first day of the month
     */
    public function firstDay()
    {
        return date('w' , mktime(0,0,0,$this->month, 1, $this->year)); 
    }
    
    /**
     * Get the number of days in this month
     */
    public function daysInMonth()
    {
        return cal_days_in_month(0, $this->month, $this->year) ; 
    }
    
    /**
     * Return a textual representation of a day in the month
     */
    public function dayToStr($day)
    {
        switch($day)
        {
            case 0:
                return 'Sunday';
            case 1:
                return 'Monday';
            case 2:
                return 'Tuesday';
            case 3:
                return 'Wednesday';
            case 4:
                return 'Thursday';
            case 5:
                return 'Friday';
            case 6:
                return 'Saturday';
            default:
                return 'UNDEFINED';
        }
    }
    
    /**
     * Get a numeric representation of the month
     */
    public function getMonth()
    {
        return $this->month;
    }
    
    /**
     * Get the year
     */
    public function getYear()
    {
        return $this->year();
    }
    
    /**
     * Get a textual representation of the month
     */
    public function getMonthStr()
    {
        return date('F', mktime(0, 0, 0, $this->month, 1, $this->year));
    }
    
    public function getEvents()
    {
        $arr = array();
        // Events in this month
        $this->events = $this->db->query("SELECT id, day, title, description FROM calendar WHERE month=? AND year=?",
                                         array($this->month, $this->year), 'ii');
        
        template::assign('events', $this->db->easyMultiArray());
        
        $arr = array();
        
        $this->revents = $this->db->query("SELECT  calendar.id, calendar_recuring.day, calendar.title, calendar.description, calendar_recuring.id  FROM calendar
                                            RIGHT JOIN calendar_recuring ON calendar.id = calendar_recuring.id_cal
                                            WHERE calendar_recuring.month=? AND calendar_recuring.year=?", array($this->month, $this->year), 'ii');
        
        template::assign('revents', $this->db->easyMultiArray());
    }
    
    
}


?>