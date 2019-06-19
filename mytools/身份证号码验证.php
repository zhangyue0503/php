<?php
/**
 * Created by PhpStorm.
 * User: 11041
 * Date: 2019/6/10
 * Time: 16:24
 */

/**
 * 获取身份证性别、出生日期
 * @param $idcard
 * @return array
 */
function get_idcard_info($idcard)
{
    //通过身份证号查询出性别与生日
    $birth = strlen($idcard) == 15 ? ('19' . substr($idcard, 6, 6)) : substr($idcard, 6, 8);
    $sex   = substr($idcard, (strlen($idcard) != 15 ? -2 : -1), 1) % 2 ? '2' : '1'; //1为男 2为女
    return [
        'birth' => $birth,
        'sex'   => $sex
    ];

}

/**
 * 身份证校验
 * @param $id
 * @return bool
 */
function is_idcard($id)
{
    $id        = strtoupper($id);
    $regx      = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
    $arr_split = array();
    if (!preg_match($regx, $id)) {
        return FALSE;
    }
    if (15 == strlen($id)) //检查15位
    {
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

        @preg_match($regx, $id, $arr_split);
        //检查生日日期是否正确
        $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else      //检查18位
    {
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $id, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) //检查生日日期是否正确
        {
            return FALSE;
        } else {
            //检验18位身份证的校验码是否正确。
            //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $arr_ch  = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $sign    = 0;
            for ($i = 0; $i < 17; $i++) {
                $b    = (int)$id{$i};
                $w    = $arr_int[$i];
                $sign += $b * $w;
            }
            $n       = $sign % 11;
            $val_num = $arr_ch[$n];
            if ($val_num != substr($id, 17, 1)) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

}
echo is_idcard('445281201702240081');