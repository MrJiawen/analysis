# analysis php分词系统
> 本分词系统是依赖于 [PHPBONE开发框架的PHPAnalysis无组件分词系统](http://www.phpbone.com/phpanalysis/#api)，笔者直接引用了他的SDK(V2.0版本)进行再次封装，直接封装到composer中：

```markdown
composer require mr-jiawen/analysis
```

## 第一部分 项目制作
1. 重写整个src/SDK/phpanalysis.class.php 文件：
    * 重写文件为：`src/AnalysisAbstraction.php`
    * 去除 两个宏定义；
    * 其余的不变
    
2. 提供对一个对外的类提供分词服务：PhpAnalysis.php
    * 重写字典所在的目录
    * 然后提供一个简易的执行方法

补充：在sdk中`dict_build.php`是未使用到


## 第二部分 具体的使用方式：
获取单例对象：
```markdown
$ananlysis = PhpAnalysis::getInstance();
```
执行分词：
```
$result = $ananlysis->cut('好好学习天天上上');  // 最初的分词结果
$result = $ananlysis->cut('好好学习天天上上','encode_array');   //转码到utf8并且去除特殊字符，得到其字符串结果
$result = $ananlysis->cut('好好学习天天上上','encode_array');   //转码到utf8并且去除特殊字符，得到其数组结果
```
