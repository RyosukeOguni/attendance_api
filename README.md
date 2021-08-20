# 出欠管理API

利用者情報(users)、出欠記録(attendances)を管理するWebAPI。
SPA認証機能により1つのシステムを、利用者が操作する打刻画面と、施設管理者が操作する管理画面に分けている。
出欠記録をExcel形式の提出用書式ファイルに出力可能。


## １．設計資料

-   [DB設計](https://docs.google.com/spreadsheets/d/17RrS2w2tT9tho0lYT3gNw_mgJa9HsXAvaGf-L8HB3-M/edit?usp=sharing){:target="_blank"}
-   [ER図](https://drive.google.com/file/d/1kQ1C5ky3_muGoZtLrMPVJ_NGWB79cnLf/view?usp=sharing){:target="_blank"}
-   [APIエンドポイント設計](https://docs.google.com/document/d/1TJakUUqc22AOlnHskWc17qnKZRHTCMaJfrcxrMjBXKs/edit?usp=sharing){:target="_blank"}
-   [APIレスポンス応答例](https://docs.google.com/document/d/1aAdXZJJfrltc-fAh2bo95gssix-HP8EqhrV0sxHJ050/edit?usp=sharing){:target="_blank"}
-   [ユースケース図](https://drive.google.com/file/d/1Bx9gb8y7wBuTnkhYb5jkV36CA5oOfKSH/view?usp=sharing){:target="_blank"}


## ２．使用パッケージ・ライブラリ

-   [laravel/framework v8.55.0](https://packagist.org/packages/laravel/framework){:target="_blank"}
    -   laravelフレームワーク
-   [laravel/sanctum v2.11.2](https://packagist.org/packages/laravel/sanctum){:target="_blank"}
    -   SPA認証に使用
-   [nesbot/carbon　2.51.1](https://packagist.org/packages/nesbot/carbon){:target="_blank"}
    -   PHPサーバー内で日付や時間を処理
-   [phpoffice/phpspreadsheet 1.18.0](https://packagist.org/packages/phpoffice/phpspreadsheet){:target="_blank"}
    -   出欠記録をExcelファイルに出力
-   [madnest/madzipper v1.1.0](https://packagist.org/packages/madnest/madzipper){:target="_blank"}
    -   複数のExcelファイルをZip圧縮
-   [mnabialek/laravel-sql-logger 2.2.8](https://packagist.org/packages/mnabialek/laravel-sql-logger){:target="_blank"}
    -   クエリログを記録


## ３．作成者情報

-   作成者：小国 亮介
