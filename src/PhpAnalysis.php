<?php

namespace CjwAnalysis\src;

ini_set('memory_limit', '64M');
error_reporting(E_ALL);

class PhpAnalysis extends AnalysisAbstraction
{
    //附加词典 (重写)
    public $addonDicFile = 'SDK/dict/words_addons.dic';

    //主词典  (重写)
    public $mainDicFile = 'SDK/dict/base_dic_full.dic';

    /**
     * PhpAnalysis constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 测试运用
     */
    public function test()
    {
        include __DIR__.'/SDK/demo.php';
    }
}