<?php

const SEQUENCE_LENGTH = 10;

const MIN_SEQUENCE_VALUE = -10000;

const MAX_SEQUENCE_VALUE = 1000;

function isNonDecreasingSequence(array $arr): void
{
    $length = count($arr);
    for ($i = 1; $i < $length; $i++) {
        if ($arr[$i] < $arr[$i -1]) {
            echo 'Sequence is not non-decreasing';
            exit;
        }
    }
}

function isDataCorrect(array $arr, array $powArr): void
{
    foreach ($arr as $value) {
        if (
            count(array_keys($arr, abs($value))) + ($value < 0 ? count(array_keys($arr, $value)) : 0) 
            != count(array_keys($powArr, $value**2))
        ) {
            echo 'Data is not correct';
            exit;
        }
    }
}

function getFirstNotNegativeIndex(array $inputArr): int
{
    $inputLength = count($inputArr);
    $middle = intdiv($inputLength, 2);
    $leftSearchBound = 0;
    $rightSearchBound = $inputLength -1;
    $firstNotNegativeIndex = $inputLength;
    while (($rightSearchBound - $leftSearchBound) >= 0) {
        if ($inputArr[$middle] >= 0) {
            $rightSearchBound = $middle -1;
            $firstNotNegativeIndex = $middle;
        } else {
            $leftSearchBound = $middle + 1;
        }
        $middle = intdiv($rightSearchBound - $leftSearchBound, 2) + $leftSearchBound;
    }

    return $firstNotNegativeIndex;
}

function processArray(array &$inputArr): void
{
    $inputLength = count($inputArr);
    $firstNotNegativeIndex = getFirstNotNegativeIndex($inputArr);
    $negativeArray = array_reverse(array_slice($inputArr, 0 , $firstNotNegativeIndex));
    $negativeLength = count($negativeArray);
    $negativeKey = 0;
    $positiveKey = $firstNotNegativeIndex;
    foreach ($inputArr as $key => $value) {
        if (
            $positiveKey >= $inputLength
            || ($negativeKey < $negativeLength) && (abs($negativeArray[$negativeKey]) < $inputArr[$positiveKey])
        ) {
            $inputArr[$key] = $negativeArray[$negativeKey]**2;
            $negativeKey++;
        } else {
            $inputArr[$key] = $inputArr[$positiveKey]**2;
            $positiveKey++;
        }
    }
}

function generateNonDecreasingSequence(int $sequenceLength, int $minSequenceValue, int $maxSequenceValue): array
{
    $inputArr = $sequenceLength ? [$minSequenceValue] : [];
    for ($i = 1; $i < $sequenceLength; $i++) {
        $inputArr[$i] = rand($inputArr[($i - 1)], $maxSequenceValue);
    }

    return $inputArr;
}

$inputArr = generateNonDecreasingSequence(
    SEQUENCE_LENGTH,
    MIN_SEQUENCE_VALUE,
    MAX_SEQUENCE_VALUE,
);
isNonDecreasingSequence($inputArr);
$testInputArr = $inputArr;
print_r($inputArr);
processArray($inputArr);
print_r($inputArr);
isNonDecreasingSequence($inputArr);
isDataCorrect($testInputArr, $inputArr);
