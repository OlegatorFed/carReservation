//pattern script

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}

function addInputFilter(textboxs,_filter)
{
    if (textboxs.length != 0)
    {
        for (let item of textboxs){
            setInputFilter(item, function(value) {
                return _filter.test(value);
            });
        }
    }
}

function getStatus(select, id)
{
    let status;
    switch (select.value) {
        case 'Free':
            status = 0;
            break;
        case 'Reserved':
            status = 1;
            break;
        case 'Taken':
            status = 2;
            break;
    }

    $.ajax({
        url: 'admin_panel.php',
        type: 'POST',
        dataType: 'text',
        data:
            {
                status: status,
                id: id
            },
        success (data) {
            console.log(data);
        }
    });
}

addInputFilter(document.getElementsByClassName('numbers-only'),/^\d*$/)
addInputFilter(document.getElementsByClassName('text-only'), /^[а-я ]*$/i)

