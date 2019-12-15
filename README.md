# FormalBears.Aop

[![Build Status](https://travis-ci.org/kumamidori/FormalBears.Aop.svg?branch=master)](https://travis-ci.org/kumamidori/FormalBears.Aop)

[formal-bears/aop](https://packagist.org/packages/formal-bears/aop)

AOP utility for BEAR.Sunday

## Installation

```
composer require formal-bears/aop:^0.1
```

## Feature

- HTTP Method Matcher

## Usage

### リソースのHTTPメソッドをインターセプトしたい場合の実装例

```php
// モジュールでの束縛
$this->bindInterceptor(
    $this->matcher->subclassesOf(ResourceObject::class),
    new IsHttpMethodMatcher(),  // HTTPメソッドマッチャー
    [FooInterceptor::class] // 束縛したいインターセプター
);
```

リソースインターセプターの用途としては、自分のドメインに合ったフレームワーク（開発基盤）を作りたいときを想定しています。
tBEARは標準セットで使うこともできますが、拡張に対して開かれているので、フレームワークを作ることもできます。

## Requires

`>= PHP 7.2`

## 実装の紹介（スニペット）

```php
// リソースのメソッドのためのカスタムマッチャー
class IsHttpMethodMatcher extends EqualsToMatcher
{
    public function __construct()
    {
        parent::__construct([
            'onGet',
            'onPost',
            'onPut',
            // ... （省略）
        ]);
    }
}
```

```php
// 上記 `IsHttpMethodMatcher` のスーパークラス。
// 同一かどうかのカスタムマッチャー。
use Ray\Aop\AbstractMatcher;

class EqualsToMatcher extends AbstractMatcher
{
    /**
     * @var array
     */
    private $values;

    /**
     * @param string|array $values
     */
    public function __construct($values)
    {
        parent::__construct();

        $this->values = (array) $values;
    }

    /**
     * {@inheritdoc}
     */
    public function matchesClass(\ReflectionClass $class, array $arguments)
    {
        return in_array(strtolower($class->getName()), array_map('strtolower', $this->values));
    }

    /**
     * {@inheritdoc}
     */
    public function matchesMethod(\ReflectionMethod $method, array $arguments)
    {
        return in_array(strtolower($method->getShortName()), array_map('strtolower', $this->values));
    }
}
```
