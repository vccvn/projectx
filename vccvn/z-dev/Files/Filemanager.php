<?php

// namespace Crazy\Files;

// use Crazy\Helpers\Any;

class Filemanager{
    use FileType, DirMethods, FileMethods, ZipMethods, FileConverter;


    /**
     * khoi tao doi tuong
     * @param string $dir
     */
    function __construct($dir = null, $make_dir_if_not_exists = false)
    {
        $this->dirInit();
        $this->zipInit();
        $this->setDir($dir,$make_dir_if_not_exists);
    }

    

    /**
     * full path
     * lấy dừng dẫn tuyệt đối của file hoạc thư mục
     * @param string $filename
     * @return string
     */
    public function getPath($filename = null)
    {
        $path = null;
        if($filename){
            if(!$this->checkDirAccepted($filename)) $path = $this->_dir . '/' . $filename;
            else $path = $filename;
        }
        else $path = $this->_dir . '/' . $this->_filename;

        return $path;
    }

    /**
     * gọi hàm theo dịnh dạng file
     * @param string $method
     * @param array $params
     */
    public function __call($method, $params)
    {
        $filename = null;
        $data = null;
        $mime = null;
        $action = null;
        $n = strtolower($method);
        $has_params = (is_array($params) && $t = count($params));
        // trường hợp 1: gọi hàm bằng get + phần mở rộng của file, 
        // ví dụ getHtml thì sẽ set định dạng html để chuẩn hóa dường dẫn rồi trả về nội dung file nenu61 file tồn tại
        if((substr($n,0, 3) == 'get') && ($info = $this->getMimeType(substr($n, 3)))){
            // nếu có tham số
            if($has_params){
                // tham số đầu tiên sẽ là tên file
                $filename = $params[0];
            }
            // set loại file
            $mime = $info->type;
            // set hành dộng
            $action = 'get';
        }
        // trường hợp 2: gọi hàm bằng save + phần mở rộng của file, 
        // ví dụ saveHtml thì sẽ set định dạng html để chuẩn hóa dường dẫn rồi thêm đuôi file nếu người dủng quên rồi lưu
        elseif((substr($n,0, 4) == 'save') && ($info2 = $this->getMimeType(substr($n, 4))))
        {
            if($has_params){
                if($t == 1){
                    // nếu chỉ có 1 tham số thì data sẽ là tham số đầu tiên
                    $data = $params[0];
                }else{
                    // nếu nhiều hôn thì tên file là tham số dầu tiên
                    $filename = $params[0];
                    // dữ liệu là tham số thứ 2
                    $data = $params[1];
                }
            }
            $mime = $info2->type;
            $action = 'save';
        }
        // trường hợp 2: gọi hàm bằng  phần mở rộng của file, 
        // ví dụ html thì sẽ set định dạng html để chuẩn hóa dường dẫn rồi thêm đuôi file nếu người dủng quên rồi lưu hoặc lấy dữ liệu
        elseif($info3 = $this->getMimeType($n)){
            if($has_params){
                if($t == 1){
                    // nếu tham số đầu tiên là chuỗi thì sẽ là file name và lấy data
                    if(is_string($params[0])){
                        $filename = $params[0];
                        $action = 'get';
                    }
                    // ngược lại là lưu với tham số đầu tiên là dữ liệu
                    else{
                        $data = $params[0];
                        $action = 'save';
                    }
                }
                // nếu có hơn 1 tham số thì chắc chắn sẽ lưu chử với tham số là filename và data
                else{
                    $filename = $params[0];
                    $data = $params[1];
                    $action = 'save';
                }
            }
            // nếu ko tham số sẽ là lấy dữ liệu theo dường dẫn và tên file dc set trc đó
            else{
                $action = 'get';
            }
            $mime = $info3->type;
        }

        if($action == 'get'){
            return $this->getContent($filename, $mime);
        }elseif($action == 'save'){
            return $this->save($filename, $data, $mime);
        }
        return $this;
    }

    

}