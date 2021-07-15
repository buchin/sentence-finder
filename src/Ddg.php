<?php

namespace Buchin\SentenceFinder;

class Ddg extends SentenceFinder
{
    public $base_url = "http://html.duckduckgo.com/html/?q=";
    public $selector = "a.result__snippet";
}
