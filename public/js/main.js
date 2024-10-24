{

// 検索処理の非道処理化
$(() => {
    $("#search_btn").on("click", function(e){
            e.preventDefault();

            let formData = $('#search_form').serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;}, {});

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
                $('#search-results').empty();

                let newTableHtml ='<table class="table table-striped">' +
                '<thead><tr>' +
                '<th>ID</th>' +
                '<th>商品画像</th>' +
                '<th>商品名</th>' +
                '<th>価格</th>' +
                '<th>在庫数</th>' +
                '<th>メーカー名</th>' +
                '<th></th>' +
                '<th><a href="/product_regist/"' + 'class="btn btn-warning">新規登録</a>' +
                '</th>' +
                '</tr></thead><tbody>';

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

                        newTableHtml += '</tbody></table>';

                $('#productTable').hide();

                $('#search-results').html(newTableHtml);

            })

                .fail(function(){
                    alert('ajax失敗');
                })

    });

});

 // ソート処理
// $('table th a').on('click', function(e) {
//     e.preventDefault();
//     var sortColumn = $(this).data('column');
//     var sortOrder = $(this).data('order');

//     $.ajax({
//       url: 'search',
//       data: {
//         // 検索条件に加えて、ソート条件も追加
//         sortColumn: sortColumn,
//         sortOrder: sortOrder,
//         // ... (他の検索条件)
//       },
//       success: function(data) {
//         // ... (既存のコード)
//       },
//       error: function() {
//         alert('エラーが発生しました。');
//       }
//     });
//   });


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
            .done(function(response) {
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