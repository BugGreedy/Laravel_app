## その他
### 目次

* [CRUDのHTTPメソッドについてのおさらい](#CRUDのHTTPメソッドについてのおさらい)</br>
* [モデル作成時のオプションについて](#モデル作成時のオプションについて)</br>
* [リソースコントローラーとは](#リソースコントローラーとは)</br>
* [フォームファサードの書き方](#フォームファサードの書き方)</br>
* [あるレコードから指定したカラムの値のみを取り出してくれる関数](#あるレコードから指定したカラムの値のみを取り出してくれる関数)</br>
* [Laravelのapp作成時のオプション`–prefer-dist`について](#Laravelのapp作成時のオプション`–prefer-dist`について)</br>
* [スキャフォールド(scaffold)とは](#スキャフォールド(scaffold)とは)</br>


</br>

***</br>

### CRUDのHTTPメソッドについてのおさらい</br>
  | CRUD | 意味 | メソッド |
  | - | - | - |
  | Create | 作成 | POST/PUT |
  | Read | 読み込み | GET |
  | Update | 更新 | PUT |
  | Delete | 削除 | DELETE |</br>
  
  - HTTPメソッドは全部で8つ。(GET/POST/PUT/DELETE/HEAD/OPTIONS/TRACE/CONNECT)</br>
  - GET：リソースの取得
  - POST：リソースの追加
  - PUT：リソースの更新
  - DELETE：リソースの削除</br>
</br>

***
</br>


### モデル作成時のオプションについて
`% php artisan make:model -h`でモデル作成時のオプションを見る事ができる。</br>

```shell
% php artisan make:model -h
Description:
  Create a new Eloquent model class

Usage:
  make:model [options] [--] <name>

Arguments:
  name                  The name of the class

Options:
  -a, --all             Generate a migration, seeder, factory, and resource controller for the model
  -c, --controller      Create a new controller for the model
  -f, --factory         Create a new factory for the model
      --force           Create the class even if the model already exists
  -m, --migration       Create a new migration file for the model
  -s, --seed            Create a new seeder file for the model
  -p, --pivot           Indicates if the generated model should be a custom intermediate table model
  -r, --resource        Indicates if the generated controller should be a resource controller
      --api             Indicates if the generated controller should be an API controller
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
workintherain@MacBook-Pro lunchmap % 

```
</br>

***
</br>

### リソースコントローラーとは
`php artisan make:model モデル名 -m -c -r`の`-r`について</br>
これは生成されたコントローラーがリソースコントローラーである(モデル作成と同時にリソースコントローラーを作成する)という事を示すオプションである。</br>
</br>

* リソースコントローラーとは</br>
  DBへのCRUD操作を行うためのアクション(7メソッド)が定義されたコントローラー。</br>
  * CRUD：Create(登録)、Read(読み込み)、Update(更新)、Delete(削除)</br>

* リソースコントローラーの7メソッド</br>
  ```
  (1) public function index()
  (2) public function create()
  (3) public function store(Request $request)
  (4) public function show($id)
  (5) public function edit($id)
  (6) public function update(Request $request, $id)
  (7) public function destroy($id)
  ```

**結論**</br>
モデル作成時に-rオプションで作成されたコントローラーは、ファイル内にもともと7メソッドが定義されているコントローラー。</br>
</br>

***
</br>

### フォームファサードの書き方
- Laravelにてフォームを使う際のLaravel Collectiveの書き方について、html→フォームファサードの書き方を書いてくれているページがある。</br>
  → https://laraweb.net/practice/7965/</br>
</br>

***
</br>

### あるレコードから指定したカラムの値のみを取り出してくれる関数
4-8
`pluck('name','id')`</br>
新規投稿フォームにカテゴリの選択肢としてCategoryモデルの値を借りてくるときに使用</br>

```php
// lunchmap/app/Http/Controllers/ShopController.php
// 頭の部分の箇所に下記を追記

use App\Models\Shop;
// 下記を追加
use App\Models\Category;
use Illuminate\Http\Request;

//省略
public function create()
{
    //下記を追記
    $categories = Category::all()->pluck('name','id');
    return view('new',['categories'=> $categories]);
}
```
</br>

***
</br>

### Laravelのapp作成時のオプション`–prefer-dist`について
例：
```shell
$ composer create-project laravel/laravel アプリケーション名 --prefer-dist
```
の`-prefer-dist`はバージョン管理システムを含まないというオプション。</br>
</br>

バージョン管理を行う場合は`-prefer-source`を用いる。</br>
`-prefer-source`でプロジェクトディレクトリを作成すると、`.git`ファイル(gitを管理するファイル)が含まれてアプリケーションディレクトリが作成される。</br>
参考：https://hara-chan.com/it/programming/prefer-dist-prefer-source-difference/
</br>
</br>

***
</br>

### スキャフォールド(scaffold)とは
Laravelでよく聞く*スキャフォールド*とは、もともとは建築現場で使用される**足場**という意味。</br>
RubyやLaravelなどの*MVCフレームワーク*で開発する際に、**必要なモデルやコントローラ、ビューなどをコマンドで自動生成できる機能**の事を言う。</br>
</br>

***
</br>