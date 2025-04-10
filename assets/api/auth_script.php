<?php
session_start();
$_SESSION['loggedin']=false;
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data)){
    $login=$data['login'];
    $password=$data['password'];
}else{
    $response=['success'=>false,'message'=> 'Данные не переданы.'];
    echo json_encode($response);
    die();
}

$url = 'https://cdp.colvir.ru/TrackStudio/rest/user/'.$login;

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //Автоматический редирект
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключение проверки сертификта

$response = curl_exec($ch);

// Проверка ошибок
if (curl_errno($ch)) {
    echo 'Ошибка cURL: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Декодирование JSON ответа
$data = json_decode($response, true);

// Извлечение данных
if ($data) {
    if(isset($data['name'])){
        $_SESSION['loggedin']=true;
        $_SESSION['username']=$login;
        $_SESSION['password']=$password;
        $_SESSION['name']=$data['name'];
        if($login==="ssalina"||$login==="eglukhikh"||$login==="vkurnenkov"||$login==="obasalay"||$login==="vbasalai"){
            $response=[
                'success'=>true
            ];
            echo json_encode($response);
        }else{
            $response=[
                'success'=>false,
                'message'=>"Доступ к сервису для данной учетной записи запрещен."
            ];
            echo json_encode($response);
            die();
        }
    }else{
        $response=[
            'success'=>false,
            'message'=>"Пользователь не найден. Проверьте данные."
        ];
        echo json_encode($response);
        die();
    }
} else {
    echo "Не удалось декодировать JSON ответ.\n";
}
?>
