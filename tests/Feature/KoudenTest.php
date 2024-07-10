<?php

namespace Tests\Feature;

use App\Models\Kouden;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KoudenTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * テスト名について
     * ・先頭に  test_  をつける
     * ・@test　をつける　メソット名にtestは不要
     * ・日本語名でも大丈夫
     * test_<url>_<証明する内容>
     * 
     * 
     * 1.ログインユーザーがkouden.indexにアクセスできること(200)
     * 2.ログインしてないユーザーがkouden.indexにアクセスできないこと
     * 3.存在するIDでkouden.detailにアクセスできること(200)
     * 4.存在しないIDでkouden.detailにアクセスできないこと
     * 5.存在するIDでkouden.editにアクセスできること(200)
     * 6.存在しないIDでkouden.editにアクセスできないこと
     * 7.kouden.editで更新処理が正常に行えること
     * 8.不正な値でkouden.editで更新処理がエラーになること
     * 9.kouden.newで更新処理が正常に行えること
     * 10.不正な値でkouden.newで更新処理がエラーになること
     * 11.kouden.removeで削除処理が正常に行えること
     * 12.不正な値でkouden.removeで削除処理がエラーになること
     * 13.検索が正常に行えること
     * 
     */
     // ログインしてないユーザがbook.indexにアクセスできないこと(302)
    public function test_kouden_index_ng()
    {
        $response = $this->get('/kouden');
        $response->assertStatus(302);
    }


    // ログインユーザがbook.indexにアクセスできること(200)
    public function test_kouden_index_ok()
    {
        // ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/kouden');
        $response->assertStatus(200);
    }

    // 存在するIDでbook.detailにアクセスできることを確認（200）
    public function test_kouden_detail_id_exist()
    {
        // ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $response = $this->actingAs($user)->get("/kouden/detail/$kouden->id");
        $response->assertStatus(200);
    }

    // 存在しないIDでbook.detailにアクセスできないことを確認（404）
    public function test_kouden_detail_id_not_exist()
    {
        // ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
//        $kouden = Kouden::factory()->create();

        $response = $this->actingAs($user)->get("/kouden/detail/9999");
        $response->assertStatus(404);
    }

    // 存在するIDでbook.editにアクセスできることを確認（200）
    public function test_kouden_edit_id_exist()
    {
        // ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $response = $this->actingAs($user)->get("/kouden/edit/$kouden->id");
        $response->assertStatus(200);
    }

    // 存在しないIDでbook.editにアクセスできないことを確認
    public function test_kouden_edit_id_not_exist()
    {
        // ログインさせる場合は、factoryでuserを作り、actingAsでリクエストする。
        $user = User::factory()->create();
//        $kouden = Kouden::factory()->create();

        $response = $this->actingAs($user)->get("/kouden/edit/9999");
        $response->assertStatus(404);
    }

    // book.editで更新処理が正常に行えること
    public function test_kouden_update_ok()
    {
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $params = [
            'id' => $kouden->id,
            'section' => 1,
            'post' => 'test',
            'name_kan' => 'test',
            'relation' => 'test',
            'address' => 'test',
            'price'=> 'test',
            'memo'=> 'test',
            'created_at'=> '2022-04-11',
        ];

        $response = $this->actingAs($user)->patch("/kouden/update", $params);
        $response->assertStatus(302); // httpステータスが302を返すこと
        $response->assertSessionHas('status', '本を更新しました。'); // セッションにstatusが含まれていて、値が「本を更新しました。」となっていること
        $this->assertDatabaseHas('koudens', $params); // dbの値が更新されたこと
    }

    // 不正な値でbook.editで更新処理がエラーになること
    public function test_kouden_update_section_ng()
    {
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $params = [
            'id' => $kouden->id,
            'section' => 9,//不正な値
            'post' => 'test',
            'name_kan' => 'test',
            'relation' => 'test',
            'address' => 'test',
            'price'=> 'test',
            'memo'=> 'test',
            'created_at'=> '2024-10-01',
        ];

        $response = $this->actingAs($user)->patch('/kouden/update', $params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['section' => '選択されたステータスは、有効ではありません。']); // エラーセッションに値が含まれること
        $this->assertDatabaseMissing('koudens', $params); // dbの値が更新されてないこと
    }

    // 不正な値でkouden.editで更新処理がエラーになること（複数）
    public function test_kouden_update_section_ng_all()
    {
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $params = [
            'id' => $kouden->id,
            'section' => 9,//不正な値
            'post' => $this->faker->realText(256), // 不正な値
            'name_kan' => $this->faker->realText(256), // 不正な値,
            'relation' => $this->faker->realText(256), // 不正な値
            'address' => $this->faker->realText(256), // 不正な値
            'price'=> $this->faker->realText(256), // 不正な値
            'memo'=> $this->faker->realText(1001), // 不正な値
            'created_at'=> '2022-10-01xxxx', // 不正な値
        ];

        $response = $this->actingAs($user)->patch('/kouden/update', $params);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('koudens', $params); // dbの値が更新されてないこと
        $response->assertInvalid(['section' => '選択された名目は、有効ではありません。']);
        $response->assertInvalid(['post' => '所属は、255文字以下にしてください。']);
        $response->assertInvalid(['name_kan' => '氏名は、255文字以下にしてください。']);
        $response->assertInvalid(['relation' => '続柄は、255文字以下にしてください。']);
        $response->assertInvalid(['address' => '住所は、255文字以下にしてください。']);
        $response->assertInvalid(['price' => '価格は、255文字以下にしてください。']);
        $response->assertInvalid(['memo' => 'メモは、1000文字以下にしてください。']);
        $response->assertInvalid(['created_at' => '読破日は、正しい日付ではありません。']);
        /**
         * ・エラーメッセージ
         * section: 選択されたステータスは、有効ではありません。
         * post: 名前は、255文字以下にしてください。
         * name_kan: 氏名は、255文字以下にしてください。
         * post: 名前は、255文字以下にしてください。
         * relation:続柄は、255文字以下にしてください。
         * address:住所は、255文字以下にしてください。
         * price:価格は、255文字以下にしてください。
         * memo: メモは、1000文字以下にしてください。
         * read_at: 読み終わった日は、正しい日付ではありません。-> 読破日に変える（バグってる
         */
    }

    // kouden.newで更新処理が正常に行えること
    public function test_kouden_create_ok()
    {
        $user = User::factory()->create();

        $params = [
            'section' => 9,//不正な値
            'post' => $this->faker->realText(256), // 不正な値
            'name_kan' => $this->faker->realText(256), // 不正な値,
            'relation' => $this->faker->realText(256), // 不正な値
            'address' => $this->faker->realText(256), // 不正な値
            'price'=> $this->faker->realText(256), // 不正な値
            'memo'=> $this->faker->realText(1001), // 不正な値
            'created_at'=> '2022-10-01xxxx', // 不正な値
        ];

        $response = $this->actingAs($user)->post('/kouden/create', $params);
        $response->assertStatus(302); // httpステータスが302を返すこと
        $response->assertSessionHas('section', '本を作成しました。'); // セッションにstatusが含まれていて、値が「本を作成しました。」となっていること
        $this->assertDatabaseHas('kouden', $params); // dbの値が更新されたこと
    }

    // 不正な値でkouden.newで更新処理がエラーになること
    public function test_kouden_create_status_ng_all()
    {
        $user = User::factory()->create();
//        $kouden = Kouden::factory()->create();

        $params = [
            'section' => 9, // 不正な値
            'post' => $this->faker->realText(256), // 不正な値
            'name_kan' => $this->faker->realText(256), // 不正な値
            'relation' => $this->faker->realText(256), // 不正な値
            'address' => $this->faker->realText(256), // 不正な値
            'price'=> $this->faker->realText(256), // 不正な値
            'memo'=> $$this->faker->realText(1001), // 不正な値
            'read_at'=> '2024-10-01xxxx', // 不正な値
        ];

        $response = $this->actingAs($user)->post('/kouden/create', $params);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('koudens', $params); // dbの値が更新されてないこと
        $response->assertInvalid(['section' => '選択された名目は、有効ではありません。']);
        $response->assertInvalid(['post' => '所属は、255文字以下にしてください。']);
        $response->assertInvalid(['name_kan' => '氏名は、255文字以下にしてください。']);
        $response->assertInvalid(['relation' => '続柄は、255文字以下にしてください。']);
        $response->assertInvalid(['address' => '住所は、255文字以下にしてください。']);
        $response->assertInvalid(['price' => '価格は、255文字以下にしてください。']);
        $response->assertInvalid(['memo' => 'メモは、1000文字以下にしてください。']);
        $response->assertInvalid(['created_at' => '読破日は、正しい日付ではありません。']);

        /**
         * ・エラーメッセージ
         * name: 名前は、255文字以下にしてください。
         * status: 選択されたステータスは、有効ではありません。
         * author: 著者は、255文字以下にしてください。
         * publication: 出版は、255文字以下にしてください。
         * read_at: 読み終わった日は、正しい日付ではありません。-> 読破日に変える（バグってる
         * note: メモは、1000文字以下にしてください。
         */
    }

    // kouden.removeで更新処理が正常に行えること
    public function test_kouden_remove_ok()
    {
        $user = User::factory()->create();
        $kouden = Kouden::factory()->create();

        $response = $this->actingAs($user)->delete("/kouden/remove/$book->id");
        $response->assertStatus(302); // httpステータスが302を返すこと
        $response->assertSessionHas('status', '本を削除しました。'); // セッションにstatusが含まれていて、値が「本を削除しました。」となっていること

        $kouden = Kouden::find($kouden->id);
        $this->assertEmpty($kouden); // NOTE: $thisはUnitTestの関数
    }

    // 不正な値でbook.removeで更新処理がエラーになること
    public function test_kouden_remove_ng()
    {
        $user = User::factory()->create();
        Kouden::factory()->create();

        $response = $this->actingAs($user)->delete("/kouden/remove/99999");

        $response->assertStatus(404);
    }

    // 検索が正常に行えること　TODO: requestテストではテストが難しい
