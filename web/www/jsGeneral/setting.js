function confirmRemove(){
    if (confirm("Êtes-vous sûr(e) de vouloir vous supprimer ?")) {
        location.replace("/removeUser")
    } else {
        txt = "You pressed Cancel!";
    }
}