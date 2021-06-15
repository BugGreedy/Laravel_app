# Laravelのインストール手順
## 目次
[1.はじめに(やってみたけどlaravel newができなかった例)](#1.はじめに(やってみたけどlaravel newができなかった例))
[2.違うインストール方法で試したらできたパターン](#2.違うインストール方法で試したらできたパターン)



### 1.はじめに(やってみたけどlaravel newができなかった例)
とりあえず下記を参考にシンプルにインストールしてみる。</br>
参考:[【mac】MAMPでLaravelを導入する方法](https://qiita.com/kuroudoart/items/366e42d606764b46da7f)</br>
</br>

```bash
# 指定のディレクトリに(htdocs/*)に移動
$ cd /applications/mamp/htdocs/Laravel_app
# 今回はhtdocs/Laravel_app内にインストールする。

# ▲▲▲▲はプロジェクト名です。任意に変更してください。
$ composer create-project --prefer-dist laravel/laravel ▲▲▲▲
# 今回はpaiza環境に合わせるためpublic_htmlというプロジェクト名で実行

# プロジェクトフォルダへ移動
$ cd public_html/

# 確認のため下記コマンドでLaravelがインストールされているか確認
$ php artisan -v
```
これでいろいろ出てきたらOK。</br>
↓</br>
ただしこのインストール方法だと`laravel -v`や`laravel new`コマンドが使えなかったので今回は別の方法でやった。</br>
</br>

***
</br>

### 2.違うインストール方法で試したらできたパターン
1.の理由から下記の方法で再度Laravelインストールを試みた。</br>
参考：[【Laravel入門】プロジェクト作成から起動まで](https://qiita.com/yukibe/items/5ee27163b603d7f68250)</br>
</br>

```bash
# まずLaravelのインストール
$ composer global require "laravel/installer=~1.1"

# 次に環境変数の登録
$ echo "export PATH=~/.composer/vendor/bin:$PATH" >> ~/.bash_profile
$ source ~/.bash_profile
# source ~は内容を反映させるコマンド
# これで「laravel new」が使えるようになる。

$ cd ディレクトリ名
$ laravel new プロジェクト名


$ cd プロジェクト名
$ php artisan -v
# ここでいろいろ出てきたらOK。
```
</br>

また、この記事内に`laravel new ~`でなくcomposerコマンドでプロジェクトを新規作成する方法が記載されている。
```bash
$ composer create-project laravel/laravel プロジェクト名 --prefer-dist
```
</br>

プロジェクト作成時のcomposerコマンドと`laravel new ~`の違いは**バージョンを指定できるか否か**。</br>
`laravel new ~`はバージョン指定ができず、最新バージョンでの作成となる。</br>
</br>

composerコマンドでバージョンを指定する場合
```bash
$ composer create-project laravel/laravel プロジェクト名 --prefer-dist "5.5.*"
```