//    public function test_kouden_index_search()
//    {
//        $user = User::factory()->create();
//        $params = [
//            'name' => 'testname',
//            'status' => 1,
//            'author'=> 'testauthor',
//            'publication'=> 'testpublication',
//            'read_at'=> '2022-10-01',
//            'note'=> 'testnote',
//        ];
//        $kouden1 = Kouden::factory()->create($params);
//
//        $params2 = [
//            'name' => 'abc',
//            'status' => 1,
//            'author'=> 'abc',
//            'publication'=> 'abc',
//            'read_at'=> '2022-10-01',
//            'note'=> 'abc',
//        ];
//        $kouden2 = Kouden::factory()->create($params2);
//
//        $kouden = Kouden::search(['name_kan' => 'abc']);
//        $this->assertEquals($kouden2->id, $kouden->id);
//
//        // ?name=石田&status=1&author=杉山+陽子&publication=大垣+翔太&note=test
////        $response = $this->actingAs($user)->get('/book?name=石田&status=1&author=杉山+陽子&publication=大垣+翔太&note=test');
////        $response->dump();
////        $response->assertSee('abc');
////        $response->assertValid(['name' => 'testname']);
////        $response->assertJsonPath('books.name', 'abc');
////        $response->assertJsonFragment([ # レスポンスJSON に以下の値を含む
////            'email' => 'user1@example.com',
////        ]);
//
//    }


}
