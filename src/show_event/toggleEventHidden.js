$('.event-container').on("change", "input[type='checkbox']", function () {
    eventId = $(this).parent().parent().parent().attr("name");
    setFlag(eventId, !$(this).is(":checked"));
})

function setFlag(eventId, flag) {
    return $.post({
        type: "POST",
        datatype: "json",
        url: "event_favorite",
        data:{
            eventId : eventId,
            flag : flag
        }
    }).done(alert("変更しました。"))
}