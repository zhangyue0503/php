<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/12/8
 * Time: 上午9:33
 */
namespace wild {
    class animal
    {
        function __construct()
        {
            $this->type = "tiger";
        }

        function get_type()
        {
            return $this->type;
        }
    }
}

namespace animal\wild{
    class animal
    {
        static function whereami(){print __NAMESPACE__."\n";}
        function __construct()
        {
            $this->type = "tiger2";
        }

        function get_type()
        {
            return $this->type;
        }
    }
}
namespace animal\domestic{
    class animal
    {
        function __construct()
        {
            $this->type = "dog2";
        }

        function get_type()
        {
            return $this->type;
        }
    }
}