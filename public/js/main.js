'use scrict';
{

    // 検索機能の非同期処理
    $(() => {
        $("#search_form").on("click", function(e){
            e.preventDefault();

        $.ajax({
        type:"GET",
        url:"{{ route('products.search') }}",
        dataType: 'json',
        })

        .done(function(json){
            alert('ajax成功');
        console.log(json);
        })
        .fail(function(){
            alert('ajax失敗');
        })
        .always(function(){
        
        });

        });
    });

    // 削除機能の非同期処理
    // $(() => {
    //     $("#delBtn").on("click", function(e){
    //         e.preventDefault();

    //         let deleteConfirm = confirm("削除しますか？");
    //         if(deleteConfirm == true) {
    //             let clickEle = $(this)
    //             let userID = clickEle.attr('data-user-id');

    //             $.ajax({
    //                 url: '/user/' + userID,
    //                 type: 'POST',
    //                 data: {'id': userID,
    //                        '_method': 'DELETE'} // DELETE リクエストだよ！と教えてあげる。
    //               })
            
    //              .done(function() {
    //                 // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
    //                 clickEle.parents('tr').remove();
    //               })
            
    //              .fail(function() {
    //                 alert('エラー');
    //               });
            
    //             } else {
    //               (function(e) {
    //                 e.preventDefault()
    //               });
    //             };
    //           });
    //         });


}