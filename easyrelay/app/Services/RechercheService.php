<?php

namespace App\Services;

use DateTime;
use IntlDateFormatter;
use Pb\Client as pb;

class RechercheService
{

    const PERIODE_PRE_OP = 'infos_preop';
    const PERIODE_IN_OP = 'infos_inop';
    const PERIODE_POST_OP = 'infos_postop';

    private $pb;

    public function __construct()
    {
        $this->pb = new pb(env('PB_URL'));
    }
    /**
     * @return array 
     */
    public function getTraitementsList(): array
    {
        $listeTraitements = [];
        $traitements = $this->pb->collection('traitement')->getFullList()['items'];
        $familles_traitements = $this->pb->collection('famille_traitement')->getFullList()['items'];
        foreach ($familles_traitements as $famille) {
            foreach ($traitements as $traitement) {
                if ($traitement['famille'] === $famille['id']) {
                    $listeTraitements[$famille['libelle']][] = ['value' => $traitement['famille'] . '-' .  $traitement['id'], 'text' => $traitement['libelle']];
                }
            }
        }
        return $listeTraitements;
    }

    /**
     * @param string $collection 
     * @param string $id 
     * @return array|object
     */
    public function getRecordsList(String $collection, String $id = '')
    {
        $listeRecords = [];
        if ($id !== '') {
            $records = $this->pb->collection($collection)->getOne($id);
            $listeRecords[$collection] = $records['libelle'];
            return $listeRecords;
        }
        $records = $this->pb->collection($collection)->getFullList()['items'];
        foreach ($records as $key => $value) {
            $listeRecords[$value['id']] = $value['libelle'];
        }
        return $listeRecords;
    }

    /**
     * @param string $filter 
     * @return array|bool
     */
    public function getScenario(String $filter)
    {
        return $this->pb->collection('scenario')->getFullList(200,[$filter])['items'] ?? [];
    }


    /**
     * @param string $scenario 
     * @param string $periode 
     * @return array 
     */
    public function getScenarioInfos(String $scenario, String $periode, IntlDateFormatter $formatter, DateTime $dateIntervention)
    {
        $infosDone = [];
        $filter = "scenario ~ '$scenario'";
        $infos = $this->pb->collection($periode)->getFullList(200,['filter'=> $filter])['items'] ?? [];
        if ($periode != self::PERIODE_IN_OP  &&  !empty($infos)) {
            foreach ($infos as $info) {
                $dateJ = clone $dateIntervention;
                $info['dateJ'] = $info['date_modifier'] != '' ? $formatter->format($dateJ->modify($info['date_modifier'])) : $formatter->format($dateJ);
                $infosDone[] = $info;
            }
            $infos = $infosDone;
        }
        return $infos;
    }

    /**
     * @param array $postData 
     * @param bool $modeFamille 
     * @return string 
     */
    public function createFilter(array $postData)
    {
        list($famille_traitement, $traitement) = explode('-', $postData['traitement']);
        $fonctionRenale = $postData['fonction-renale'] ?? '';
        $filtrerValues = [
            $postData['risque-hemorragique'],
            $traitement,
            $famille_traitement,
            $postData['urgence'],
            $postData['risque-thrombotique'],
            $fonctionRenale
        ];
        $filtrerString = "risque_hemorragique='%s' '&''&' traitement ~ '%s' '&''&' famille_traitement = '%s' '&''&' urgence='%s' '&''&' risque_thrombotique ~ '%s' '&''&' debit_renal ~ '%s'";
        return vsprintf($filtrerString, $filtrerValues);
    }



    /**
     * @param array $postData 
     * @param array $scenario 
     * @return array 
     */
    public function prepareInfos(array $postData, array $scenario): array
    {
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'Europe/Paris',
            IntlDateFormatter::GREGORIAN
        );
        $dateJour = DateTime::createFromFormat('Y-m-d', $_POST['date_jour']);
        $dateIntervention = DateTime::createFromFormat('Y-m-d', $_POST['date_intervention']);
        $preOpInfos = self::getScenarioInfos($scenario['id'], self::PERIODE_PRE_OP, $formatter, $dateIntervention);
        $inOpInfos = self::getScenarioInfos($scenario['id'], self::PERIODE_IN_OP, $formatter, $dateIntervention);
        $postOpInfos = self::getScenarioInfos($scenario['id'], self::PERIODE_POST_OP, $formatter, $dateIntervention);

        $dateJour = $formatter->format($dateJour);
        $dateIntervention = $formatter->format($dateIntervention);

        return [
            'date_jour' => $dateJour,
            'date_intervention' => $dateIntervention,
            'preOpInfos' => $preOpInfos,
            'inOpInfos' => $inOpInfos,
            'postOpInfos' => $postOpInfos,
            'formatter' => $formatter
        ];
    }


    /**
     * @param array $postData 
     * @return array 
     */
    public function prepareCriteres(array $postData): array
    {
        $fonctionRenale = $risqueThrombotique = [];
        list($famille_traitement, $traitement) = explode('-', $postData['traitement']);
        $urgence = self::getRecordsList('urgence', $postData['urgence']);
        $risqueHemorragique = self::getRecordsList('risque_h', $postData['risque-hemorragique']);
        $traitement = self::getRecordsList('traitement', $traitement);
        $famille_traitement = self::getRecordsList('famille_traitement', $famille_traitement);
        if (($postData['fonction-renale'] ?? '') !== '') {
            $fonctionRenale = self::getRecordsList('debit_renal', $postData['fonction-renale']);
            $risqueThrombotique = self::getRecordsList('risque_t', $postData['risque-thrombotique']);
        };
        return array_merge($urgence, $risqueHemorragique, $fonctionRenale, $risqueThrombotique, $famille_traitement, $traitement);
    }
}
