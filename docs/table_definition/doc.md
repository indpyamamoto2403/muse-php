## Table: users

ユーザー情報を管理するテーブル。

**Columns:**

| Name                  | Type                | Attributes  | Description                                                              |
|-----------------------|---------------------|-------------|--------------------------------------------------------------------------|
| `id`                  | `bigint`            | `UN AI PK`  | ユーザーID (主キー、自動インクリメント)                                      |
| `name`                | `varchar(255)`      |             | ユーザー名                                                                 |
| `role`                | `enum('company','artist','admin')` |             | 役割 (company, artist, admin のいずれか)                                      |
| `email`               | `varchar(255)`      |             | メールアドレス                                                              |
| `profile_photo_path`  | `varchar(2048)`     |             | プロフィール写真のパス                                                         |
| `occupation`          | `varchar(255)`      |             | 職業                                                                     |
| `self_introduction`   | `text`              |             | 自己紹介                                                                   |
| `email_verified_at`   | `timestamp`         |             | メールアドレス確認日時                                                         |
| `password`            | `varchar(255)`      |             | パスワード (ハッシュ化されたもの)                                            |
| `remember_token`      | `varchar(100)`      |             | ログイン状態維持用トークン                                                     |
| `created_at`          | `timestamp`         |             | 作成日時                                                                   |
| `updated_at`          | `timestamp`         |             | 更新日時                                                                   |

**Constraints:**

*   `id` は主キー (Primary Key) です。
*   `id` は自動インクリメント (Auto Increment) です。
*   `id` は符号なし (Unsigned) です。

**Notes:**

*   `email` には UNIQUE 制約を設定することを推奨します。
*   `password` はセキュリティのため、必ずハッシュ化して保存してください。
*   `remember_token` はログイン状態を維持するために使用されます。
*   `created_at` と `updated_at` は、レコードの作成/更新日時を自動的に記録するために、データベースのデフォルト値やトリガーを使用することがあります。
*   `UN`はUNSIGNED(符号なし)を表します。
*   `AI`はAUTO_INCREMENT(自動インクリメント)を表します。
*   `PK`はPRIMARY KEY(主キー)を表します。