<?php

namespace App\Controller;

class View {

    private static function sanitizePath(string $path, string $ext)
    {
        $path = str_replace('App/View/', '', $path);
        $path = str_replace($ext, '', $path);
        $path .= $ext;

        return $path;
    }

    private static function setContentTemplate(string &$html, array $content)
    {
        preg_match_all("/{{(.*?)}}/", $html, $list_tags);

        if (empty($list_tags[1]))
            return;

        foreach($list_tags[1] as $tag) {
            $value = in_array($tag, array_keys($content)) ? $content[$tag] : '';
            $html = str_replace('{{'.$tag.'}}', $value, $html);
        }
    }

    public static function getFile(string $path, array $data = [])
    {
        $path = self::sanitizePath($path, '.phtml');

        if (!empty($path) && file_exists('App/View/' . $path))
            require('App/View/' . $path);
    }

    public static function getContent(string $path, array $content = [])
    {
        $path = self::sanitizePath($path, '.html');

        if (empty($path) || !file_exists('App/View/' . $path))
            return;

        $html = file_get_contents('App/View/' . $path);

        self::setContentTemplate($html, $content);

        return $html;
    }

    public static function getAttr(array $attrs)
    {
        $data = [];

        foreach($attrs as $k => $v) {
            $data[] = "{$k}=\"{$v}\"";
        }

        return implode(' ', $data);
    }

}