<?php

namespace api\common\components;

use Yii;
use common\models\User;
use yii\rest\ActiveController;

use common\components\SmsHelper;

use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class BaseController extends ActiveController
{
	public function init(){
		parent::init();
	}

    public function generateVerificationLink() {
        $length = 100;
		$rstring = "";
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@$^*()_-';
		$rstring = '';
		for ($i = 0; $i < $length; $i++) {
			$rstring .= $characters[rand(0, strlen($characters)-1)];//echo "<br>";
		}
		if(User::findByVerificationLink($rstring)){
			$this->generateVerificationLink();
		}
        return $rstring;
    }
	
    public function getOtp($length = 4) {
        $chars = '0123456789';
        $result = '';
        for ($p = 0; $p < $length; $p++)
        {
            $result .= $chars[mt_rand(0, 9)];
        }
		return $result;
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {  
	    $earth_radius = 6371000;

	    $dLat = deg2rad($latitude2 - $latitude1);  
	    $dLon = deg2rad($longitude2 - $longitude1);

	    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
	    $c = 2 * asin(sqrt($a));
	    $d = $earth_radius * $c;
	      
	    return $d;  
	}
	
	protected function checkAuth(){
		$auth_key = Yii::$app->request->post("auth_key");
		if(!$auth_key){
			throw new BadRequestHttpException("User Auth Key is missing.");
		}
		$user = User::findByAuthKey($auth_key);
		if(!$user){
			throw new UnauthorizedHttpException("User is not registered.");
		}
		return $user;
	}

	protected function successResponse($data)
	{
		return ['success' => 'true', 'data' => $data];
	}

	protected function errorResponse($msg)
	{
		return ['error' => 'true', 'message' => $msg];
	}
}