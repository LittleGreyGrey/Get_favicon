<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015 https://www.fifiblog.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: LittleGreyGrey <lgg@mail.com> <https://www.fifiblog.com>
// +----------------------------------------------------------------------

/***
  *
  * Get_favicon.class.php
  *
  * 接口文件
  * @author LittleGreyGrey<lgg@mail.com>
  *
  */

class Get_favicon{

    private function _get_content($url, $action = '',$file = '', $timeout=60)
    {
        if(function_exists('curl_init'))
        {
            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $out=curl_exec($ch);
            curl_close($ch);

            if($action == 'img')
            {
                if(@file_put_contents($file, $out))
                {
                  return $out;
                }
            }
            else
            {
                return $out;
            }
        }
        else
        {
            return false;
        }
    }

    private function _get_url($url)
    {
        if($url){
            preg_match('/\/$/', $url, $tmp_url_1);
            if(!$tmp_url_1)
            {
                $url .= '/';
            }
            preg_match('/^https?:\/\//', $url, $tmp_url_2);
            if(!$tmp_url_2){
                $url = 'http://'.$url;
            }
            $centent = $this->_get_content($url);
            preg_match_all('/<link(.*?)rel=[\'"]shortcut icon[\'"](.*?)href=[\'"](.*?)[\'"](.*?)\/?>/', $centent, $tmp_1_1);
            preg_match_all('/<link(.*?)href=[\'"](.*?)[\'"](.*?)rel=[\'"]shortcut icon[\'"](.*?)\/?>/', $centent, $tmp_1_2);
            if(!$tmp_1_1[3] && !$tmp_1_2[2])
            {
                preg_match_all('/<link(.*?)rel=[\'"]icon[\'"](.*?)href=[\'"](.*?)[\'"](.*?)\/?>/', $centent, $tmp_2_1);
                preg_match_all('/<link(.*?)href=[\'"](.*?)[\'"](.*?)rel=[\'"]icon[\'"](.*?)\/?>/', $centent, $tmp_2_2);
                if(!$tmp_2_1[3] && !$tmp_2_2[2])
                {
                    preg_match_all('/<link(.*?)href=[\'"](.*?)[\'"](.*?)type=[\'"]image\/x-icon[\'"](.*?)\/?>/', $centent, $tmp_3_1);
                    preg_match_all('/<link(.*?)type=[\'"]image\/x-icon[\'"](.*?)href=[\'"](.*?)[\'"](.*?)\/?>/', $centent, $tmp_3_2);
                    if($tmp_3_1[2] or $tmp_3_2[3])
                    {
                        $tmp_favicon = $tmp_3_1[2] ? $tmp_3_1[2] : $tmp_3_2[3];
                    }
                }
                else
                {
                    $tmp_favicon = $tmp_2_1[3] ? $tmp_2_1[3] : $tmp_2_2[2];
                }
            }
            else
            {
                $tmp_favicon = $tmp_1_1[3] ? $tmp_1_1[3] : $tmp_1_2[2];
            }
            preg_match('/^https?:\/\//', (string)$tmp_favicon, $tmp_favicon_1);
            if(!$tmp_favicon_1)
            {
                $tmp_favicon_2 = $tmp_favicon[0];
                preg_match('/^\//', $tmp_favicon_2, $tmp_favicon_3);
                if(!$tmp_favicon_3)
                {
                    $favicon_url = $tmp_favicon_2;
                }
                else
                {
                    $favicon_url = $url.preg_replace('/^\/(.*?)$/', '$1', $tmp_favicon_2);
                }
            }
            else
            {
                $favicon_url = $tmp_favicon[0];
            }
        }
        else
        {
          $favicon_url = 'http://favicon.wiphp.com/favicon.ico';
        }
        return $favicon_url;
    }

    private function _get_favicon($favicon_url, $action = '')
    {
        if($favicon_url)
        {
            $tmp_type_1 = explode('.', $favicon_url);
            $tmp_type_2 = $tmp_type_1[count($tmp_type_1)-1];
            if($tmp_type_2 == 'ico' or $tmp_type_2 == 'gif' or $tmp_type_2 == 'png' or $tmp_type_2 == 'jpg' or $tmp_type_2 == 'jpeg')
            {
                switch($tmp_type_2)
                {
                    case 'ico':
                        $type = 'image/x-icon';
                        break;
                    case 'gif':
                        $type = 'image/gif';
                        break;
                    case 'png':
                        $type = 'image/png';
                        break;
                    case 'jpg':
                        $type = 'image/jpeg';
                        break;
                    case 'jpeg':
                        $type = 'image/jpeg';
                        break;
                    default:
                        $type = 'image/ico';
                        break;
                }
            }
            else
            {
                $type = 'image/x-icon';
                $favicon_url .= 'favicon.ico';
            }


            switch($action)
            {
                case 'extension':
                    return $tmp_type_2;
                    break;
                case 'type':
                    return $type;
                    break;
                default:
                    $ch = curl_init($favicon_url);
                    curl_setopt($ch, CURLOPT_NOBODY,1);
                    curl_exec($ch);
                    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if($status_code != 200)
                    {
                        $favicon_url = 'http://favicon.wiphp.com/favicon.ico';
                    }
                    return $favicon_url;
                    break;
            }
        }
        else
        {
            return false;
        }
    }

    private function _get_md5($favicon_url, $type = 'ico')
    {
        $favicon_uri = 'favicon/'.md5($favicon_url).'.'.$type;
        return $favicon_uri;
    }

    public function get($url, $action = '')
    {
        $favicon_url = $this->_get_url($url);
        $favicon_uri = $this->_get_favicon($favicon_url);
        $favicon_type = $this->_get_favicon($favicon_url, 'type');
        $favicon_extension = $this->_get_favicon($favicon_url, 'extension');
        $favicon_md5 = $this->_get_md5($favicon_url, $favicon_extension);
        $favicon_dir = dirname(__FILE__).'/'.$favicon_md5;
        switch($action)
        {
            case 'debug':
                echo $favicon_dir;
                break;
            case 'update':
                header('Content-type: '.$favicon_type);
                echo $this->_get_content($favicon_md5, 'img', $favicon_md5);
                break;
            default:
                if(is_file($favicon_dir))
                {
                    header('Content-type: '.$favicon_type);
                    echo $this->_get_content('http://favicon.wiphp.com/'.$favicon_md5);
                }
                else
                {
                    header('Content-type: '.$favicon_type);
                    echo $this->_get_content($favicon_uri, 'img', $favicon_md5);
                }
                break;
        }
    }
}
