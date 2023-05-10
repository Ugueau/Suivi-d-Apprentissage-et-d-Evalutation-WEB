function calendrier_change(type, date, eleve_id) {
    send_modification("calendrier_content", "/eleve/ajax/ajaxCalendrier", {"calendrier_type": type, "date": date, "eleve_id": eleve_id});
}

function date_selector_change(actual_date, action_type, eleve_id) {
    var calendrier_combobox = document.getElementById("calendrier_type_selector");
    var calendrier_type = calendrier_combobox.value;
    var date = actual_date;

    if(action_type == "back") {
        if(calendrier_type == "Jour") {
            date = modifyDate(actual_date, "Mois", -1);
        }else if(calendrier_type == "Mois") {
            date = modifyDate(actual_date, "Année", -1);
        }else if(calendrier_type == "Année") {
            date = modifyDate(actual_date, "Année", -36);
        }
    }else if(action_type == "forward") {
        if(calendrier_type == "Jour") {
            date = modifyDate(actual_date, "Mois", 1);
        }else if(calendrier_type == "Mois") {
            date = modifyDate(actual_date, "Année", 1);
        }else if(calendrier_type == "Année") {
            date = modifyDate(actual_date, "Année", 36);
        }
    }else {
        date = modifyDate(actual_date, "Année", 0);
    }
    
    send_modification("date_selector", "/eleve/ajax/ajaxDateSelector", {"date": date, "calendrier_type": calendrier_type, "eleve_id": eleve_id});
    calendrier_change(calendrier_type, date, eleve_id);
}

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


function getDayNumber(month, year) {
    if(month === 1 || month === 3 || month === 5 || month === 7 || month === 8 || month === 10 || month === 12) {
        return 31;
    }else if(month === 4 || month === 6 || month === 9 || month === 11){
        return 30;
    }else if(month === 2) {
        if(year%4 === 0) {
            return 29;
        }else{
            return 28;
        }
    }else{
        return 31;
    }
}

function modifyDate(date, element_to_modify, value) {

    function getDay(date) {
        return Number(date.substring(0, 2));
    }

    function getMonth(date) {
        return Number(date.substring(3, 5));
    }

    function getYear(date) {
        return Number(date.substring(6, date.length));
    }

    dd = getDay(date);
    mm = getMonth(date);
    yyyy = getYear(date);

    new_dd = dd;
    new_mm = mm;
    new_yyyy = yyyy;
    
    new_date = date;
    
    if(element_to_modify == "Jour") {
        new_dd = dd + value;
        if(new_dd > getDayNumber(mm, yyyy)) {
            new_dd = new_dd - getDayNumber(mm, yyyy);
            if(new_dd < 10) {
                new_dd = "0" + String(new_dd);
            }
            new_date = modifyDate(new_dd + date.substring(2, date.length), "Mois", 1);
        }else if(new_dd <= 0){
            new_dd = getDayNumber(mm - 1) + new_dd + 1;
            if(new_dd < 10) {
                new_dd = "0" + String(new_dd);
            }
            new_date = modifyDate(new_dd + date.substring(2, date.length), "Mois", -1);
        }
        new_mm = getMonth(new_date);
        new_yyyy = getYear(new_date);
    }else if(element_to_modify == "Mois") {
        new_mm = mm + value;
        if(new_mm > 12) {
            new_mm = new_mm - 12;
            if(new_mm < 10) {
                new_mm = "0" + String(new_mm);
            }
            new_date = modifyDate(date.substring(0, 3) + new_mm + date.substring(5, date.length), "Année", 1);
        }else if(new_mm <= 0) {
            new_mm = 12 + new_mm;
            if(new_mm < 10) {
                new_mm = "0" + String(new_mm);
            }
            new_date = modifyDate(date.substring(0, 3) + new_mm + date.substring(5, date.length), "Année", -1);
        }
        new_yyyy = getYear(new_date);
        if(dd > getDayNumber(new_mm)) {
            new_dd = getDayNumber(new_mm);
        }
    }else if(element_to_modify == "Année") {
        new_yyyy = new_yyyy + value;
    }

    new_dd = Number(new_dd);
    new_mm = Number(new_mm);

    if(new_dd > getDayNumber(new_mm, new_yyyy)) {
        new_dd = getDayNumber(new_mm, new_yyyy);
    }

    if(new_dd < 10) {
        new_dd = "0" + String(new_dd);
    }
    if(new_mm < 10) {
        new_mm = "0" + String(new_mm);
    }

    return String(new_dd) + "-" + String(new_mm) + "-" + String(new_yyyy);
}

