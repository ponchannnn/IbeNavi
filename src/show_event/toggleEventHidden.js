$('.event-container').on("change", "input[type='checkbox']", function () {
    eventId = $(this).parent().parent().parent().attr("name");
    sendFavo(eventId, $(this).is(":checked")).then(m => {throw m}).catch(e => alert("favoriteできませんでした。"));
})

function setFlag(eventId, flag) {
    return $.post({
        type: "POST",
        datatype: "json",
        url: "event_flag",
        data:{
            eventId : eventId,
            flag : flag
        }
    })
}

async function sendFavo(eventId, flag) {
    return await setFlag(eventId, flag);
}
