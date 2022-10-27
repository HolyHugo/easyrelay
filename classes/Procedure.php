<?php


class Procedure
{
    const RISQUE_HEMO_FAIBLE = 1;
    const RISQUE_HEMO_MODERE_ELEVE = 2;
    const RISQUE_HEMO_TRES_ELEVE = 3;
    const MATIN = "T1";
    const MIDI = "T2";
    const APRES_MIDI = "T3";
    const SOIR = "T4";
    const NUIT = "T5";

    protected string    $traitement;
    protected string    $familleTraitement;
    protected int       $risqueHemorragique;
    protected int       $risqueThrombose;
    protected int       $fonctionRenale;
    protected DateTime  $dateJour;
    protected DateTime  $dateIntervention;
    private DateTime $dateArret;
    private DateTime $dateReprise;

    public function __construct(
        string $traitement,
        string $familleTraitement,
        int $risqueHemorragique,
        int $risqueThrombose,
        int $fonctionRenale,
        DateTime $dateJour,
        DateTime $dateIntervention
    ) {
        $this->traitement = $traitement;
        $this->familleTraitement = $familleTraitement;
        $this->risqueHemorragique = $risqueHemorragique;
        $this->risqueThrombose = $risqueThrombose;
        $this->fonctionRenale = $fonctionRenale;
        $this->dateJour = $dateJour;
        $this->dateIntervention = $dateIntervention;
        $this->dateArret =  clone $dateIntervention;
        $this->dateReprise = clone $dateIntervention;
    }

    public function getInformations(): array
    {
        $preOpInfos = [];
        switch ($this->familleTraitement) {
            case "AOD":
                $preOpInfos = $this->preOpAOD();
                $inOpInfos = $this->inOpAOD();
                $postOpInfos = $this->postOpAOD();
                break;

            case "AVK":
                break;
        }
        return ['preOp' => $preOpInfos, 'inOp' => $inOpInfos, 'postOp' => $postOpInfos];
    }

    public function besoinRelais(): bool
    {
        return false;
    }

    public function getRepriseAC()
    {
    }


    private function preOpAOD()
    {
        $arret = [];
        switch ($this->risqueHemorragique) {
            case self::RISQUE_HEMO_FAIBLE:
                $arret = [
                    'arret' => true, 'd-arret' => $this->dateArret->modify('-1 day'), 'relais' => $this->besoinRelais(), 'l-arret' => 'J-1',
                    'description' => "Pas d'AOD la veille au soir.",
                ];
                break;
            case self::RISQUE_HEMO_MODERE_ELEVE:

                break;
            case self::RISQUE_HEMO_TRES_ELEVE:
                break;
        }
        return $arret;
    }

    private function inOpAOD()
    {
        $inOp = [];
        switch ($this->risqueHemorragique) {
            case self::RISQUE_HEMO_FAIBLE:
                $inOp = [
                    'description' => "Pas d'AOD le matin de l'intervention.",
                ];
                break;
            case self::RISQUE_HEMO_MODERE_ELEVE:

                break;
            case self::RISQUE_HEMO_TRES_ELEVE:
                break;
        }
        return $inOp;
    }


    private function postOpAOD()
    {
        $postOp = [];
        switch ($this->risqueHemorragique) {
            case self::RISQUE_HEMO_FAIBLE:
                $postOp = [
                    'reprise' => true,
                    'l-reprise' => 'J-0',
                    'description' => "Reprise de l'AOD à l'heure habituelle au moins 6h post opération",
                ];
                break;
            case self::RISQUE_HEMO_MODERE_ELEVE:

                break;
            case self::RISQUE_HEMO_TRES_ELEVE:
                break;
        }
        return $postOp;
    }
}