function calendrier_case_clicked(calendrier_type, date, value, eleveId, activite_span_text = "Activité(s) effectuée(s)") {
    function getMonthname(month_number) {
        switch(month_number) {
            case 1:
                return "Janvier";
            case 2:
                return "Février";
            case 3:
                return "Mars";
            case 4:
                return "Avril";
            case 5:
                return "Mai";
            case 6:
                return "Juin";
            case 7:
                return "Juillet";
            case 8:
                return "Août";
            case 9:
                return "Septembre";
            case 10:
                return "Octobre";
            case 11:
                return "Novembre";
            case 12:
                return "Décembre";
        }
    }
    start_date = -1;
    end_date = -1;
    if(calendrier_type == "Année") {
        var calendrier_combobox = document.getElementById("calendrier_type_selector");
        calendrier_combobox.value = "Mois";
        start_date = "01-01-" + String(value);
        end_date = "31-12-" + String(value);
        date_selector_change(date.substring(0, 6) + String(value), "nomove", eleveId);
        activite_span_text = "Activité(s) effectuée(s) pendant l'année " + String(value);        
    }else if(calendrier_type == "Mois") {
        value = Number(value);
        if(value < 10) {
            value = "0" + String(value);
        }
        value = String(value);
        var calendrier_combobox = document.getElementById("calendrier_type_selector");
        calendrier_combobox.value = "Jour";
        start_date = "01-" + String(value) + date.substring(5, date.length);
        end_date = String(getDayNumber(Number(value), Number(date.substring(6, date.length)))) + "-" + value + date.substring(5, date.length);
        date_selector_change(date.substring(0, 3) + String(value) + date.substring(5, date.length), "nomove", eleveId);
        activite_span_text = "Activité(s) effectuée(s) pendant le mois de " + getMonthname(Number(value));  
    }else if(calendrier_type == "Jour") {
        value = Number(value);
        if(value < 10) {
            value = "0" + String(value);
        }
        value = String(value);
        start_date = String(value) + date.substring(2, date.length);
        end_date = start_date;
        activite_span_text = "Activité(s) effectuée(s) le " + String(value) + " " + getMonthname(Number(date.substring(3, 5))) + " " + date.substring(6, date.length);  
    }
    send_modification("activity_content", "/eleve/ajax/ajaxActivite" , {"activite_span_text": activite_span_text, "eleve_id": eleveId, "start_date": start_date, "end_date": end_date});
}

function display_element(id, value) {
    var element = document.getElementById(id);
    if(value) {
        element.classList.remove("inactive");
        element.classList.add("active");
    }else{
        element.classList.remove("active");
        element.classList.add("inactive");
    }
}

function display_activite_infos(idActivite, idADM, idEleve, activiteNom, activiteDescription) {
    display_element("activite_info", true);
    send_modification("activiteInfos_nom", "/eleve/ajax/ajaxActiviteInfosNom", {"nom_activite": activiteNom});
    send_modification("activiteInfos_description", "/eleve/ajax/ajaxActiviteInfosDescription", {"description_activite": activiteDescription});
    send_modification("liste_competence_resultat", "/eleve/ajax/ajaxActiviteInfosCompResults", {"idADM": idADM, "idEleve": idEleve});
}