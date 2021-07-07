<?php
    class time {
        public function __construct($timeAgo) {
            $timeAgo = strtotime($timeAgo) ? strtotime($timeAgo) : $timeAgo;
            $time = time() - $timeAgo;
            $time = ($time + 4 * 60 * 60) + 30 * 60;

            switch ($time) {
                case $time <= 60:
                    return ($time == 1) ? 'Just now' : $time.' secs';

                case $time >= 60 && $time < 3600:
                    return (round($time  / 60) == 1) ? '1 min' : round($time / 60).' mins';

                case $time >= 3600 && $time < 86400:
                    return (round($time / 3600) == 1) ? '1 hour' : round($time / 86400).' hours';

                case $time >= 86400 && $time < 604800:
                    return (round($time / 86400) == 1) ? '1 day' : round($time / 604800).' days';

                case $time >= 604800 && $time < 2600640:
                    return (round($time / 604800) == 1) ? '1 week' : round($time / 2600640).' weeks';
                
                case $time >= 2600640 && $time < 31207680:
                    return (round($time / 2600640) == 1) ? '1 month' : round($time / 31207680).' months';

                case $time >= 31207680:
                    return (round($time / 31207680) == 1) ? '1 year' : round($time / 31207680).' years';
            }
        }

        public function normalizeTime($time) {
            $str = strtotime($time);
            return date('d-F-Y h:i:s a', $str);
        }
    }