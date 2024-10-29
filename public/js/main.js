{

// 検索処理
$(() => {

    function applyTablesorter() {
        $("#tableView").tablesorter({
            headers: {
                0: { sorter: true }, // ID
                1: { sorter: false }, // 商品画像は無効
                2: { sorter: false }, // 商品名は無効
                3: { sorter: true }, // 価格
                4: { sorter: true } , // 在庫数
                5: { sorter: false } , // メーカー名は無効
                6: { sorter: false } , // 空白無効
                7: { sorter: false }  // 新規登録無効
            }
        });
    }


    $("#search_btn").on("click", function(e){
            e.preventDefault();

            let formData = $('#search_form').serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;}, {});

            formData.sort_column = $("#tableView th.sorted").data("column"); // 現在のソートカラムを取得
            formData.sort_order = $("#tableView th.sorted").data("order"); // 現在のソート順を取得


            $.ajax({
                url:"search",
                data: formData,
                dataType: 'json',
                headers: {
                    "X-Search-Condition": "your_search_condition" // ここで検索条件を追加
                },

            })
            .done(function (data) {
                alert('ajax成功');
                console.log(data);
                $('#search-results tbody').empty();

                let newTableHtml ='<table class="table table-striped">';

                        $.each(data.products, function (index, product) {
                            newTableHtml += '<tr>' +
                            '<td>' + product.id + '</td>' +
                            '<td><img src="' + product.img_path + '" alt="商品画像"></td>' +
                            '<td>' + product.product_name + '</td>' +
                            '<td>' + product.price + '</td>' +
                            '<td>' + product.stock + '</td>' +
                            '<td>' + product.company_id + '</td>' +
                            '<td>' +
                            '<a href="/product_show/' + product.id + '" class="btn btn-primary">詳細</a>' +
                            '<form method="POST" action="/home{product}/' + product.id + '" class="d-inline">' +
                            '</td>' +
                            '<td>' +
                            '<button type="submit" class="btn btn-danger delete-product" data-product-id="' + product.id + '">削除</button>' +
                            '</form>' +
                            '</td>' +
                            '</tr>';
                        });

                        newTableHtml += '</table>';

                        $('#search-results tbody').html(newTableHtml);

                        // 検索結果のテーブルに対してtablesorterを適用
                        applyTablesorter();

                        $("#tableView").trigger("update");
                        $("#tableView").trigger("sortReset");
                    })

                .fail(function(){
                    alert('ajax失敗');
                })
            });

    });

    // ソート機能
    $(() => {

        $("#tableView").tablesorter({
            headers: {
                0: { sorter: true }, // ID
                1: { sorter: false }, // 商品画像は無効
                2: { sorter: false }, // 商品名は無効
                3: { sorter: true }, // 価格
                4: { sorter: true } , // 在庫数
                5: { sorter: false } , // メーカー名は無効
                6: { sorter: false } , // 空白無効
                7: { sorter: false }  // 新規登録無効
            },

        });

        // ID、価格、在庫数押下時のクリックイベント
        $("#tableView th").click(function() {
            let $this = $(this);
            let order = $this.data('order') === 'asc' ? 'desc' : 'asc';

            $this.siblings().removeClass('sorted').removeAttr('data-order');
            $this.addClass('sorted').data('order', order);

        });
    });


// 削除処理
$(() => {
    $('.delete-product').click(function(e) {
        e.preventDefault();

        if (confirm('本当に削除しますか？')) {
            let form = $(this).closest('form');
            let url = form.attr('action');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: form.serialize(),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            })
            .done(function() {
                // 削除成功時の処理
                form.closest('tr').remove();
                alert('削除しました');
            })
            .fail(function(error) {
                // 削除失敗時の処理
                console.error(error);
                alert('削除に失敗しました。');
            });
        }
    });
});

}