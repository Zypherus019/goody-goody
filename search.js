document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById("searchModal");
    var span = document.getElementsByClassName("close1")[0];

    document.getElementById("search-query").addEventListener('input', function () {
        var query = this.value;
        if (query.length > 2) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "search.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status == 200) {
                    document.getElementById("modal-body").innerHTML = xhr.responseText;
                    modal.style.display = "block";
                }
            };
            xhr.send("query=" + encodeURIComponent(query));
        }
    });

    span.onclick = function () {
        modal.style.display = "none";
    };

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
});