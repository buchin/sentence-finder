<?php
namespace Buchin\SentenceFinder;

class Ddg extends SentenceFinder
{
    public $base_url = "http://duckduckgo.com/";
    public $selector = "";

    public function getToken($query)
    {
        $url =
            $this->base_url .
            "?" .
            http_build_query([
                "q" => $query,
                "t" => "hx",
                "va" => "g",
                "ia" => "web",
            ]);

        $html = file_get_contents($url);

        // vqd='3-142216309694420347760037715005911496568-220342727435306949816443430106535095457';
        $vqd_token = "";
        if (
            !preg_match("/vqd\s*\=\s*\'(?<vqd_token>[^\']*)/", $html, $matches)
        ) {
            throw new \Exception("Error: Banned IP. We will rest for a bit");
        }

        $vqd_token = $matches["vqd_token"];

        return $vqd_token;
    }

    public function getHtml($word)
    {
        $token = $this->getToken($word);

        $url =
            "https://links.duckduckgo.com/d.js?q=" .
            rawurlencode($word) .
            "&a=hx&l=wt-wt&p=-2&s=29&ex=-2&ct=US&ss_mkt=us&sp=0&vqd=" .
            $token .
            "&bpa=1&biaexp=b&msvrtexp=b&mliexp=b&nadse=b";

        $proxy = $this->options["proxy"];

        $ua = $this->randomUserAgent();

        if (!empty($proxy)) {
            $proxy = "tcp://$proxy";
        }

        $options = [
            "http" => [
                "method" => "GET",
                "proxy" => "$proxy",
                "user_agent" => $ua,
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];

        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        return $response;
    }

    public function parseHtml($html, $selector)
    {
        if (!preg_match("/load\('d',(?<json>.+?)\);DDG/m", $html, $matches)) {
            throw new \Exception("Error: unable to extract json...");
        }

        $json = $matches["json"];

        $items = json_decode($json, true);
        $results = [];

        foreach ($items as $item) {
            $results[] = $item["a"] ?? "";
        }

        return array_filter($results);
    }
}
