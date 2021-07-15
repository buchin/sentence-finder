<?php

namespace Buchin\SentenceFinder;

class Yahoo extends SentenceFinder
{
    public $base_url = "http://search.yahoo.com/search?p=";
    public $selector = "li .compText p";
}
