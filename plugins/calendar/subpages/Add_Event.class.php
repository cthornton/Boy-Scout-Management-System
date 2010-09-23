<?php
class subpage extends flowController implements controllable
{
    private $v;
    
    public function __construct()
    {
        parent::__construct();
        $this->v = new validate();
        template::assign('loadCalendar', true);
    }
    
    public function GET()
    {
        if(isset($_POST['submit']))
        {
            $this->validatePost();
            
            if($this->v->isError())
            {
                $this->assignErrors();
            }
            else
            {
               
               $mdy = explode('/', $_POST['date']);
               
               $repeats = empty($_POST['repeats']) ? 0 : 1;
               
               // Insert it!
               $this->db->query("INSERT INTO calendar
                                  (`month`, `day`, `year`, `title`, `description`, `recuring`, `recuring_type`, `recuring_length`)
                                 VALUES
                                  (?, ?, ?, ?, ?, ?, ?, ?)",
                                  array($mdy[0], $mdy[1], $mdy[2], htmlentities($_POST['title']), htmlentities($_POST['desc']),
                                        $repeats, $_POST['repeattype'], $_POST['repeatlen']), 'iiissiii');
                
                if($repeats == 1)
                    $this->handleRecuring($mdy[0], $mdy[1], $mdy[2]);
                    
                template::assign('success', true);
            }
            

        }
        
        template::customCSS('plugins/admin/ui/addpage.css');
        template::assign('title', 'Create new Calendar Event');
        $this->template->addTemplate('create');
    }
    
    public function forward($name)
    {
        $this->db->query("SELECT * FROM calendar WHERE ID=?", $name,  'i');
        
        // See if it exists!
        if($this->db->numRows() != 1)
            throw new notfound_exception();
        
        $info = $this->db->easyArray();
        
        if(isset($_POST['submit']))
        {
            if($_POST['submit'] == "Delete")
            {
                $this->db->query('DELETE FROM calendar WHERE id=?', $name, 'i');
                $this->db->query('DELETE FROM calendar_recuring WHERE id_cal=?', $name, 'i');
                
                throw new http_redirect('?page=calendar&month=' . $info[1]);
            }
            else
            {
            
                $this->validatePost();
                $this->assignErrors();
                
                if(!$this->v->isError())
                {
                   template::assign('isError', false);
                   
                   $mdy = explode('/', $_POST['date']);
                   
                   $repeats = empty($_POST['repeats']) ? 0 : 1;
                   
                   // Insert it!
                   $this->db->query("UPDATE calendar SET
                                        month=?, day=?, year=?, title=?, description=?, recuring=?, recuring_type=?, recuring_length=?
                                     WHERE id=?",
                                      array($mdy[0], $mdy[1], $mdy[2], htmlentities($_POST['title']), htmlentities($_POST['desc']),
                                            $repeats, $_POST['repeattype'], $_POST['repeatlen'], $name), 'iiissiiii');
                    
                    $this->db->query("DELETE FROM calendar_recuring WHERE id_cal=?", $name, 'i');
                    
                    if($repeats == 1)
                    {
                        $this->handleRecuring($mdy[0], $mdy[1], $mdy[2], $name);
                    }   
                    template::assign('success', true);
                }
            }
            
        }
        else
        {
            template::assign('date', $info[1] . '/' . $info[2] . '/'. $info[3]);
            template::assign('eTitle', $info[4]);
            template::assign('repeats', $info[6]);
            template::assign('rtype', $info[7]);
            template::assign('repeatlen', $info[8]);
            template::assign('descript', $info[5]);
        }
        
        template::customCSS('plugins/admin/ui/addpage.css');
        
        template::assign('eid', $name);
        template::assign('editmode', true);
        template::assign('title', 'Edit Calendar Event');
        $this->template->addTemplate('create');
    
    }
    
    public function validatePost()
    {
        
        $this->v->check($_POST['title'], 'The title must be between 1 and 20 characters long', null, 1, 20);
        $this->v->check($_POST['date'], 'Please enter a valid date (mm/dd/yyyy)', '/^([1-9]{1}|[0-3]{1}[0-9]{1})\/([0-9]{1}|[0-3]{1}[0-9]{1})\/[0-9]{4}$/');
        $this->v->check($_POST['desc'], 'Please enter something for the description');
        if(!empty($_POST['repeats']))
            $this->v->check($_POST['repeats'], 'Recurring should be a 1 or empty', '/^[0-1]{1}$/', 1, 1);
        $this->v->check($_POST['repeattype'], 'The type repeating type isn\'t valid', '/^[0-9]{1}$/', 1, 1);
        $this->v->check($_POST['repeatlen'], 'The recurring length isn\'t valid', '/^[0-9]{1,2}$/', 1, 2);
    }
    
    private function assignErrors()
    {
        template::assign('isError', true);
        template::assign('errors', $this->v->getErrors());
    
        template::assign('date', htmlentities($_POST['date']));
        template::assign('eTitle', htmlentities($_POST['title']));
        template::assign('repeats', ($_POST['repeats'] == 1));
        template::assign('rtype', $_POST['repeattype']);
        template::assign('repeatlen', $_POST['repeatlen']);
        template::assign('descript', htmlentities($_POST['desc']));
    }
    
    
    private function handleRecuring($month, $day, $year, $calid = 0)
    {
        $tmpmonth = $month;
        $tmpyear  = $year;
        $tmpday   = $day;
        $rtype    = $_POST['repeattype'];
        
        switch($_POST['repeattype'])
        {
            // Daily
            case 1:
                $v = 1;
                break;
            // Weekly
            case 2:
                $v = 7;
                break;
            // Monthly
            case 3:
                $v = 32;
                break;
        }
        
        $day_of_month = date('w', mktime(0, 0, 0, $tmpmonth, 1, $tmpyear)) + 1;
        
        for($i = 0; $i < $_POST['repeatlen']; $i++)
        {
            if($tmpmonth >= 12)
            {
                $tmpyear++;
                $tmpmonth = 1;
            }
            
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $tmpmonth, $tmpyear);
            
            
            // Daily
            if($rtype == 1)
            {
                $tmpday++;
                
                if($tmpday >= $days_in_month)
                {
                    $tmpday = 0;
                    $tmpmonth++;
                }
                
                
            }
            
            // Weekly
            else //if($rtype == 2)
            {
                $tmpday += 7;
                
                if($tmpday > $days_in_month)
                {
                    $tmpday -= $days_in_month;
                    $tmpmonth++;
                }
            }
            
            
            if($calid == 0)
            {
                $this->db->query("INSERT INTO calendar_recuring (id_cal, month, day, year)
                      VALUES ((SELECT id FROM calendar ORDER BY id DESC LIMIT 1), ?, ?, ?)", array($tmpmonth, $tmpday, $tmpyear), 'iii');
            }
            else
            {
                $this->db->query("INSERT INTO calendar_recuring (id_cal, month, day, year)
                  VALUES (?, ?, ?, ?)", array($calid, $tmpmonth, $tmpday, $tmpyear), 'iiii');
            }
        }
    }
    
    private function calcTime($month, $year)
    {
        $time = $_POST['repeatlen'];
        
        switch($_POST['repeattype'])
        {
            // Daily
            case 1:
                $v = $time * 86400;
                break;
            // Weekly
            case 2:
                $v = $time * 86400 * 7;
                break;
            // Monthly
            case 3:
                $v = $time * 86400 * 7 * 31;
                break;
            default:
                return 0;
                break;
        }
        
        return mktime(0, 0, 0, $month, 0, $year) + $time;
    }
}
?>