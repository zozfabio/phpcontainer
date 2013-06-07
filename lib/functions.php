<?

function call($function) {
    $function();
}

function import($file, $ext = 'php') {
    require_once implode('/', explode('.', 'src.'.$file)).'.'.$ext;
}

function prepend_protocol($url) {
    $conf = SimpleSAML_Configuration::getInstance();
    if ($conf->getBoolean('ssl')) {
        return 'https://'.$url;
    } else {
        return 'http://'.$url;
    }
}

function get_format($value, $format) {
    $matches = [];
    if (preg_match($format, $value, $matches)) {
        return $matches[0];
    }
}

function get_inputs($fields) {
    $post = new stdClass();
    foreach ($fields as $field => $format) {
        $post->$field = null;
        if (isset($_POST[$field])) {
            if (is_array($_POST[$field])) {
                $post->$field = [];
                foreach ($_POST[$field] as $value) {
                    array_push($post->$field, get_format($value, $format));
                }
            } else {
                $post->$field = get_format($_POST[$field], $format);
            }
        }
    }
    return $post;
}

function get_parameters($fields) {
    $post = new stdClass();
    foreach ($fields as $field => $format) {
        $post->$field = (isset($_GET[$field]) ? get_format($_GET[$field], $format) : null);
    }
    return $post;
}