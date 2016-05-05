<?php
/*
При просмотре порфолио, при наведении на изображение, поверх самого
изображения, должна отображаться дата загрузки и оригинальное имя
этого же изображения.
8. Для сохранения оригинального имени, даты загрузки и модифицированного
имени изображения используйте файл, в который вы будете записывать
сериализованный массив данных.
*/
define('FOLDER_IMAGE','uploads');
define('PHOTO_PATH','Photo.txt');
define('ALLOW_TYPES',[
    'image/jpeg'=>'jpg',
    'image/gif'=>'gif',
    'image/png'=>'png'
]);
function push_photo_name($result){
    return file_put_contents(PHOTO_PATH,serialize($result));
}
function get_photo_name(){
    return unserialize(file_get_contents(PHOTO_PATH));
}
function generate_md($tmp_type,$tmp_name){
    $allow_type = ALLOW_TYPES[$tmp_type];
    if (!isset($allow_type)) {
        throw new Error('Тип файла не совпадает;');
    }else{
        $name=md5($tmp_name.time()).'.'.$allow_type;
    }
    return $name;
}
function save_image($tmp_name,$new_name){
    move_uploaded_file($tmp_name, FOLDER_IMAGE.DIRECTORY_SEPARATOR .$new_name);
}
$file_was_send=false;
$count_result=0;
function index(){
    global $file_was_send;
    global $count_result;
    global $result;

    if(is_dir(FOLDER_IMAGE)==false){
        if(mkdir(FOLDER_IMAGE)==false){
            throw new Error('Не могу создать папку;');
        }
    }
    //$count_result=0;
    if(file_exists(PHOTO_PATH)){
        $result=get_photo_name();
        $count_result=count($result);
    }
    // $file_was_send=false;
    if (isset($_POST['submit'])) {
        $file_was_send = true;
        if (count($_FILES["photo"]["error"]) >= 7) {
            throw new Error('Вы загрузили больше чем 7 файлов');
        }
        foreach ($_FILES["photo"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["photo"]["tmp_name"][$key];
                $tmp_type = $_FILES["photo"]["type"][$key];
                $name = $_FILES["photo"]["name"][$key];
                $new_name = generate_md($tmp_type, $tmp_name);
                save_image($tmp_name, $new_name);
                $result[] = [
                    'original' => $name,
                    'date' => date("Y-m-d H:i:s"),
                    'md5' => $new_name
                ];
            }
            if ($error == UPLOAD_ERR_FORM_SIZE) {
                throw new Error('Упс,ошибка,по-меньше файл загрузите =);');
            }
        }
        push_photo_name($result);
//    echo "<pre>";
//    print_r($_FILES);
//    echo "</pre>";
        $count_result = count($result);
    }
}
index();
include 'main.php';
