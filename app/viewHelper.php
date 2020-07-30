<?php

/**
 * view helper
 *
 * @param $path
 * @param array $data
 * @throws Exception
 */
function view($path, $data = array()){

    $viewsPath = ROOT_FOLDER . '/resources/views/';
    $templatePath =  $path . '.php';

    if(file_exists($viewsPath . $templatePath)){

        extract($data);
        ob_start();

        include $viewsPath . $templatePath;
        $content = ob_get_clean();
        include $viewsPath . 'layouts/app.php';

        exit();
    } else {
        throw new Exception('File missed');
    }

}

function partialView($path, $data = array()){

    $viewsPath = ROOT_FOLDER . '/resources/views/';
    $templatePath =  $path . '.php';

    if(file_exists($viewsPath . $templatePath)){

        extract($data);
        ob_start();

        include $viewsPath . $templatePath;
        $partialContent = ob_get_clean();

        return $partialContent;

    } else {
        throw new Exception('File missed');
    }

}