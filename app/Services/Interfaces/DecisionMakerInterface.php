<?php

namespace App\Services\Interfaces;

interface DecisionMakerInterface {
    public function getKriteria();
    public function getBobot();
    public function getTipe();
    public function getAlternatifs();
    public function getData();

    public function getKriteriaNama(int $id);
    public function getAlternatifNama(int $id);
    public function getBobotValue(int $id);
    public function getTipeValue(int $id);
    public function getAlternatifValue(int $criteriaId, int $alternatifId);

    public function getKriteriaIndex(string $name);
    public function getAlternatifIndex(string $name);
    public function getBobotIndex(string $name);
    public function getTipeIndex(string $name);

    public function getKriteriaCount();
    public function getAlternatifCount();
    public function getBobotCount();
    public function getTipeCount();
}
