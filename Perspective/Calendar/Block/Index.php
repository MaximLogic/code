<?php
namespace Perspective\Calendar\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }
    static public function makeCal($year, $month) 
    {
        $wday = JDDayOfWeek(GregorianToJD($month, 1, $year), 0);
        if ($wday == 0) $wday = 7;
        $n = - ($wday - 2);
        $cal = [];
        for ($y=0; $y<6; $y++) {
            $row = [];
            $notEmpty = false;
            for ($x=0; $x<7; $x++, $n++) {
                if (checkdate($month, $n, $year)) {
                $row[] = $n;
                $notEmpty = true;
                } else {
                $row[] = "";
                }
            }
            if (!$notEmpty) break;
            $cal[] = $row;
        }
        return $cal;
    }
    public function printCal()
    {
        $now = getdate();
        $cal = Index::makeCal($now['year'], $now['mon']);
        $curday = $now['mday'];
        echo "<table border=1 style='font-size: 20px;'>
            <tr>
            <td>Пн</td>
            <td>Вт</td>
            <td>Ср</td>
            <td>Чт</td>
            <td>Пт</td>
            <td>Сб</td>
            <td style='color:red'>Вс</td>
            </tr>";
            foreach ($cal as $row){
                echo "<tr>";
                foreach ($row as $i=>$v) {
                    if($i == 6){
                        echo "<td style='color:red'>";
                    }
                    else{
                        echo "<td>";
                    }
                    if($v == $curday){
                        echo "<b>$v</b>";
                    }
                    else{
                        echo ($v ? $v : " ");
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
        echo "</table>";
    }
    public function todayDate()
    {
        $date = getdate();
        $day = $date['mday'];
        $month = $date['mon'];
        $year = $date['year'];
        return "$day.$month.$year";
    }
}