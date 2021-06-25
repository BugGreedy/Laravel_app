## その他
### 目次

* [モデル作成時のオプションについて](#モデル作成時のオプションについて)</br>
* [リソースコントローラーとは](#リソースコントローラーとは)</br>


</br>

***</br>

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
これは生成されたコントローラーがリソースコントローラーである(リソースコントローラーを作成する)という事を示すオプションである。</br>
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
