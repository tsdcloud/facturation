<?php

namespace App\Services;
use setasign\Fpdi\Fpdi;
class InvoiceService extends Fpdi
{

    public function Header(){
        $this->Image(public_path('assets\images\logo\logo-dpws.png'),05,05,30);
        $this->Ln(3);

        $this->Image(public_path('\assets\images\logo\lotecs.png'),15,109,17);
        $this->Image(public_path('\assets\images\signature.png'),05,92,38);

        // $this->Image(public_path('assets\images\logo\logo-dpws.png'),65,90,60);
    }

//     function RotatedImage($file,$x,$y,$w,$h,$angle)
// {
//     //Image rotated around its upper-left corner
//     $this->Rotate($angle,$x,$y);
//     $this->Image($file,$x,$y,$w,$h);
//     $this->Rotate(0);
// }

    public static function invoiceBuilder($data,$type){

        $pdf = new InvoiceService('P','mm','A4');
        $pdf->SetMargins(05,02,1); // starting margin
        $pdf->AddPage();
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(200 ,5,utf8_decode('FACTURE ACQUITTEE N° '.$data->invoice_no),0,0,'R');
        $pdf->Ln(10);
        $pdf->Cell(200 ,5,utf8_decode('Date :'.$data->created_at->format('d/m/y h:m:s')),0,0,'R');
        $pdf->Cell(-173 ,10,utf8_decode('www.dpws.cm'),0,0,'R');
        $pdf->Ln(10);
        $pdf->Cell(200 ,5,utf8_decode('Pont bascule '.$data->weighbridge->label),0,0,'R');
        $pdf->SetFont('Arial','',10);
        $pdf->Ln(20);
        $pdf->Cell(20,10,utf8_decode('Reçu de '),0,0,'L');
        $pdf->Cell(60,10,utf8_decode($data->name),0,0,'L');
        $pdf->Ln(10);
        $pdf->Cell(99,10,utf8_decode('Droit de pesage attelage : N° Tracteur '.$data->tractor),0,0,'L');
        $pdf->Cell(85,10,utf8_decode('N° Remorque '.$data->trailer),0,0,'L');
        $pdf->Ln(10);
        $pdf->Cell(35,10,utf8_decode('Mode de paiment : '),0,0,'L');
        $pdf->Cell(80,10,utf8_decode($data->modePayment->label),0,0,'L');
        $pdf->Ln(10);
        $pdf->Cell(138,10,utf8_decode('Chef de Guerite'),0,0,'L');
        // $pdf->Cell(400,10,utf8_decode($data->user->name),0,0,'L'); 
        $pdf->text(41,81,utf8_decode($data->user->name));
        // $pdf->Cell(80,10,utf8_decode('Montant HT :  FCFA '),0,0,'L');
       // $pdf->Ln(10);
        $pdf->text(144,98,utf8_decode('TVA 19.25% :  FCFA'));
        $pdf->text(144,104,utf8_decode('Montant TTC :  FCFA'));
        $pdf->text(144,110,utf8_decode('Montant versé : '.$data->amount_paid.' FCFA'));
        $pdf->text(06,90,utf8_decode('Signature et cachet'));
        $pdf->text(144,116,utf8_decode('Montant à rembourser : '.$data->remains.' FCFA'));
        $pdf->Ln(50);
        $pdf->Line(2,125,205,125);
        $pdf->SetFont('Arial','',9);
        $pdf->text(05,130,utf8_decode('Douala Port Weighing Services SAS CAPITAL VARIABLE DE 50 000 000 XAF RCCM RC / DLA / 2019 / b / 5453 NUI M121914355936 L'));
        $pdf->text(05,135,utf8_decode('Siège Social : Bonapriso, Lieu dit Ancien dépôt Guinness - Douala B.P 12209 00237 650 911 000/ 695 502 502 contact@dpws.cm dpws.cm'));
        $pdf->text(05,140,utf8_decode('Compte Afriland First Bank réf : 10005 00002 06463841002 52 swift : cceicmcx iban : cm21 100005 0000206463841002 52'));

        if ($type == "preview")
          return $pdf->Output('','Facture '.$data->created_at.'.pdf','I');
    }
}