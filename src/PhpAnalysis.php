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

    // 做单例模式
    private static $that;

    /**
     * 分词过程中运用的参数
     */
    private $do_fork = true;    //岐义处理
    private $do_unit = true;    //新词识别
    private $do_multi = true;   //多元切分
    private $do_prop = false;   //词性标注

    /**
     * PhpAnalysis constructor.
     * @param string $source_charset 资源的格式
     * @param string $target_charset 输出的格式
     * @param bool $load_all 是否预载全部词条
     * @param string $source 资源数据
     */
    protected function __construct($source_charset, $target_charset, $load_all, $source)
    {
        // 第一步  实例化对象
        parent::__construct($source_charset, $target_charset, $load_all);

        // 第二步  载入字典
        $this->LoadDict();
    }

    /**
     * 得到单例对象
     * @param string $source_charset 资源的格式
     * @param string $target_charset 输出的格式
     * @param bool $load_all 是否预载全部词条   (一般配置它即可)
     * @param string $source 资源数据
     * @return PhpAnalysis
     */
    public static function getInstance($source_charset = 'utf-8', $target_charset = 'utf-8', $load_all = true, $source = '')
    {
        if (!(self::$that instanceof self)) {
            self::$that = new self($source_charset, $target_charset, $load_all, $source);
        }

        return self::$that;
    }

    /**
     * 修改分词时候运用的参数
     * @param $param
     */
    public function setParam($param)
    {
        $this->do_fork = empty($param->do_fork) ? false : true;         //岐义处理
//        $this->do_unit = empty($param->do_unit) ? false : true;         //新词识别
//        $this->do_multi = empty($param->do_multi) ? false : true;       //多元切分
        $this->do_prop = empty($param->do_prop) ? false : true;         //词性标注
    }

    /**
     * 分词运用接口
     * @param $string
     * @param string $outType [string|encode_str|encode_array]
     * @return array|mixed|string
     * @Author jiaWen.chen
     */
    public function cut($string, $outType = 'string')
    {
        // 第三部  执行分词
        $this->SetSource($string);
        $this->StartAnalysis($this->do_fork);

        // 第四步 输出分词结果
        $result = $this->GetFinallyResult(' ', $this->do_prop);

        /**
         * 最后对结果进处理
         */
        // 最后对结果进处理
        if ($outType == 'string') {
            return $result;
        }

        // 过滤特殊字符
        $result = preg_replace("/[,\\\\(\)\[\]\?\!\@\#\$￥\*<>。.;；、，？？;；：:'|=\-\+\"\/]/", '', json_encode($result));

        if ($outType == 'encode_str') {
            return $result;
        }
        // 去除为空的元素
        if ($outType == 'encode_array') {
            $result = explode(' ', trim($result));
            $response = [];
            foreach ($result as $item) {
                if (!empty($item)) {
                    $response[] = $item;
                }
            }
            return $response;
        }
    }

    /**
     * 测试运用
     */
    public function test()
    {
        include __DIR__ . '/SDK/demo.php';
    }
}