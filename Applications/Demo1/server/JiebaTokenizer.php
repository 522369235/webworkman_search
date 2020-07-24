<?php
/*
 * @Date : 2020-07-20 16:45:54
 * @LastEditors  : lim
 * @LastEditTime : 2020-07-24 16:18:19
 * @Descripttion :
*/

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use TeamTNT\TNTSearch\Support\TokenizerInterface;

class JiebaTokenizer implements TokenizerInterface
{

    // public function __construct(array $options = [])
    // {
    //     Jieba::init($options);
    //     if (isset($options['user_dict'])) {
    //         Jieba::loadUserDict($options['user_dict']);
    //     }
    //     Finalseg::init($options);
    // }

    public function tokenize($text, $stopwords = [])
    {
        return Jieba::cutForSearch($text);
    }

    // public function tokenize($text, $stopwords = [])
    // {
    //     return is_numeric($text) ? [] : $this->getTokens($text, $stopwords);
    // }

    // public function getTokens($text, $stopwords = [])
    // {
    //     return Jieba::cutForSearch($text);
    // }
}
