<?php

namespace App\Helpers;

use App\Model\MstNumbering;
use App\Model\MstSetting;

class Helper
{

  public static function getSetting()
  {
    $data = [
      "nama_perusahaan" => MstSetting::getPerusahaan(),
      "alamat" => MstSetting::getAlamat(),
      "kelurahan" => MstSetting::getKelurahan(),
      "kecamatan" => MstSetting::getKecamatan(),
      "kota" => MstSetting::getKota(),
      "telp" => MstSetting::getTelp(),
      "email" => MstSetting::getEmail()
    ];

    return $data;
  }

  public static function getNumbering($prefix)
  {
    $last_num = 0;
    $id = 0;
    $num = MstNumbering::findOne($prefix);
    if ($num != null) {
      $last_num = $num->last_num;
      $id = $num->id;
    }

    $last_num += 1; /** ex : 1 */

    if ($last_num <= 9) {
      $last_num = "000".$last_num; /** ex : 0001 */
    } else if ($last_num >= 10 && $last_num <= 99) {
      $last_num = "00".$last_num; /** ex : 0011 */
    } else if ($last_num >= 100 && $last_num <= 999) {
      $last_num = "0".$last_num; /** ex : 0100 */
    }

    MstNumbering::saveNumbering($id, $prefix, $last_num);
    
    $result = $prefix."/".$last_num;

    return $result;
  }
}
