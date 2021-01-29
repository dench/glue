<?php
namespace app\commands;

use yii\console\Controller;
use yii\helpers\FileHelper;

class TranslateController extends Controller
{
    //const DIR = '/';
    const DIR = '/runtime/yii2-cart/';

    public function actionIndex($lang = 'ru')
    {
        $categories = [
            //'app',
            'cart',
        ];

        $dirs = [
            //'behaviors',
            'widgets',
            'components',
            'controllers',
            'models',
            'views',
            'widgets',
        ];

        foreach ($categories as $category) {
            $file = __DIR__ . '/..' . self::DIR .'messages/' . $lang . '/' . $category . '.php';
            $old_messages = include $file;

            $messages = [];
            foreach ($dirs as $dir) {
                $dir = __DIR__ . '/..' . self::DIR . $dir;

                $folders = FileHelper::findDirectories($dir);
                $folders[] = $dir;

                foreach ($folders as $folder) {
                    $files = FileHelper::findFiles($folder);
                    foreach ($files as $file) {
                        if (strpos($file, '.php')) {
                            $text = file_get_contents($file);
                            preg_match_all("/Yii::t\('" . $category . "', '(.+?)'/", $text, $out);
                            if (isset($out[1])) {
                                foreach ($out[1] as $m) {
                                    if (!isset($messages[$m])) {
                                        $messages[$m] = $m;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            asort($messages);
            $new = [];
            $old = [];
            $format = "";
            foreach ($old_messages as $key => $message) {
                if (!isset($messages[$key])) {
                    $old[$key] = $key;
                }
            }
            foreach ($messages as $key => $message) {
                if (!isset($old_messages[$key])) {
                    $new[$key] = $key;
                    $message = null;
                } else {
                    $message = $old_messages[$key];
                    if ($message === '') {
                        $new[$key] = $key;
                    }
                }
                $format .= "" . (isset($new[$key]) ? '' : '    ') . "'" . $key . "' => '" . str_replace("'", "\'", $message) . "',\n";
            }
            $info = "";
            if ($new) {
                $info .= "\n/*\n--- NEW ---\n" . implode("\n", $new) . "\n*/\n";
            }
            if ($old) {
                $info .= "\n/*\n--- OLD ---\n" . implode("\n", $old) . "\n*/\n";
            }
            $format = "<?php\n" . $info . "\nreturn [\n" . $format . "];";
            $file = __DIR__ . '/..' . self::DIR .'messages/' . $lang . '/' . $category . '.php';
            file_put_contents($file, $format);
        }
    }
}
