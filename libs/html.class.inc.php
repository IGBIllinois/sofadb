<?php

class html {

	//get_pages_html()
        //$url - url of page
        //$num_records - number of items
        //$start - start index of items
        //$count - number of items per page
        //returns pagenation to navigate between pages of devices
        public static function get_pages_html($url,$num_records,$start,$count) {

                $num_pages = ceil($num_records/$count);
                $current_page = $start / $count + 1;
                if (strpos($url,"?")) {
                        $url .= "&start=";
                }
                else {
                        $url .= "?start=";

                }

                $pages_html = "<nav><ul>";
                if ($current_page > 1) {
                        $start_record = $start - $count;
                        $pages_html .= "<li><a class='button_link' href='" . $url . $start_record . "'>&laquo;</a></li> ";
                }
                else {
                        $pages_html .= "<li><a class='button_link' href='#'>&laquo;</a></li>";
                }

                for ($i=0; $i<$num_pages; $i++) {
                        $start_record = $count * $i;
                        if ($i == $current_page - 1) {
                                $pages_html .= "<li disabled>";
                        }
                        else {
                                $pages_html .= "<li>";
                        }
                        $page_number = $i + 1;
                        $pages_html .= "<a class='button_link' href='" . $url . $start_record . "'>" . $page_number . "</a></li>";
                }

                if ($current_page < $num_pages) {
                        $start_record = $start + $count;
                        $pages_html .= "<li><a class='button_link' href='" . $url . $start_record . "'>&raquo;</a></li> ";
                }
                else {
                        $pages_html .= "<li disabled><a class='button_link' href='#'>&raquo;</a></li>";
                }
                $pages_html .= "</ul></nav>";
                return $pages_html;

        }








}

?>
