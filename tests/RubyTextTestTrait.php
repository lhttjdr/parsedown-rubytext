<?php
namespace Noi\Tests;

trait RubyTextTestTrait
{
    protected function initDirs()
    {
        $dirs = parent::initDirs();

        $dirs []= dirname(__FILE__).'/data/';

        return $dirs;
    }

    abstract protected function initParsedown();

    /** @test */
    public function 指定した括弧を使ってrpタグを出力する_rp用の括弧を変更()
    {
        $markdown = '[紫電の槍]^(ライトニングスピア)';
        $expected = '<ruby>紫電の槍<rp>＜</rp><rt>ライトニングスピア</rt><rp>＞</rp></ruby>';

        $this->parsedown->setRubyTextBrackets('＜', '＞');

        $this->assertEquals($expected, $this->parsedown->line($markdown));
    }

    /** @test */
    public function rpタグを出力しない_rp用の括弧をなしに設定()
    {
        $markdown = '[括弧省略]^(かっこしょうりゃく)';
        $expected = '<ruby>括弧省略<rt>かっこしょうりゃく</rt></ruby>';

        /* スタイルシートで括弧を変更できるようにする場合や(rt:before, rt:after)
         * <rt>のフォントサイズや色を変更して見た目を区別する場合は
         * <rp>が邪魔になるので削除する
         */
        $this->parsedown->setRubyTextBrackets(null, null);

        $this->assertEquals($expected, $this->parsedown->line($markdown));
    }

    /** @test */
    public function 指定文字列でルビを分割する_モノルビ用の分割記号を変更()
    {
        $markdown = '[東京都]^(とう/きょう/と)';
        $expected = '<ruby>東<rp>（</rp><rt>とう</rt><rp>）</rp>京<rp>（</rp><rt>きょう</rt><rp>）</rp>都<rp>（</rp><rt>と</rt><rp>）</rp></ruby>';

        $this->parsedown->setRubyTextSeparator('/');

        $this->assertEquals($expected, $this->parsedown->line($markdown));
    }

    /** @test */
    public function ルビ指定を解析しない_Extensionを無効に設定()
    {
        $markdown = '[拡張記法無効]^(かくちょうきほうむこう)';
        $expected = $markdown;

        $this->parsedown->setRubyTextEnabled(false);

        $this->assertEquals($expected, $this->parsedown->line($markdown));
    }

    public function setUp()
    {
        $this->parsedown = $this->initParsedown();
    }

    protected $parsedown;
}
