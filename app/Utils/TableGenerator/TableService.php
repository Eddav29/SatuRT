<?php

namespace App\Utils\TableGenerator;

use InvalidArgumentException;

class TableService
{
    public array $kriteria;
    public array $bobot;
    public array $tipe;
    public array $alternatif;

    public function __construct($kriteria, $bobot, $tipe, $alternatif)
    {
        $this->kriteria = $kriteria;
        $this->bobot = $bobot;
        $this->tipe = $tipe;
        $this->alternatif = $alternatif;
    }

    public function createTable($data, bool $bobot = true): string
    {
        $tableData = '';
        $tableHeader = '';

        // Check if the data is an array of arrays
        if (!empty($data) && is_array($data) && is_array($data[1]) && is_numeric(array_keys($data[1])[1])) {
            // Generate table header for array of arrays
            // Generate table header for array of arrays
            $tableHeader .= '<thead>';
            $tableHeader .= '<tr class="border border-black">';
            $tableHeader .= "<th class='border border-black' rowspan='" . ($bobot ? 4 : 2) . "'>Alternatif</th>";
            $tableHeader .= '<th class="border border-black" colspan="' . count($this->kriteria) . '">Kriteria</th>';
            $tableHeader .= '</tr>';
            $tableHeader .= '<tr class="border border-black">';
            foreach ($this->kriteria as $key => $value) {
                $tableHeader .= "<th class='border border-black'>$value</th>";
            }
            $tableHeader .= '</tr>';
            if ($bobot) {
                $tableHeader .= '<tr class="border border-black">';
                $tableHeader .= '<th class="border border-black" colspan="' . count($this->bobot) . '">Bobot</th>';
                $tableHeader .= '</tr>';
                $tableHeader .= '<tr class="border border-black">';
                foreach ($this->bobot as $key => $value) {
                    $tableHeader .= "<th class='border border-black'>$value</th>";
                }
                $tableHeader .= '</tr>';
            }
            $tableHeader .= '</thead>';

            // Generate table body for array of arrays
            $tableData .= '<tbody class="border border-black">';
            foreach ($this->alternatif as $key => $value) {
                $tableData .= '<tr class="border border-black">';
                $tableData .= "<td class='border border-black text-left'>$value</td>";
                foreach ($data[$key] as $value) {
                    $tableData .= "<td class='border border-black text-center'>$value</td>";
                }
                $tableData .= '</tr>';
            }
            $tableData .= '</tbody>';
        }
        // Check if the data is an associative array
        elseif (!empty($data) && is_array($data) && is_array($data[1]) && is_string(array_keys($data[1])[1])) {
            // Generate table header for associative array
            $tableHeader .= '<thead><tr class="border border-black">';
            foreach (array_keys($data[0]) as $key) {
                $tableHeader .= "<th class='border border-black'>$key</th>";
            }
            $tableHeader .= '</tr></thead>';

            // Generate table body for associative array
            $tableData .= '<tbody class="border border-black">';
            foreach ($data as $rowData) {
                $tableData .= '<tr class="border border-black">';
                foreach ($rowData as $value) {
                    $tableData .= "<td class='border border-black text-center'>$value</td>";
                }
                $tableData .= '</tr>';
            }
            $tableData .= '</tbody>';
        }
        // Check if the data is an array of strings
        elseif (!empty($data) && is_array($data) && is_string($data[1])) {
            // Generate table header for array of arrays
            $tableHeader .= '<thead>';
            $tableHeader .= '<tr class="border border-black">';
            $tableHeader .= "<th class='border border-black' rowspan='" . ($bobot ? 4 : 2) . "'>Alternatif</th>";
            $tableHeader .= '<th class="border border-black" colspan="' . count($this->kriteria) . '">Kriteria</th>';
            $tableHeader .= '</tr>';
            $tableHeader .= '<tr class="border border-black">';
            foreach ($this->kriteria as $key => $value) {
                $tableHeader .= "<th class='border border-black'>$value</th>";
            }
            $tableHeader .= '</tr>';
            if ($bobot) {
                $tableHeader .= '<tr class="border border-black">';
                $tableHeader .= '<th class="border border-black" colspan="' . count($this->bobot) . '">Bobot</th>';
                $tableHeader .= '</tr>';
                $tableHeader .= '<tr class="border border-black">';
                foreach ($this->bobot as $key => $value) {
                    $tableHeader .= "<th class='border border-black'>$value</th>";
                }
                $tableHeader .= '</tr>';
            }
            $tableHeader .= '</thead>';

            // Generate table body for array of strings
            $tableData .= '<tbody class="border border-black">';
            foreach ($this->alternatif as $key => $value) {
                $tableData .= '<tr class="border border-black">';
                $tableData .= "<td class='border border-black text-center'>$value</td>";
                foreach ($data as $value) {
                    $tableData .= "<td class='border border-black text-center'>$value</td>";
                }
                $tableData .= '</tr>';
            }
            $tableData .= '</tbody>';
        } elseif (!empty($data) && is_array($data) && !is_array($data[0])) {
            // Generate table body for array of strings
            $tableData .= '<tbody class="border border-black">';
            $tableData .= '<tr class="border border-black">';
            foreach ($data as $value) {
                $tableData .= "<td class='border border-black text-center'>$value</td>";
            }
            $tableData .= '</tr>';
            $tableData .= '</tbody>';
        } else {
            throw new InvalidArgumentException("Unsupported data format");
        }

        // Combine table header and table body
        $tableMarkup = "
            <table class='border'>
                $tableHeader
                $tableData
            </table>
        ";

        return $tableMarkup;
    }
}
