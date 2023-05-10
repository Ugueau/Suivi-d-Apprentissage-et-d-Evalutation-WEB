<?php
require('FPDF/fpdf.php');

class pdfManager extends FPDF {
    function hexToRgb($hex, $alpha=false){
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ( $alpha ) {
            $rgb['a'] = $alpha;
        }
        return $rgb;
    }
    function header() {
        $this->Image(__DIR__ . '/../www/img/logo3D.png', 10, 10, 32, 32);
        //$this->SetFont('Reem Kufi');
        $this->SetFont('Arial', 'B', 30);
        $darkBlue = $this->hexToRgb(DARK_BLUE);
        $this->SetTextColor($darkBlue['r'], $darkBlue['g'], $darkBlue['b']);
        $this->Text($this->GetPageWidth()/3, 23, utf8_decode("Suivi d'Apprentissage"));
        $this->Text($this->GetPageWidth()/3+20, 38, utf8_decode("et d'Évaluation"));
        $this->Ln(20);
    }

    function printDest($nom, $prenom, $ime, $for_student) {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0);
        $this->setXY(30, 60);
        $this->Write(3, utf8_decode("Ce document est à délivrer à "));
        $this->SetFont('Arial', 'B', 12);
        $prenom_length = strlen($prenom);
        $prenom = substr($prenom, 0, 1);
        for($i = 0; $i < $prenom_length-1; $i++){
            $prenom = $prenom.'*';
        }
        $prenom = ucfirst($prenom);
        $this->Write(3, utf8_decode(strtoupper($nom).' '.$prenom));
        $this->SetFont('Arial', '', 12);
        if($for_student) $this->Write(4, utf8_decode(" (Il peut également être délivré à son ou ses responsables légaux)."));

        if($ime != null) {
            $this->SetXY(110, 80);
            $this->Write(4, "IME: ");
            $this->SetFont('Arial', 'B', 12);
            $this->Write(4, utf8_decode($ime));
        }

    }

    function printInformations($code){
        $this->SetFont('Arial', '', 12);
        $this->setXY(20, 100);
        $this->Write(3, utf8_decode("Vous venez de recevoir vos identifiants de connexion : Suivi d'Apprentissage et d'Évaluation.
                                    \nL'objectif de ce service est de faciliter l'apprentissage dans les instituts médico-éducatifs
                                    \nPour vous créer votre espace, rendez-vous sur le site web:"));
        $this->SetFont('Arial', 'B', 12);
        $this->setXY(0, 115);
        $this->Cell($this->GetPageWidth(), 15, "sae-ime.ovh", 0, 0, 'C', false);
        $this->setXY(20, 140);
        $this->SetFont('Arial', '', 12);
        $this->Write(3, utf8_decode("1. Cliquez sur 'Première connexion ? S'inscrire'"));
        $this->setXY(20, 150);
        $this->Write(3, utf8_decode("2. Dans le champ 'nom', Entrez votre nom complet"));
        $this->setXY(20, 160);
        $this->Write(3, utf8_decode("3. Dans le champ 'prénom', entrez votre prénom complet"));
        $this->setXY(20, 170);
        $this->Write(3, utf8_decode("4. Dans le champ 'code', entrez le code suivant: "));
        $this->SetFont('Arial', 'B', 12);
        $this->Write(3, utf8_decode($code));
        $this->SetFont('Arial', '', 12);
        $this->setXY(20, 180);
        $this->Write(3, utf8_decode("5. Définissez votre mot de passe (différent du code ci-dessus)."));
        
    }

    function footer(){
        $this->SetFont('Arial', 'I', 8);
        $this->setXY(10, -50);
        $this->Write(2, utf8_decode("Vous pouvez, à tout moment, appliquer n'importe lequel de vos droits relatifs à vos données (RGPD). Ces droits sont la suppression, la modification, 
                                    \nle refus, la communication, la limitation de vos données. Vous pouvez faire usage de certain de ces droits directement depuis l'application. Pour toutes 
                                    \ninformations complémentaires sur la protection des données ou vous désincrire du système, contactez l'APAJH ou votre IME de référence par 
                                    \ntéléphone ou mail (ci-dessous).
                                    \n\nMail: ".MAIL_ADDRESS."
                                    \nTél: ".PHONE_NUMBER));
    }

    function generate($nom, $prenom, $code, $ime, $for_student){
        $this->header();
        $this->printDest($nom, $prenom, $ime, $for_student);
        $this->printInformations($code);
        $this->footer();
    }
}

function  generatePDF($nom, $prenom, $code, $ime = null, $for_student = false){
    $pdf = new pdfManager();
    $pdf->AddPage();
    $pdf->generate($nom, $prenom, $code, $ime, $for_student);
    $pdf->Output('D', 'SAE_'.$nom.'_'.substr($prenom, 0, 1).'.pdf', true);
}