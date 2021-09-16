<?php
namespace Buchin\SentenceFinder;

class Bing extends SentenceFinder
{
    public $base_url = "https://www.bing.com/search?q=";
    public $selector = "li.b_algo .b_caption p";
}
