<?php
require_once '../includes/connection.php';
require_once '../includes/config.php';

define('PP_SANDBOX_MODE', false); // Be careful when putting it as FALSE (LIVE/REAL MODE)

define('PP_CLIENT_LIVE', 'AStloIVNvDZ_n30kBiHycjf4pK7hSk0dT6S3-3ihb-ZpWB2pPjYb7RGQv9QE2NtHPS3pKBfK5J8KYJfc');
define('PP_SECRET_LIVE', 'EIz8o1Jgd-NYKFXc_54DoU14WTYqtDBPXqGT8vcOYeW8jlHF7O1fwx2xdeRUlsE_K9r94tYzmFXxUncH');
define('PAYPAL_API_LIVE', 'https://api.paypal.com/v1');

define('PP_CLIENT_SANDBOX', 'AaQV1ugAFd1HooSimvoJfhI1ofD-thcNAGaHukdRMtGmPKVVGDAaKdTTQtUqEgGSes0ld3QraEpxYo2i');
define('PP_SECRET_SANDBOX', 'EJYzT_qWLIvoQgQToFcY1kaEdkuIaxFra6rQ3AaCnM9JmWTryyk9FyJs11jL0Knk6WsBWpxg2VWNS_fP');
define('PAYPAL_API_SANDBOX', 'https://api.sandbox.paypal.com/v1');

define('PP_CLIENT', !PP_SANDBOX_MODE ? PP_CLIENT_LIVE : PP_CLIENT_SANDBOX);
define('PP_SECRET', !PP_SANDBOX_MODE ? PP_SECRET_LIVE : PP_SECRET_SANDBOX);
define('PAYPAL_API', !PP_SANDBOX_MODE ? PAYPAL_API_LIVE : PAYPAL_API_SANDBOX);

if(isset($_GET['test_auth'])) {
    echo PPPayment::requestToken() ? 1 : 0;
}

class PPPayment {
    private $lang = 'en';
    private $currency = 'USD';

    public function __construct($lang = 'en', $currency = 'USD') {
        $this->lang = $lang;
        $this->currency = strtoupper($currency);
    }

    public static function requestToken() {
        $ch = curl_init();
        $clientId = PP_CLIENT;
        $secret = PP_SECRET;
        curl_setopt($ch, CURLOPT_URL, PAYPAL_API.'/oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLVERSION , 6);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);
        $accessToken = null;

        if (!empty($response)) {
            $responseObj = json_decode($response);
            if (isset($responseObj->access_token))
                $accessToken = $responseObj->access_token;
        }

        return $accessToken;
    }

    public function createCoursesPayment($userID, array $paymentCourses, array $paymentTranslations) {

        $conn = $this->getMysqliConn();
        $user = $conn->query("SELECT * FROM usuarios WHERE id = '$userID'")->fetch_assoc();
        $exists = $user != null;

        if (!$exists || count($paymentCourses) == 0 && count($paymentTranslations) == 0)
            return null;

        // Sets the exiting courses that correspond with requested courses or translation courses.
        $userCourses = $conn->query("SELECT c.* FROM cursoasientos cu LEFT JOIN cursos c ON c.id = cu.curso WHERE usuario = " . $user['id'])->fetch_all(MYSQLI_ASSOC);
        $paymentCourses_verified = [];
        $paymentTranslations_verified = [];
        
        foreach($userCourses as $userCourse) {
            foreach($paymentCourses as $pCourse)
                if ($userCourse['id'] == $pCourse) {
                    $paymentCourses_verified[] = $userCourse;
                    break;
                }
            foreach($paymentTranslations as $pTrans)
                if ($userCourse['id'] == $pTrans) {
                    $paymentTranslations_verified[] = $userCourse;
                    break;
                }
        }
        
        $accessToken = PPPayment::requestToken();

        if (!empty($accessToken)) {

            $total = 0;
            $currency = $this->currency;
            $items = [];
            $priceField = 'precio' . ($this->currency == 'USD' ? 'usd' : '');
            $courseTitleField = 'titulo' . ($this->lang == 'es' ? 'es' : 'en');

            $courseLabel = $this->lang == 'es' ? 'Curso: ' : 'Course: ';
            $transLabel = $this->lang == 'es' ? 'Traducción: ' : 'Translation: ';
            $courseDescription = $this->lang == 'es' ? '*Primer pago de curso*' : '*First course payment*';
            $transDescription = $this->lang == 'es' ? '*Pago de traducción*' : '*Translation payment*';
            $paymentDescription = $this->lang == 'es' ? 'Primer pago de cursos y pago de traducciones.' : 'First course payments and translation payments.';

            foreach($paymentCourses_verified as $pCourse) {

                $total += (float) $pCourse[$priceField];
                $items[] = [
                    "name" => html_entity_decode($courseLabel . $pCourse[$courseTitleField]),
                    "description" => html_entity_decode($courseDescription),
                    "quantity" => 1,
                    "price" => $pCourse[$priceField],
                    "currency" => $this->currency,
                ];
            }

            // Only allows to buy translations if currency is USD.
            if ($this->currency == 'USD') {
                foreach($paymentTranslations_verified as $pCourse) {
                    $price = $pCourse['precio_traduccion_usd'];
                    $total += (float) $price;
                    $items[] = [
                        "name" => html_entity_decode($transLabel . $pCourse[$courseTitleField]),
                        "description" => html_entity_decode($transDescription),
                        "quantity" => 1,
                        "price" => $price,
                        "currency" => 'USD',
                    ];
                }
            }

            $paymentData = [
                "intent" => "sale",
                "payer" => [
                  "payment_method" => "paypal"
                ],
                "application_context" => [
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "commit" 
                ],
                "transactions" => [
                  [
                    "amount" => [
                      "total" => $total,
                      "currency" => $this->currency,
                    ],
                    "description" => $paymentDescription,
                    "payment_options" => [
                      "allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
                    ],
                    "item_list" => [
                      "items" => $items
                    ]
                  ]
                ],
                "redirect_urls" => [
                  "return_url" => "https://viannainmexico.com/en/inscripcion?payment_approved",
                  "cancel_url" => "https://viannainmexico.com/en/inscripcion?payment_canceled"
                ]
            ];

            $paymentDataJson = json_encode($paymentData);
            $headers = array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
                'Content-length: ' . strlen($paymentDataJson),
            );

            $curl = curl_init(PAYPAL_API.'/payments/payment');

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $paymentDataJson);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl); 
            curl_close($curl);
            $response = json_decode($response);
   
