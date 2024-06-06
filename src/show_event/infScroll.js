var loadingFlg = false;
$(window).on("load", function () {
    loadingFlg = true;
    if (typeof accountId === "undefined") ajax_add_content_for_show();
    else ajax_add_content_for_my(accountId);
})

$(window).on("scroll", function() {
    // 読込処理中ではないか判定
    if (!loadingFlg) {
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
    }
});

    // ajaxコンテンツ追加処理
    function ajax_add_content_for_show() {
        let count = $("#count").val();
        // コンテンツ件数
        $("#loading").append(`<div class="loading">読込中...</div>`);
        // ajax処理
        $.post({
        type: "POST",
        datatype: "json",
        url: "event_contents",
        data:{ count : count }
        })
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
        let count = $("#count").val();
        // コンテンツ件数
        $("#loading").append(`<div class="loading">読込中...</div>`);
        // ajax処理
        $.post({
        type: "POST",
        datatype: "json",
        url: "event_contents",
        data:{ count : count,
            accountId : accountId
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
                                <form  action="../event_form/update_event" method="post">
                                    <input type="hidden" name="eventid" value="${data[i]["eventid"]}" />
                                    <input type="submit" value="編集" />
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