<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerConfusionMatrix extends Controller
{
    public const MICRO_AVERAGE = 1;

    public const MACRO_AVERAGE = 2;

    public const WEIGHTED_AVERAGE = 3;

    /**
     * @var array
     */
    private $truePositive = [];

    /**
     * @var array
     */
    private $falsePositive = [];

    /**
     * @var array
     */
    private $falseNegative = [];

    /**
     * @var array
     */
    private $support = [];

    /**
     * @var array
     */
    private $precision = [];

    /**
     * @var array
     */
    private $recall = [];

    /**
     * @var array
     */
    private $f1score = [];

    /**
     * @var array
     */
    private $average = [];

    public function __construct(array $actualLabels, array $predictedLabels, int $average = self::MACRO_AVERAGE)
    {
        $averagingMethods = range(self::MICRO_AVERAGE, self::WEIGHTED_AVERAGE);
        if (!in_array($average, $averagingMethods, true)) {
            throw new InvalidArgumentException('Averaging method must be MICRO_AVERAGE, MACRO_AVERAGE or WEIGHTED_AVERAGE');
        }

        $this->aggregateClassificationResults($actualLabels, $predictedLabels);
        $this->computeMetrics();
        $this->computeAverage($average);
    }

    public function getPrecision(): array
    {
        return $this->precision;
    }

    public function getRecall(): array
    {
        return $this->recall;
    }

    public function getF1score(): array
    {
        return $this->f1score;
    }

    public function getSupport(): array
    {
        return $this->support;
    }

    public function getAverage(): array
    {
        return $this->average;
    }

    private function aggregateClassificationResults(array $actualLabels, array $predictedLabels): void
    {
        $truePositive = $falsePositive = $falseNegative = $support = self::getLabelIndexedArray($actualLabels, $predictedLabels);

        foreach ($actualLabels as $index => $actual) {
            $predicted = $predictedLabels[$index];
            ++$support[$actual];

            if ($actual === $predicted) {
                ++$truePositive[$actual];
            } else {
                ++$falsePositive[$predicted];
                ++$falseNegative[$actual];
            }
        }

        $this->truePositive = $truePositive;
        $this->falsePositive = $falsePositive;
        $this->falseNegative = $falseNegative;
        $this->support = $support;
    }

    private function computeMetrics(): void
    {
        foreach ($this->truePositive as $label => $tp) {
            $this->precision[$label] = $this->computePrecision($tp, $this->falsePositive[$label]);
            $this->recall[$label] = $this->computeRecall($tp, $this->falseNegative[$label]);
            $this->f1score[$label] = $this->computeF1Score((float) $this->precision[$label], (float) $this->recall[$label]);
        }
    }

    private function computeAverage(int $average): void
    {
        switch ($average) {
            case self::MICRO_AVERAGE:
                $this->computeMicroAverage();

                return;
            case self::MACRO_AVERAGE:
                $this->computeMacroAverage();

                return;
            case self::WEIGHTED_AVERAGE:
                $this->computeWeightedAverage();

                return;
        }
    }

    private function computeMicroAverage(): void
    {
        $truePositive = (int) array_sum($this->truePositive);
        $falsePositive = (int) array_sum($this->falsePositive);
        $falseNegative = (int) array_sum($this->falseNegative);

        $precision = $this->computePrecision($truePositive, $falsePositive);
        $recall = $this->computeRecall($truePositive, $falseNegative);
        $f1score = $this->computeF1Score((float) $precision, (float) $recall);

        $this->average = compact('precision', 'recall', 'f1score');
    }

    private function computeMacroAverage(): void
    {
        foreach (['precision', 'recall', 'f1score'] as $metric) {
            $values = $this->{$metric};
            if (count($values) == 0) {
                $this->average[$metric] = 0.0;

                continue;
            }

            $this->average[$metric] = array_sum($values) / count($values);
        }
    }

    private function computeWeightedAverage(): void
    {
        foreach (['precision', 'recall', 'f1score'] as $metric) {
            $values = $this->{$metric};
            if (count($values) == 0) {
                $this->average[$metric] = 0.0;

                continue;
            }

            $sum = 0;
            foreach ($values as $i => $value) {
                $sum += $value * $this->support[$i];
            }

            $this->average[$metric] = $sum / array_sum($this->support);
        }
    }

    /**
     * @return float|string
     */
    private function computePrecision(int $truePositive, int $falsePositive)
    {
        $divider = $truePositive + $falsePositive;
        if ($divider == 0) {
            return 0.0;
        }

        return round(($truePositive / $divider)*100,2);
    }

    /**
     * @return float|string
     */
    private function computeRecall(int $truePositive, int $falseNegative)
    {
        $divider = $truePositive + $falseNegative;
        if ($divider == 0) {
            return 0.0;
        }

        return round(($truePositive / $divider)*100,2);
    }

    private function computeF1Score(float $precision, float $recall): float
    {
        $divider = $precision + $recall;
        if ($divider == 0) {
            return 0.0;
        }

        return 2.0 * (($precision * $recall) / $divider);
    }

    private static function getLabelIndexedArray(array $actualLabels, array $predictedLabels): array
    {
        $labels = array_values(array_unique(array_merge($actualLabels, $predictedLabels)));
        sort($labels);

        return (array) array_combine($labels, array_fill(0, count($labels), 0));
    }

    public static function compute(array $actualLabels, array $predictedLabels, array $labels = []): array
    {
        $labels = count($labels) === 0 ? self::getUniqueLabels($actualLabels) : array_flip($labels);
        $matrix = self::generateMatrixWithZeros($labels);

        foreach ($actualLabels as $index => $actual) {
            $predicted = $predictedLabels[$index];

            if (!isset($labels[$actual], $labels[$predicted])) {
                continue;
            }

            if ($predicted === $actual) {
                $row = $column = $labels[$actual];
            } else {
                $row = $labels[$actual];
                $column = $labels[$predicted];
            }

            ++$matrix[$row][$column];
        }

        return $matrix;
    }

    private static function generateMatrixWithZeros(array $labels): array
    {
        $count = count($labels);
        $matrix = [];

        for ($i = 0; $i < $count; ++$i) {
            $matrix[$i] = array_fill(0, $count, 0);
        }

        return $matrix;
    }

    private static function getUniqueLabels(array $labels): array
    {
        $labels = array_values(array_unique($labels));
        sort($labels);

        return array_flip($labels);
    }

    /**
     * @return float|int
     *
     * @throws InvalidArgumentException
     */
    public static function score(array $actualLabels, array $predictedLabels, bool $normalize = true)
    {
        if (count($actualLabels) != count($predictedLabels)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $score = 0;
        foreach ($actualLabels as $index => $label) {
            if ($label == $predictedLabels[$index]) {
                ++$score;
            }
        }

        if ($normalize) {
            $score /= count($actualLabels);
        }

        return $score;
    }

    public static function error_rate(array $actualLabels, array $predictedLabels, bool $normalize = true)
    {
        if (count($actualLabels) != count($predictedLabels)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $score = 0;
        foreach ($actualLabels as $index => $label) {
            if ($label != $predictedLabels[$index]) {
                ++$score;
            }
        }

        if ($normalize) {
            $score /= count($actualLabels);
        }

        return $score;
    }
}