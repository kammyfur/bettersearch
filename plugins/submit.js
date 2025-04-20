function submit() {
    Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = true; })
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "/api/search/?q=" + document.querySelector('[searchbar=""]').value,
        success: function (data) {
            if (data.startsWith("ok=")) {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                location.href = data.replace('ok=', '');
            } else {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                alert(lang1);
            }
        },
        error: function (error) {
            Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
            alert(lang0);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function submitCorp() {
    Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = true; })
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "/api/search-corp/?q=" + document.querySelector('[searchbar=""]').value,
        success: function (data) {
            if (data.startsWith("ok=")) {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                location.href = data.replace('ok=', '');
            } else {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                alert(lang1);
            }
        },
        error: function (error) {
            Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
            alert(lang0);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function submitHeader() {
    Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = true; })
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "/api/search/?q=" + document.querySelector('[header_search=""]').value,
        success: function (data) {
            if (data.startsWith("ok=")) {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                location.href = data.replace('ok=', '');
            } else {
                Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
                alert(lang1);
            }
        },
        error: function (error) {
            Array.from(document.getElementsByClassName('disabling')).forEach((el) => { el.disabled = false; });
            alert(lang0);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

window.onload = function () {
    setTimeout(() => {
        document.querySelector('[searchbar=""]').addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.querySelector('[searchbutton=""]').click();
            }
        });
    }, 500)
}