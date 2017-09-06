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
        $sentence = $this->get()->first();
        foreach($sentence as $word) {
            if($word[2] !== static::ART) {
                return lcfirst($word[0]);
            }
        }
    }

    public function sentence(int $length = null)
    {
       $sentenceArray = $this->get()->first();
       $sentence = '';
       if($length === null || $length > count($sentenceArray)) {
           $length = count($sentenceArray);
       }
       for($i = $length; $i > 0; $i--) {
           if(isset($sentenceArray[$i])) {
            $word = $sentenceArray[$i];
            if($word[2] !== static::PUNCT || ($word[0] == ',' || $word[0] == '.')) {
                $sentence .= $word[0] . ' ';
            }
            }
       }
       return rtrim($sentence, ' ');
    }

    public function paragraph($sentences = 7)
    {
        if($sentences > 7) {
            $sentences = 7;
        }
        $data = $this->get();

        $paragraph =  $data->reduce(function($accumulator, $sentence){
            $accumulator .= $this->toSentence($sentence);
            return $accumulator;
        }, '');
        
        return $paragraph;
    }

    private function get()
    {
        $data = file_get_contents($this->apiUrl);
        return collect(json_decode($data));
    }

    private function toSentence(array $words)
    {
        return collect($words)->reduce(function($sentence, $word){
            $sentence .= ($word[3] == 'left' ? '' : ' ') . $word[0];
            return $sentence;
        }, '');
    }
}