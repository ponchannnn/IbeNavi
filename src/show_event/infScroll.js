var loadingFlg = false;
$(window).on("load", function () {
    loadingFlg = true;
    if (typeof accountId === "undefined") ajax_add_content_for_show();
    else ajax_add_content_for_my(accountId);
})

$(window).on("scroll", function() {
    // 読込処理中ではないか判定
    if (loadingFlg) return;
    // 画面に見えている最上部の座標 = [bodyの高さ] - [windowの高さ]
    var bottomPoint = document.body.clientHeight - window.innerHeight;
    // スクロール量を取得
    var currentPos = window.scrollY;
    // スクロール量が最下部の位置を過ぎたか判定
    if (bottomPoint-300 <= currentPos) {
        if ($("#count").val() == -1) return;
        loadingFlg = true;
        if (typeof accountId === "undefined") ajax_add_content_for_show();
        else ajax_add_content_for_my(accountId);
    }
});

$("#sort").on("change", () => {
    //アニメーションスタート
    if (bar) {
        bar.stop();
        bar.set(0);
        $("#splash").removeAttr("style");
        bar.animate(1, function () {//バーを描画する割合を指定します 1.0 なら100%まで描画します
            $("#splash").delay(500).fadeOut(800);//アニメーションが終わったら#splashエリアをフェードアウト
        });
    }
    $('#infinite-content').empty();
    $("#count").val(0);
    loadingFlg = true;
    if (typeof accountId === "undefined") ajax_add_content_for_show();
    else ajax_add_content_for_my(accountId);
})

    // ajaxコンテンツ追加処理
    function ajax_add_content_for_show() {
        let sort = $("#sort option:selected").val();
        sort? null: sort = "run_date";
        let count = $("#count").val();
        // コンテンツ件数
        $("#loading").append(`<div class="loading">読込中...</div>`);
        // ajax処理
        $.post({
        type: "POST",
        datatype: "json",
        url: "event_contents",
        data:{ count : count,
            sort : sort
        }})
        .done(function(data){console.log(data);
            $('#loading .loading').remove();
            // データがない場合終わる
            if (data.length == 1) {
                if (count == 0) $(".event-container").append("<h2> イベントがありません </h2>");
                count = -1;
            } else {
                // コンテンツ生成(count排除)
                for (let i = 0; i < data.length - 1; i++) {
                    $("#infinite-content").append(`
                    <div class='loaded-contents'>
                        <a href='event_contents.php?count=${data[data.length - 1]["count"]}}'></a>
                        <div class="event-container">
                            <div class="event">
                                <a href="/event_detail/event_prof?eventid=${data[i]["eventid"]}"><h2>${data[i]["eventname"]}</h2></a>
                                <p>開催日時: <span id="date-time">${data[i]["runtime"]}</span></p>
                                <p>場所: <span id="location">${data[i]["location"]}</span></p>
                                <p>カテゴリ: <span id="category">${data[i]["category"]}</span></p>
                                <!-- 追加 -->
                                <div class="like-switch">
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="like-slider"></span>
                                    </label>
                                </div>
                            </div>`
                    )
                }
                count = parseInt(count) + data.length - 1;
            }
            // 取得件数を加算してセット
            $("#count").val(count);
            loadingFlg = false;
        }).fail(function(e){
            console.log(e);
        })
    }

    function ajax_add_content_for_my(accountId) {
        let sort = $("#sort option:selected").val();
        sort? null: sort = "run_date";
        let count = $("#count").val();
        // コンテンツ件数
        $("#loading").append(`<div class="loading">読込中...</div>`);
        // ajax処理
        $.post({
        type: "POST",
        datatype: "json",
        url: "event_contents",
        data:{ count : count,
            accountId : accountId,
            sort : sort
        }})
        .done(function(data){
            $('#loading .loading').remove();
            // データがない場合終わる
            if (data.length == 1) {
                if (count == 0) $(".event-container").append("<h2> イベントがありません </h2>");
                count = -1;
            } else {
                // コンテンツ生成(count排除)
                for (let i = 0; i < data.length - 1; i++) {
                    $("#infinite-content").append(`
                    <div class='loaded-contents'>
                        <a href='event_contents.php?count=${data[data.length - 1]["count"]}}'></a>
                        <div class="event-container">
                            <div class="event">
                                <form  action="../event_form/update_event" method="GET">
                                    <input type="hidden" name="eventid" value="${data[i]["eventid"]}" />
                                    <input type="submit" value="編集" />
                                </form>
                                <form  action="../event_form/delete_event" method="GET">
                                    <input type="hidden" name="eventid" value="${data[i]["eventid"]}" />
                                    <input type="submit" value="削除" />
                                </form>
                                <a href="/event_detail/event_prof?eventid=${data[i]["eventid"]}"><h2>${data[i]["eventname"]}</h2></a>
                                <p>開催日時: <span id="date-time">${data[i]["runtime"]}</span></p>
                                <p>場所: <span id="location">${data[i]["location"]}</span></p>
                                <p>カテゴリ: <span id="category">${data[i]["category"]}</span></p>
                                <!-- 追加 -->
                                <div class="like-switch">
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="like-slider"></span>
                                    </label>
                                </div>
                            </div>`
                    )
                }
                count = parseInt(count) + data.length - 1;
            }
            // 取得件数を加算してセット
            $("#count").val(count);
            loadingFlg = false;
        }).fail(function(e){
            console.log(e);
        })
    }