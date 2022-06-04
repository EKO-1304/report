
    // document.addEventListener("contextmenu", function(e){
    //     window.location.href = "https://kebunku.stekom.ac.id/logout";
    // }, false);
    document.onkeydown = function(e) {
        if(event.keyCode == 123) {
            return false;
        }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                window.location.href = "https://kebunku.stekom.ac.id/logout";
            return false;
        }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                window.location.href = "https://kebunku.stekom.ac.id/logout";
            return false;
        }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){

                window.location.href = "https://kebunku.stekom.ac.id/logout";

            return false;
        }
    }