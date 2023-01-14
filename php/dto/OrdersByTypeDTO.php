<?php 

    class OrdersByTypeDTO{

        private $ongoingArray = array();
        private $finalizedArray = array();
        private $canceledArray = array();

        public function __construct($ongoingArray, $finalizedArray, $canceledArray) {
            $this->ongoingArray = $ongoingArray;
            $this->finalizedArray = $finalizedArray;
            $this->canceledArray = $canceledArray;
        }
        

        function set_ongoingArray($ongoingArray) {
            $this->ongoingArray = $ongoingArray;
        }
    
        function get_ongoingArray() {    
            return $this->ongoingArray;
        }

        function set_finalizedArray($finalizedArray) {
            $this->finalizedArray = $finalizedArray;
        }
    
        function get_finalizedArray() {    
            return $this->finalizedArray;
        }

        function set_canceledArray($canceledArray) {
            $this->canceledArray = $canceledArray;
        }
    
        function get_canceledArray() {    
            return $this->canceledArray;
        }

       
    }

?>