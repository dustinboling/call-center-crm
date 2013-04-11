<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Calendar {

    protected $calendar_type = 'month';
    protected $set_today = false;
    protected $today = 0;
    protected $day_num = 0;
    protected $days_loop = 35;
    protected $base_date;
    protected $last_day;
    protected $first_day_code;
    protected $items;
    protected $item_range_start;
    protected $item_range_end;
    protected $day_link_path;
    protected $week_link_path;
    protected $month_link_path;

    function setCalendarType($type) {
        $this->calendar_type = $type;
    }

    function setBaseDate($date=null) {

        if ($this->calendar_type == 'month') {
            if (is_null($date)) {
                $this->base_date = date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
            } else {
                $this->base_date = date("m/d/Y", strtotime(date('m', strtotime($date)).'/01/'.date('Y', strtotime($date)).' 00:00:00'));
            }
            $last_date = date("m/d/Y H:i:s", strtotime('-1 second',strtotime('+1 month',strtotime($this->base_date))));
            $this->last_day = date('j', strtotime($last_date));
            $this->first_day_code = date('w', strtotime($this->base_date));
            $num_days = date('t', strtotime($this->base_date));
            $this->item_range_start = strtotime($this->base_date);
            $this->item_range_end = strtotime($last_date);
            // account for a 6 week calendar
            if ($num_days > 29 && $this->first_day_code > 5) {
                $this->days_loop = 42;
            }
        } else if ($this->calendar_type == 'week') {
            if (is_null($date)) {
                $parts = getdate();
                if ($parts['wday']) {
                    $this->base_date = date("m/d/Y", strtotime('last sunday', time()));
                } else {
                    $this->base_date = date("m/d/Y");
                }
            } else {
                $this->base_date = $date;
            }
        } else {
            if (is_null($date)) {
                $this->base_date = date("m/d/Y");
            } else {
                $this->base_date = $date;
            }
        }
    }

    function setItem($item){
        $key = $item['key'];
        unset($item['key']);
        $this->items[$key][] = $item;
    }

    function enableToday() {
        if (date('F Y') == date('F Y', strtotime($this->base_date))) {
            $this->set_today = true;
            $this->today = date('j');
        }
    }

    function setDayBaseUri($path) {
        $this->day_link_path = $path;
    }

    function setWeekBaseUri($path) {
        $this->week_link_path = $path;
    }

    function setMonthBaseUri($path) {
        $this->month_link_path = $path;
    }

    function getMonthCalendar() {

        $headers = array(14,14,14,14,14,14,14,2);

        $table_markup = '<h1 class="calendar_header">'.date('F Y', strtotime($this->base_date)).'</h1><table class="table calendar"><thead><tr>';
        if (strlen($this->week_link_path)) {
            $table_markup .= '<th width="'.$headers[7].'%">&nbsp;</th>';
        } else {
            $headers[0] = 15;
            $headers[6] = 15;
        }
        $table_markup .= '<th width="'.$headers[0].'%">Sunday</th>
            <th width="'.$headers[1].'%">Monday</th>
            <th width="'.$headers[2].'%">Tuesday</th>
            <th width="'.$headers[3].'%">Wednesday</th>
            <th width="'.$headers[4].'%">Thursday</th>
            <th width="'.$headers[5].'%">Friday</th>
            <th width="'.$headers[6].'%">Saturday</th>
            </tr></thead><tbody>';

        for ($i = 0; $i < $this->days_loop; $i++) {
            $open_row = array(0,7,14,21,28,35,42);
            $close_row = array(6,13,20,27,34,41);

            $classes = array();
            if ($this->set_today && $this->day_num == $this->today) {
                $classes[] = 'today';
            }

            if (in_array($i, $open_row) || in_array($i, $close_row)) {
                $classes[] = 'weekend';
            }

            if ($i <= 6 && !$this->day_num) {
                if ($i == $this->first_day_code) {
                    $this->day_num = 1;
                } else {
                    $this->day_num = 0;
                }
            }

            $past = true;
            if ($this->day_num) {
                $current_date = date("m", strtotime($this->base_date)).'/'.$this->day_num.'/'.date("Y", strtotime($this->base_date)).' 00:00:00';
                if (strtotime($current_date) >= strtotime(date('m/d/Y 00:00:00'))) {
                    $past = false;
                }
            }

            if (!$this->day_num) {
                $classes[] = 'dead_day';
            }

            if (in_array($i, $open_row)) {
                $table_markup .= '<tr>';
                if (strlen($this->week_link_path)) {
                    if (!isset($current_date)) {
                        $current_date = $this->getWeekStart();
                    }
                    $table_markup .= '<td><a class="week_link" title="Week View" href="'.$this->week_link_path.'?w='.strtotime($current_date).'">&nbsp;</a></td>';
                }
            }

            $table_markup .= '<td class="'.  implode(' ', $classes).'">';
            if ($this->day_num) {
                $table_markup .= '<div class="day_num">';
                if (strlen($this->day_link_path) && !$past) {
                    $table_markup .= '<a class="day_link" href="'.$this->day_link_path.'?d='.strtotime($current_date).'">'.$this->day_num.'</a>';
                } else {
                    $table_markup .= $this->day_num;
                }
                $table_markup .= '</div>';
                $table_markup .= '<div class="appointments">';

                $keys = $this->getItemsInRange($current_date);

                if (!empty($keys)) {
                    foreach ($keys as $k) {
                        $items_set = $this->items[$k];
                        foreach ($items_set as $item) {
                            $table_markup .= '<div title="'.$item['title'].'" class="appointment '.$item['type'].' '.implode(' ', $item['classes']).'">';
                            if (isset($item['link']) && strlen($item['link'])) {
                                $table_markup .= '<a href="'.$item['link'].'">'.$item['title'].'</a>';
                            } else {
                                $table_markup .= $item['title'];
                            }
                            $table_markup .= '</div>';
                        }
                    }
                } else {
                    $table_markup .= '&nbsp;';
                }

                $table_markup .= '</div>';
            } else {
                $table_markup .= '&nbsp;';
            }
            $table_markup .= '</td>';

            if (in_array($i, $close_row)) {
                $table_markup .= '</tr>';
            }

            if ($this->day_num && $this->day_num >= $this->last_day) {
                $this->day_num = 0;
            }

            if ($this->day_num) {
                $this->day_num++;
            }
        }
        $table_markup .= '</tbody></table>';
        return $table_markup;

    }

    function getWeekCalendar() {
        $current_date = $this->base_date;
        $table_markup = '<h1 class="calendar_header">Week of '.date('l, n/j/Y', strtotime($this->base_date)).'</h1><table class="table calendar"><thead><tr><th width="20%">Day</th><th>Tasks &amp; Appointments</th></tr></thead><tbody>';
        for($i=0;$i<7;$i++) {
            $past = true;
            if (strtotime($current_date) >= strtotime(date('m/d/Y 00:00:00'))) {
                $past = false;
            }

            $table_markup .= '<tr><td>';
            if (strlen($this->day_link_path) && !$past) {
                $table_markup .= '<a href="'.$this->day_link_path.'?d='.strtotime($current_date).'">'.date('l, n/j/Y', strtotime($current_date));
            } else {
                $table_markup .= date('l, n/j/Y', strtotime($current_date));
            }
            $table_markup .= '</td>';
            $table_markup .= '<td>';
            $table_markup .= '<div class="appointments">';
            $keys = $this->getItemsInRange($current_date);
            if (!empty($keys)) {
                foreach ($keys as $k) {
                    $items_set = $this->items[$k];
                    foreach ($items_set as $item) {
                        $table_markup .= '<div title="'.$item['title'].'" class="appointment '.$item['type'].' '.implode(' ', $item['classes']).'">';
                        if (isset($item['link']) && strlen($item['link'])) {
                            $table_markup .= '<a href="'.$item['link'].'">'.$item['assignee'].': '.$item['title'].'</a>';
                        } else {
                            $table_markup .= $item['assignee'].': '.$item['title'];
                        }
                        $table_markup .= '<div class="details"><span class="date_display">';
                        if ($item['status'] == 'completed') {
                            $table_markup .= 'Completed: ';
                        } else if ($item['type'] == 'task') {
                            $table_markup .= 'Deadline: ';
                        } else {
                            $table_markup .= 'Appointment: ';
                        }
                        $table_markup .= date('n/j/Y g:i a', strtotime($item['date'].' '.$item['time'])).'</span>';
                        $table_markup .= '<span class="status_display">Status: '.ucwords($item['status']).'</span>';
                        $table_markup .= '<span class="created_display">Created: '.date('n/j/Y g:i a', strtotime($item['created'])).'</span>';
                        $table_markup .= '<span class="creator_display">Created By: '.$item['creator'].'</span>';
                        $table_markup .= '</div></div>';
                    }
                }
            } else {
                $table_markup .= '&nbsp;';
            }
            $table_markup .= '</div></td></tr>';

            $current_date = date('m/d/Y', strtotime('+1 day', strtotime($current_date)));
        }
        $table_markup .= '</tbody></table>';
        return $table_markup;
    }

    function getDayCalendar() {
        $current_date = $this->base_date;
        $table_markup = '<h1 class="calendar_header">'.date('l, n/j/Y', strtotime($this->base_date)).'</h1><table class="table calendar"><thead><tr><th width="20%">Hour</th><th>Tasks &amp; Appointments</th></tr></thead><tbody>';
        $keys = $this->getItemsInRange($current_date);

        for ($i=0;$i<24;$i++) {
            $date_str = $current_date.' '.$i.':00:00';
            $next_hour = strtotime('-1 second', strtotime('+1 hour', strtotime($date_str)));

            $items = array();
            foreach($keys as $k) {
                if ($k >= strtotime($date_str) && $k < $next_hour) {
                    $items[] = $k;
                }
            }

            $h = date('g:i a', strtotime($date_str));
            if ($i < 6 || $i > 20) {
                $row_tag = 'overnight';
            } else if ($i >= 6 && $i < 11) {
                $row_tag = 'morning';
            } else if ($i >= 11 && $i < 15) {
                $row_tag = 'midday';
            } else if ($i >= 15 && $i < 18) {
                $row_tag = 'afternoon';
            } else if ($i >= 18 && $i <= 20) {
                $row_tag = 'evening';
            }
            $table_markup .= '<tr class="'.$row_tag.'">';
            $table_markup .= '<td>'.$h.'</td>';
            $table_markup .= '<td><div class="appointments">';

            foreach ($items as $k) {
                $items_set = $this->items[$k];
                foreach ($items_set as $item) {
                    $table_markup .= '<div title="'.$item['title'].'" class="appointment '.$item['type'].' '.implode(' ', $item['classes']).'">';
                    if (isset($item['link']) && strlen($item['link'])) {
                        $table_markup .= '<a href="'.$item['link'].'">';
                    }
                    $item_time = $current_date.' '.$item['time'];
                    $table_markup .= '('.date('n/j/Y g:ia', strtotime($item_time)).') '.$item['assignee'].': '.$item['title'];
                    if (isset($item['duration']) && strlen($item['duration'])) {
                        $table_markup .= ' <div class="duration">('.$item['duration'].')</div>';
                    }
                    if (isset($item['link']) && strlen($item['link'])) { $table_markup .= '</a>'; }
                    $table_markup .= '<div class="details"><span class="date_display">';
                    if ($item['status'] == 'completed') {
                        $table_markup .= 'Completed: ';
                    } else if ($item['type'] == 'task') {
                        $table_markup .= 'Deadline: ';
                    } else {
                        $table_markup .= 'Appointment: ';
                    }
                    $table_markup .= date('n/j/Y g:i a', strtotime($item['date'].' '.$item['time'])).'</span>';
                    $table_markup .= '<span class="status_display">Status: '.ucwords($item['status']).'</span>';
                    $table_markup .= '<span class="created_display">Created: '.date('n/j/Y g:i a', strtotime($item['created'])).'</span>';
                    $table_markup .= '<span class="creator_display">Created By: '.$item['creator'].'</span>';
                    $table_markup .= '</div></div>';
                }
            }

            $table_markup .= '</div></td>';
            $table_markup .= '</tr>';
        }
        $table_markup .= '</tbody></table>';
        return $table_markup;
    }

    function getWeekStart($date=null) {
        if (is_null($date)) {
            $date = $this->base_date;
        }
        $last_sunday = date('m/d/Y 00:00:00', strtotime('last Sunday', strtotime($date)));
        return $last_sunday;
    }

    function getItemsInRange($date=null) {
        if (is_null($date)) {
            $date = strtotime($this->base_date);
        } else {
            $date = strtotime($date);
        }
        $end_date = strtotime('-1 second', strtotime('+1 day', $date));
        $keys = array();
        if (count($this->items)){
            foreach ($this->items as $k => $i) {
                if ($k >= $date && $k <= $end_date) {
                    $keys[] = $k;
                }
            }
        }
        if (!empty($keys)) {
            sort($keys);
        }
        return $keys;
    }
}