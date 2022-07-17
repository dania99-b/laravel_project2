<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send(Request $request)
    {


    /**
     * Write code on Method
     *
     * @return response()
     */

        try {
            $tokens = [];
            $tokens[] = '90|1Aq68H49MBIPkgM7fpF9eyQEiqO5GuUhfpRoGSAK';
            $serverKey = 'AAAAB5opTlw:APA91bFubtjflF96aVcHg4NHKE_IWiY47Cs_u49gvw298Pb0LG5ag18CCf0sufI165f099qd_nnaiTOkc-1hXwC3tQH4DmNH6eiGEWfvr2KvKnaZT-A3FzMwLBGrOGLemee5jogNC_wj';
            $msg = array(
                'title'     => 'لماذا نحن هنا',
                'body' => 'سؤااال صعب',
            );
            $notifyData = [
                'title'     => 'لماذا نحن هنا',
                'body' => 'سؤاااااال صعب',
            ];
            $registrationIds = $tokens;
            if (count($tokens) > 1) {
                $fields = array(
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data' => $msg,
                    'priority' => 'high'
                );
            } else {
                $fields = array(
                    'to' => $registrationIds[0], //  for  only one users
                    'notification'  => $notifyData,
                    'data' => $msg,
                    'priority' => 'high'
                );
            }
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key=' . $serverKey;
            $URL = 'https://fcm.googleapis.com/fcm/send';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
        } catch (\Exception $e) {
        }


        return $result;

        return $response;
    }
}
