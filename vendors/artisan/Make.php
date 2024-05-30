<?php
namespace Artisan;
class Make{
    public $data;
    public $pathParent;
    public function __construct($data,$pathParent){
        $this->data = $data;
        $this->pathParent = $pathParent;
    }

    public function handle($type){
        switch ($type) {
            case 'api':{
                $this->api();
                break;
            }
            case 'one':{
                $this->one();
                break;
            }
            case 'view':{
                $this->view();
                break;
            }
            case 'js':{
                $this->javascript();
                break;
            }
            case 'controller':{
                $this->controller();
                break;
            }
        }
    }

    public function genereateFile($pathGenereate,$pathContent, $content = false){
        if (!is_dir(dirname($pathGenereate))) {
            mkdir(dirname($pathGenereate), 0777, true);
        }

        if (file_exists($pathGenereate)) {
            echo "File đã tồn tại! : ".$pathGenereate;
            return;
        }

        if(!$content){
            $content = file_get_contents($pathContent);
        }

        if (file_put_contents($pathGenereate, $content) !== false) {
            echo "Tạo tập tin thành công! : ".$pathGenereate;
        } else {
            echo "Đã xảy ra lỗi khi tạo tập tin!";
        }
    }
    
    public function api(){
        $path = './api/'.$this->data.'.php';
        $source_file = $this->pathParent.'/artisan/api.php';
        $this->genereateFile($path, $source_file);
    }
    public function one(){
        $path = './api/'.$this->data.'.php';
        $source_file = $this->pathParent.'/artisan/one.php';
        $this->genereateFile($path, $source_file);
    }
    public function view(){
        $path = './pages/'.$this->data.'.php';
        $source_file = $this->pathParent.'/artisan/view.php';
        $this->genereateFile($path, $source_file);
    }
    public function javascript(){
        $path = './inc/scripts/'.$this->data.'.js';
        $source_file = $this->pathParent.'/artisan/js.js';
        $this->genereateFile($path, $source_file);
    }
    public function controller(){
        $path = './controller/'.$this->data.'.php';
        $source_file = $this->pathParent.'/artisan/controller.php';
        $content = $this->handerChangeClassName($source_file);
        $this->genereateFile($path, $source_file, $content);
    }

    public function handerChangeClassName($path){
        $content = file_get_contents($path);
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
            $classNameNew = basename($this->data);
            $newContent = preg_replace('/'.$className.'/', $classNameNew, $content);
            return $newContent;
        }
        return $content;
    }
}