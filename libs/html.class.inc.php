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

                $pages_html = "<div class='pagination'><ul class='pagination'>";
                if ($current_page > 1) {
                        $start_record = $start - $count;
                        $pages_html .= "<li><a class='pagination_button' href='" . $url . $start_record . "'><i class='fa-solid fa-backward'></i></a></li> ";
                }
                else {
                        $pages_html .= "<li><a class='pagination_button' href='#'><i class='fa-solid fa-backward'></i></a></li>";
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
                        $pages_html .= "<a class='pagination_button' href='" . $url . $start_record . "'>" . $page_number . "</a></li>";
                }

                if ($current_page < $num_pages) {
                        $start_record = $start + $count;
                        $pages_html .= "<li><a class='pagination_button' href='" . $url . $start_record . "'><i class='fa-solid fa-forward'></i></a></li> ";
                }
                else {
                        $pages_html .= "<li disabled><a class='pagination_button' href='#'><i class='fa-solid fa-forward'></i></a></li>";
                }
                $pages_html .= "</ul></div>";
                return $pages_html;

        }








}

?>
