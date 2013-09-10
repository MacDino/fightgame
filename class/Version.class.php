<?php
/**
 * 获取定义的静态资源版本号
 * @author lishengwei
 */
class Version {
    const VERSION = 1;

    public static function getStaticResourceVersion() {
        return self::VERSION;
    }
}

?>
