<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;

function getElementText($element): string {
    $text = '';

    if ($element instanceof Text) {
        $text .= $element->getText();
    } elseif ($element instanceof TextRun) {
        foreach ($element->getElements() as $child) {
            $text .= getElementText($child) . ' ';
        }
    }
    return trim($text);
}

function getColumnValue(array $rowData, array $headerMap, array $possibleNames): ?string {
    foreach ($possibleNames as $name) {
        if (isset($headerMap[$name])) {
            $idxs = (array)$headerMap[$name];
            foreach ($idxs as $i) {
                if (!empty($rowData[$i])) return $rowData[$i];
            }
        }
    }
    return null;
}


function loadCourses(string $filePath, array &$courses) {
    $phpWord = IOFactory::load($filePath);

    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if (!($element instanceof Table)) {
                continue;
            }

            $rows = $element->getRows();
            if (count($rows) < 3) {
                continue;
            }

            $tableData = [];
            foreach ($rows as $row) {
                $rowData = [];
                foreach ($row->getCells() as $cell) {
                    $cellText = '';
                    foreach ($cell->getElements() as $cellElement) {
                        $cellText .= getElementText($cellElement) . ' ';
                    }
                    $rowData[] = trim($cellText);
                }

                $joinedRow = implode(' ', $rowData);
                if (stripos($joinedRow, 'ukupno') !== false) {
                    continue; 
                }

                $tableData[] = $rowData;
            }

            foreach ($tableData as $r) {
                if (!empty($r[0]) && !empty($r[1]) && is_numeric(end($r))) {
                    $courses[] = [
                        "Šifra predmeta" => $r[0] ?? '',
                        "Naziv predmeta" => $r[1] ?? '',
                        "Status"         => $r[2] ?? '',
                        "Semestar"       => $r[3] ?? '',
                        "P"              => $r[4] ?? 0,
                        "V"              => $r[5] ?? 0,
                        "L"              => $r[6] ?? 0,
                        "ECTS"           => $r[7] ?? 0
                    ];
                }
            }
        }
    }
}


function loadCoursesWithGrades(string $filePath, array &$courses)
{
    $phpWord = IOFactory::load($filePath);

    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            if (!($element instanceof Table)) continue;

            $rows = $element->getRows();
            $headerMap = [];
            $headerRowFound = false;

            foreach ($rows as $row) {
                $rowData = [];
                foreach ($row->getCells() as $cell) {
                    $cellText = '';
                    foreach ($cell->getElements() as $cellElement) {
                        $cellText .= getElementText($cellElement) . ' ';
                    }
                    $rowData[] = trim(preg_replace('/\s+/', ' ', $cellText));
                }

                $rowData = array_values(array_filter($rowData, fn($v) => $v !== ''));

                if (!$headerRowFound) {
                    $normalized = array_map(fn($v) => strtolower(trim($v)), $rowData);
                    
                    if (count(array_intersect($normalized, ['term', 'semester', 'course', 'subject', 'title', 'grade', 'ects', 'credits', 'points'])) >= 2) {
                        foreach ($normalized as $i => $header) {
                            $headerMap[$header][] = $i;
                        }
                        $headerRowFound = true;
                    }
                    continue;
                }

                if (!$headerRowFound) continue;

                $gradeCandidates = $headerMap['grade'] ?? [];
                $gradeLetter = null;
                foreach ($gradeCandidates as $colIdx) {
                    $value = $rowData[$colIdx] ?? null;
                    if ($value && preg_match('/^[A-F][+-]?$/i', trim($value))) {
                        $gradeLetter = strtoupper(trim($value));
                        break;
                    }
                }

                $term = getColumnValue($rowData, $headerMap, ['term', 'semester']);
                $course = getColumnValue($rowData, $headerMap, ['course', 'subject', 'title']);
                $ects = getColumnValue($rowData, $headerMap, ['ects', 'credits', 'points']);

                if ($course && $gradeLetter) {
                    $courses[] = [
                        'Term' => $term,
                        'Course' => $course,
                        'Grade' => $gradeLetter,
                        'ECTS' => $ects,
                    ];
                }
            }
        }
    }
}



$courses = [];
//loadCourses('1. NPP-osnovne.docx', $courses);
//loadCoursesWithGrades('3. ToR primjer.docx', $courses);

echo "<pre>";
print_r($courses);
echo "</pre>";

?>