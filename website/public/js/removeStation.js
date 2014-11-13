function confirmSubmit() {
  if (confirm("If you delete this station, all its docks are deleted and the bicycles are set free.")) {
    document.removeStationForm.submit();
  }
  return false;
}

function fnOpenNormalDialog() {
    $("#dialog-confirm").html("If you delete this station, all its docks are deleted and the bicycles are set free.");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Station Deletion Confirmation",
        height: 250,
        width: 400,
        buttons: {
            "Yes": function () {
                $(this).dialog('close');
                document.removeStationForm.submit();
            },
                "No": function () {
                $(this).dialog('close');
            }
        }
    });
}