            if (empty($response) || empty($response->id))
                return null;

            return $response->id;
        } 
        else {
            return null;
        }
    }

    public function executeCoursesPayment($userID, array $paymentCourses, array $paymentTranslations, $paymentID, $payerID) {

        $conn = $this->getMysqliConn();
        $user = $conn->query("SELECT * FROM usuarios WHERE id = '$userID'")->fetch_assoc();
        $exists = $user != null;

        if (!$exists || count($paymentCourses) == 0 && count($paymentTranslations) == 0)
            return 0;

        // Sets the exiting courses that correspond with requested courses or translation courses.
        $userCourses = $conn->query("SELECT c.* FROM cursoasientos cu LEFT JOIN cursos c ON c.id = cu.curso WHERE usuario = " . $user['id'])->fetch_all(MYSQLI_ASSOC);
        $paymentCourses_verified = [];
        $paymentTranslations_verified = [];
        
        foreach($userCourses as $userCourse) {
            foreach($paymentCourses as $pCourse)
                if ($userCourse['id'] == $pCourse) {
                    $paymentCourses_verified[] = $userCourse;
                    break;
                }
            foreach($paymentTranslations as $pTrans)
                if ($userCourse['id'] == $pTrans) {
                    $paymentTranslations_verified[] = $userCourse;
                    break;
                }
        }
  
        $accessToken = PPPayment::requestToken();

        if (!empty($accessToken)) {

            $total = 0;
            $currency = $this->currency;
            $priceField = 'precio' . ($this->currency == 'USD' ? 'usd' : '');

            foreach($paymentCourses_verified as $pCourse) {
                $total += (float) $pCourse[$priceField];
            }

            if ($this->currency == 'USD') {
                foreach($paymentTranslations_verified as $pCourse) {
                    $price = $pCourse['precio_traduccion_usd'];
                    $total += (float) $price;
                }
            }

            $paymentData = [
                "payer_id" => $payerID,
                "transactions" => [
                  [
                    "amount" => [
                      "total" => $total,
                      "currency" => $currency,
                    ],
                  ]
                ]
            ];

            $paymentDataJson = json_encode($paymentData);
            $headers = array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
                'Content-length: ' . strlen($paymentDataJson),
            );

            $curl = curl_init(PAYPAL_API.'/payments/payment/' . $paymentID . '/execute');

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $paymentDataJson);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            
            $state = $response->state;
            $payerFullname =  $response->payer->payer_info->first_name . " " . $response->payer->payer_info->last_name;
            $payerEmail =  $response->payer->payer_info->email;
            $createdAt = preg_replace("/([0-9]{4}-[0-9]{2}-[0-9]{2})(T)([0-9]{2}:[0-9]{2}:[0-9]{2}).*/","$1 $3", $response->create_time); // converts paypal standard time to mysql standard.
            $localPaymentID = 0;

            if($state == 'approved'){
            
                $sql = "INSERT INTO `pp_payments` 
                            (`user_id`, `currency`, `payer_fullname`, `payer_email`, `payment_id`, `total`, `created_at`) 
                    VALUES  ('$userID', '$currency', '$payerFullname', '$payerEmail', '$paymentID', '$total', '$createdAt')";

                if ($conn->query($sql)) {

                    $localPaymentID = $conn->insert_id;
                    $estatus_details = 'Pagado con Paypal (' . date("d-M-y h:ia") . ')';
                    foreach($paymentCourses_verified as $pCourse) {
                        $courseID = $pCourse['id'];
                        $priceInt = (int) $pCourse['precio']; // because last programmer sets the db column type as INT and seems there is no problem by the client yet.

                        $sql = "UPDATE `cursoasientos` SET
                            estatus=1, estatus_details='$estatus_details', metodo1='PAYPAL', pago1='$priceInt', payment_id='$localPaymentID'
                            WHERE curso='$courseID' AND usuario='$userID' ORDER BY id DESC LIMIT 1"; // the order and limit is to ensure that only the last course for that user is affected.

                        $conn->query($sql);
                    }
                    foreach($paymentTranslations_verified as $pTransCourse) {
                        $courseID = $pTransCourse['id'];
                        $priceInt = (int) $pTransCourse['precio_traduccion_usd']; // because last programmer sets the db column type as INT and seems there is no problem by the client yet.

                        $sql = "UPDATE `cursoasientos` SET
                            translation_status=1, estatus_details='$estatus_details', translation_payment_option='PAYPAL', pagot='$priceInt', translation_payment_id='$localPaymentID'
                            WHERE curso='$courseID' AND usuario='$userID' ORDER BY id DESC LIMIT 1";
                        $conn->query($sql);
                    }       
                }        

                return $localPaymentID;
            }
            else{

                return 0;
            }
        }
        else {
            return 0;
        }
    }

    private function getMysqliConn() {
        global $CONEXION;
        return $CONEXION;
    }
}