function fnUnbookDialog(bookingId) 
{
    $("#dialog-confirm").html("Are you sure you want to unbook this booking?");
    
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Unbooking Confirmation",
        height: 250,
        width: 400,
        buttons: {
            "Yes": function () {
                $(this).dialog('close');
                document.location = "/Home/Unbook/" + bookingId;
            },
            "No": function () {
                $(this).dialog('close');
            }
        }
    });
}