function send_modification(div_id, page_path, data_map) {
    $.ajax({
        type: "POST",
        url: page_path,
        data: data_map,
        success: function(response) {
            $('#' + div_id).html(response);
        }
    });
}

function updateEducateurList() {
    let word_input = document.getElementById("educateur_search_input");
    let word = word_input.value;
    send_modification('responsable_educateur_list', '/responsable/ajax/listeEducateurs', {search_word: word})
}

function generatePassword() {
    let input = document.getElementById("isGeneratePassword");
    input.value = "1";
}

function updateImeList() {
    let word_input = document.getElementById('recherche_ime');
    let word = word_input.value;
    send_modification('recherche_ime_div', '/responsable/ajax/listeIMEs', {search_word: word});
}

function download_the_pdf() {
    setTimeout(function() {
        location.reload();
    }, 3000);

}