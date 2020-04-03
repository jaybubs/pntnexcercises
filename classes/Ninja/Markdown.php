<?php

namespace Ninja;

class Markdown
{
    private $string;

    public function __construct($markDown)
    {
        $this->string = $markDown;
    }

    public function toHtml()
    {
        //convert $this->string to HTML
        $text = htmlspecialchars($this->string, ENT_QUOTES,'UTF-8');

        //strong
        $text = preg_replace('/__(.+?)__/s','<strong>$1</strong>',$text);
        $text = preg_replace('/\*\*(.+?)\*\*/s','<strong>$1</strong>',$text);
        //italic
        $text = preg_replace('/_([^_]+)_/','<em>$1</em>',$text);
        $text = preg_replace('/\*([^\*]+)\*/','<em>$1</em>',$text);

        //convert Win \r\n to Unix \n
        // $text = preg_replace('/\r\n/',"\n",$text); regex
        $text = str_replace("\r\n","\n",$text); //php
        //convert Mac \r to Unix \n
        // $text = preg_replace('/\r/',"\n",$text); regex
        $text = str_replace("\r","\n",$text);

        //paragraphs
        $text = '<p>' . str_replace("\n\n",'</p><p>',$text) . '</p>';
        //line breaks
        $text = str_replace("\n",'<br>',$text);

        //links
        $text = preg_replace('/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i','<a href="$2">$1</a>',$text);

        return $text;
    }
    
}   
