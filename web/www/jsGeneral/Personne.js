export class Personne {
    constructor(id,nom,prenom,numHomonyme,type,IdIME) {
        this.id = id;
        this.nom = nom;
        this.prenom = prenom;
        this.numHomonyme = numHomonyme;
        this.type = type;
        this.IdIME = IdIME;
    }
    toString(){
        let test=this.IdIME;
        test=test.replace(',','!');
        let tmp = this.id+"?"+this.nom+"?"+this.prenom+"?"+this.numHomonyme+"?"+this.type+"?"+this.IdIME.replace(",","!");
        return tmp;
    }

    static decode(ListePersonne){
        let ListeFinal= new Array();
        
        let listeNom = ListePersonne.split(";");
        
        for (let index = 0; index < listeNom.length; index++) {
            let attribut = listeNom[index].split("?");
            let ListeIME = attribut[5].split("!");
            let IMEtoString = ListeIME.toString();
            let eleve = new Personne(attribut[0],attribut[1],attribut[2],attribut[3],attribut[4],IMEtoString);
            ListeFinal.push(eleve);
        }
    
        return ListeFinal;
    }
    static encode(ListePersonne){
        let ListeFinal= "";
        for (let index = 0; index < ListePersonne.length; index++) {
            ListeFinal=ListeFinal+ListePersonne[index].toString()+";";
        }
        ListeFinal=ListeFinal.slice(0, -1);
        return ListeFinal;
    }
}