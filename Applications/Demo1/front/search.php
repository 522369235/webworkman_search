<?php

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;

$options = [];
// $options['dict']  = 'small';

Jieba::init($options);
Finalseg::init($options);
