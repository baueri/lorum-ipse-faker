<?php

namespace Baueri\LorumIpse;

class LorumIpseFaker
{
    const ART = 'ART';

    const ADJ = 'ADJ';

    const NOUN = 'NOUN';

    const ADV = 'ADV';

    const VERP = 'VERB';

    const PUNCT = 'PUNCT';

    protected $apiUrl = 'http://www.lorumipse.hu/generate/';

    public $word = '';

    public $sentence = '';

    public $paragraph = '';

    public static function make()
    {
        $instance = new static();

        $instance->word = $instance->word();
        $instance->sentence = $instance->sentence();
        $instance->paragraph = $instance->paragraph();

        return $instance;
    }

    public function word()
    {
        $sentence = $this->get()[0] ?? [];
        foreach($sentence as $word) {
            if($word[2] !== static::ART) {
                return lcfirst($word[0]);
            }
        }
    }

    public function sentence(int $words = null)
    {
       $sentenceArray = $this->get()[0];
       $sentence = '';
       if($words === null || $words > count($sentenceArray)) {
           $words = count($sentenceArray);
       }
       for($i = 0; $i <= $words-1; $i++) {
           if(isset($sentenceArray[$i])) {
                $word = $sentenceArray[$i];
                $next = isset($sentenceArray[$i+1]) ? $sentenceArray[$i+1] : null;
                $sentence .= $word[0];
                if($next && $next[2] !== static::PUNCT) {
                    $sentence .= ' ';
                }
            }
       }
       return rtrim($sentence, ' .:') . '.';
    }

    public function paragraph($sentences = 7)
    {
        if($sentences > 7) {
            $sentences = 7;
        }

        $paragraph = '';

        foreach ($this->get() as $sentence) {
            $sentences--;
            $paragraph .= $this->toSentence($sentence) . ' ';
            if ($sentences === 0) {
                return $paragraph;
            }
        }

        return trim($paragraph);
    }

    public function paragraphs($paragraphs = 1) {
        $text = '';
        for($i = 0; $i < $paragraphs; $i++) {
            $text .= $this->paragraph();
        }

        return $text;
    }

    private function get()
    {
        $data = file_get_contents($this->apiUrl);
        return json_decode($data);
    }

    private function toSentence(array $words)
    {
        $sentence = '';


        foreach($words as $i => $word) {
            if(isset($words[$i])) {
                $word = $words[$i];
                $next = isset($words[$i+1]) ? $words[$i+1] : null;
                $sentence .= $word[0];
                if($next && $next[2] !== static::PUNCT) {
                    $sentence .= ' ';
                }
            }
       }
       return rtrim($sentence, ' ');
    }
}
