{
    
    // ソート機能のクリックイベント

//     (function() {
//     'use scrict';

//     let ths = document.getElementsByTagName('th');
//     let i;
//     for (i = 0; i < ths.length; i++) {
//         ths[i].addEventListener('click', function() {
            
//             // sort機能の処理
//             let rows = Array.prototype.slice.call(document.querySelectorAll('tbody > tr'));
//             // return;
            
//             rows.sort(function(a, b) {
//                 let _a = a.children[col].textContent;
//                 let _b = b.childr
//                 en[col].textContent;
//                 if (_a < _b){
//                     return -1;
//                 }
//                 if (_a > _b) {
//                     return 1;
//                 }
//                 return 0;
//             });
//             // console.log(rows);
//             let tbody = document.querySelector('tbody');

//             while (tbody.firstChild) {
//                 tbody.removeChild(tbody.firstChild);
//             }
//         });
//     }
// })();

//     <script>
// $(function(){
// $.ajax({
// url: ‘ここに取得したいURLまたはディレクトリを入力’
// }).done(function(data){
// /* 通信成功時 */
// }).fail(function(data){
// /* 通信失敗時 */
// }).always(function(data){
// /* 通信成功・失敗問わず */
// });
// });
// </script>

// 検索処理の非道処理化
    $(() => {
        $("#search_btn").on("click", function(e){
            e.preventDefault();

            // formの中身のデータを取得する場合はserializeを使う
            // valは使わない
            let formData = $('#search_form').serialize();
            // let formData = "あいうえお";
            // console.log(formData);

        $.ajax({
        type:"GET",
        // jsファイルで書く場合はこの書き方が使えない。
        // bladeファイルに書く場合はルートを指定する書き方でもいい
        // でも今回は別ファイル（jsファイル）を読み込んでるからダメ
        url:"search",
        data: formData,
        dataType: 'html',
        })

        .done(function(data){

            alert('ajax成功');
        console.log(data);
        // $('#search-results').empty();
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

    // -------ここまで使う--------
    
    // $(() => {
    //     $("#delBtn").on("click", function(e){
    //         e.preventDefault();
            
    //         var productId = $(this).data('product-id');

    //         if (confirm("削除しますか？")) {
    //             $.ajax({
    //                 type: 'POST',
    //                 data:{'_method':'delete'},
    //                 url: '/products/' + productId,
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 },
    //                 success: function (data) {
    //                     // 削除された行を非表示にする
    //                     $('tr[data-product-id="' + productId + '"]').hide();
    //                     alert('削除しました。');
    //                 },
    //                 error: function (data) {
    //                     alert('削除に失敗しました。');
    //                 }
    //             });
    //         }
    //     });
    // });

}