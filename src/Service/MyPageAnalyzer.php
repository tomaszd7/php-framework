<?php

namespace MyApp\Service;

/**
 * Description of MyPageAnalyzer
 *
 * @author tomasz
 */
class MyPageAnalyzer
{
    private $fields;
    private $props;

    public function __construct(array $props)
    {
        $this->props = $props;
    }

    public function analyze(array $fields): bool
    {
        $this->fields = $fields;
        if ($this->props['analyzer'] === 'not exists') {
            return $this->analyzeAreNot();
        } else {
            return $this->analyzeAre();
        }
    }

    /*
     * if return true - send email as observed text has changed 
     */

    private function analyzeAre(): bool
    {
        foreach ($this->fields as $field) {
            if (strpos($field['title'], $this->props['parseTitle']) !== false &&
                    strpos($field['value'], $this->props['parseValue']) !== false) {
                return true;
            }
        }
        return false;
    }

    private function analyzeAreNot(): bool
    {
        foreach ($this->fields as $field) {
            if (strpos($field['title'], $this->props['parseTitle']) !== false &&
                    strpos($field['value'], $this->props['parseValue']) === false) {
                return true;
            }
        }
        return false;
    }

}
